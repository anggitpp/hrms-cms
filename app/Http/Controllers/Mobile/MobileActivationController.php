<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Mobile\MobileActivation;
use App\Models\Setting\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MobileActivationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['status'] = array("f" => "Tidak Aktif", "t" => "Aktif");
        $sql = DB::table('mobile_activations as t1')->select('t1.id', 't1.device_name', 't1.status', 't1.created_at', 't2.username', 't2.name')
            ->join('app_users as t2', 't1.user_id', 't2.id');
        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['filterStatus'] = $request->get('filterStatus') ?? 'f'; //GET FILTER
        $sql->where('t1.status', $data['filterStatus']);
        //SET FILTER WHEN NOT EMPTY
        if (!empty($data['filter'])){
            $sql->where(function ($query) use ($data) {
                $query->orWhere('t2.name', 'like', '%' . $data['filter'] . '%');
                $query->orWhere('t2.username', 'like', '%' . $data['filter'] . '%');
                $query->orWhere('t1.device_name', 'like', '%' . $data['filter'] . '%');
            });
        }
        $data['activations'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('mobiles.activations.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['activation'] = MobileActivation::find($id);
        $data['user'] = User::find($data['activation']->user_id);
        $data['status'] = array("f" => "Tidak Aktif", "t" => "Aktif");

        return !empty(access('edit')) ? view('mobiles.activations.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $activation = MobileActivation::find($id);
        $activation->status = $request->status;
        $activation->save();

        Alert::success('Success', 'Data aktifasi berhasil disimpan');

        return redirect()->route('mobiles.activations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
