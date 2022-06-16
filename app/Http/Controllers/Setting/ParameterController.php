<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\ParameterRequest;
use App\Models\Setting\Parameter;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = Parameter::query(); //SET QUERY
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['parameters'] = $sql->paginate($this->defaultPagination($request)); //FINAL RESULT

        return view('settings.parameters.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.parameters.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParameterRequest $request)
    {
        Parameter::create([
            'name' => $request->name,
            'code' => $request->code,
            'value' => $request->value,
            'description' => $request->description,
        ]);

        return response()->json([
            'success'=>'Parameter inserted successfully',
            'url'=> route('settings.parameters.index')
        ]);
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
        $data['param'] = Parameter::find($id);

        return view('settings.parameters.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ParameterRequest $request, $id)
    {
        $parameter = Parameter::find($id);
        $parameter->name = $request->name;
        $parameter->code = $request->code;
        $parameter->value = $request->value;
        $parameter->description = $request->description;
        $parameter->save();

        return response()->json([
            'success'=>'Parameter updated successfully',
            'url'=> route('settings.parameters.index')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Parameter::find($id)->delete();

        Alert::success('Success', 'Parameter deleted successfully');

        return redirect()->back();
    }
}
