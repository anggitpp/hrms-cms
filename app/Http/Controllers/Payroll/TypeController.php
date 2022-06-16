<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\TypeRequest;
use App\Models\Payroll\PayrollType;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['filter'] = $request->get('filter');
        $sql = PayrollType::query();
        if (!empty($data['filter'])){
            $sql->where(function ($query) use ($data) {
                $query->orWhere('name', 'like', '%' . $data['filter'] . '%');
                $query->orWhere('code', 'like', '%' . $data['filter'] . '%');
            });
        }

        $data['types'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('payrolls.types.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['status'] = defaultStatus();

        return !empty(access('edit')) ? view('payrolls.types.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeRequest $request)
    {
        PayrollType::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json([
            'success'=>'Master Gaji berhasil disimpan',
            'url'=> route('payrolls.types.index')
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
        $data['type'] = PayrollType::find($id);
        $data['status'] = defaultStatus();

        return !empty(access('edit')) ? view('payrolls.types.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeRequest $request, $id)
    {
        PayrollType::find($id)->update([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json([
            'success'=>'Gaji Pokok berhasil disimpan',
            'url'=> route('payrolls.types.index')
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
        PayrollType::find($id)->delete();

        Alert::success('Success', 'Data Master Gaji berhasil dihapus');

        return redirect()->back();
    }
}
