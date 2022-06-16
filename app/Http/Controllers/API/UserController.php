<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeContract;
use App\Models\Mobile\MobileActivation;
use App\Models\Setting\Master;
use App\Models\Setting\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])
        ){
            $user = Auth::user();

            $userData = User::find($user->id);

            $data['token'] = $user->createToken('user')->accessToken;
            $data['user'] = $userData;
            $data['employee'] = DB::table('employees as t1')->join('employee_contracts as t2', function ($join){
                $join->on('t1.id', 't2.employee_id');
                $join->where('t2.status', 't');
            })->join('app_masters as t3', 't2.position_id', 't3.id')
                ->select('t1.id','t1.name', 't1.emp_number', 't1.photo', 't1.mobile_phone', 't3.name as positionName')
                ->where('t1.id', Auth::user()->employee_id)
                ->first();

            $location = Master::active()->where('category', "ELK");
            $defaultLocation = $location->orderBy('order', 'asc')->first();
            $empLocationByContract = EmployeeContract::active()->where('employee_id', Auth::user()->employee_id)->value('location_id');
            $data['employee']->access = $location->where('id', $empLocationByContract)->value('parameter') ?? $defaultLocation->parameter;
            $data['radius'] = $location->where('id', $empLocationByContract)->value('additional_parameter') ?? $this->getParameter('SRL');
            $data['user']->device_id = MobileActivation::where('user_id', $user->id)->where('status', 't')->value('device_id');
            $data['deviceDeveloper'] = $this->getParameter('MDV');
            $data['employee']->location_id = $location->where('id', $empLocationByContract)->value('code');

            return response()->json([
                "data" => $data,
                "message" => "student record created",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        $picture = uploadFile(
            $request->file('picture'),
            Str::slug($request->input('name')).'_'.time(),
            '/uploads/images/');
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->description = $request->description;
        $user->picture = $picture ?? $user->picture;
        $user->save();

        if($user){
            return response()->json([
                "data" => $user,
                "message" => "user updated successfully",
            ], 200);
        }else{
            return response()->json([
                "message" => "something went error",
            ], 500);
        }
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();


        return ResponseFormatter::success($user, 'Token Revoked');
    }

//    public function fetch()
//    {
//        $data['user'] = Auth::user();
//        $data['token'] = Auth::user()->currentAccessToken();
//
//        return ResponseFormatter::success($data, 'Success');
//    }

    public function users()
    {
        $users = User::get();

        return ResponseFormatter::success($users, 'Success');
    }

    public function userDetail($id)
    {
        $user = User::find($id);

        if($user){
            return response()->json([
                'message' => 'Success',
                'data' => $user,
            ]);
        }else{
            return ResponseFormatter::error($user, 'Failed, something wrong with that query', '500');
        }
    }

    public function activation(Request $request)
    {
        if(Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])
        ){
            $user = Auth::user();

            //DELETE ALL REQUEST ACTIVATION BEFORE WHERE STATUS NOT APPROVE
            MobileActivation::where('user_id', $user->id)->delete();

            //CREATE ACTIVATION REQUEST
            $create = MobileActivation::create([
                'user_id' => $user->id,
                'device_id' => $request->device_id,
                'device_name' => $request->device_name,
                'status' => 'f',
            ]);

            return response()->json([
                "data" => $create,
                "message" => "activation record created",
            ], 200);
        }else{
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 401);
        }

    }

    public function updatePassword(Request $request){
        $user = User::find(Auth::id());

        $user->password = bcrypt($request->password);
        $user->save();

        if($user){
            return response()->json([
                "data" => $user,
                "message" => "user updated successfully",
            ], 200);
        }else{
            return response()->json([
                "message" => "something went error",
            ], 500);
        }


    }
}
