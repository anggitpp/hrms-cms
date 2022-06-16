<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\BasicSalaryRequest;
use App\Models\Payroll\BasicSalary;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BasicSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['filter'] = $request->get('filter');
        $sql = DB::table('app_masters as t1')
            ->select('t1.id','t1.name', 't2.value', 't2.description')
            ->leftJoin('payroll_basic_salaries as t2', 't1.id', 't2.rank_id')
            ->where('t1.category', 'EP');
        if (!empty($data['filter'])){
            $sql->where(function ($query) use ($data) {
                $query->orWhere('t1.name', 'like', '%' . $data['filter'] . '%');
                $query->orWhere('t2.description', 'like', '%' . $data['filter'] . '%');
            });
        }

        $data['salaries'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('payrolls.basic-salary.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $data['id'] = $id;
        $data['salary'] = DB::table('app_masters as t1')
            ->select('t1.id','t1.name', 't2.value', 't2.description')
            ->leftJoin('payroll_basic_salaries as t2', 't1.id', 't2.rank_id')
            ->where('t1.id', $id)
            ->first();

        return !empty(access('edit')) ? view('payrolls.basic-salary.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BasicSalaryRequest $request, $id)
    {
        BasicSalary::updateOrCreate([
            'rank_id' => $id
            ],[
            'value' => resetCurrency($request->value),
            'description' => $request->description,
        ]);

        return response()->json([
            'success'=>'Gaji Pokok berhasil disimpan',
            'url'=> route('payrolls.basic-salary.index')
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
        //
    }
}
