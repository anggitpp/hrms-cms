<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\ArchiveContactRequest;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ContactController extends Controller
{

    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'EJP',
                'EP',
                'EHK',
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();

        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
            $this->listMasters[$value->category][$value->id] = $value->name;
        }

        \View::share([
            'masters' => $masters,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = DB::table('employee_contacts as t1')
            ->select('t1.id', 't1.name as contactName', 't1.relation_id', 't1.phone_number', 't2.name', 't2.emp_number',
                't3.position_id')
            ->join('employees as t2','t1.employee_id', 't2.id')
            ->join('employee_contracts as t3', function ($join){
                $join->on('t2.id', 't3.employee_id');
                $join->where('t3.status', 't');
            });
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('t2.name', 'like', '%' . $data['filter'] . '%')
                ->orWhere('t2.emp_number', 'like', '%' . $data['filter'] . '%') //check if not empty then where
                ->orWhere('t1.name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['contacts'] = $sql->paginate($this->defaultPagination($request));

        return view('employees.contacts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['employees'] = Employee::orderBy('name')->pluck('name','id')->toArray();

        return view('employees.contacts.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArchiveContactRequest $request)
    {
        EmployeeContact::create([
            'employee_id' => $request->employee_id,
            'name'=> $request->name,
            'relation_id'=> $request->relation_id,
            'phone_number'=> $request->phone_number,
        ]);

        Alert::success('Success', 'Contact created successfully');

        return redirect()->route('employees.contacts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['contact'] = EmployeeContact::find($id);

        return view('employees.contacts.form', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['employees'] = Employee::orderBy('name')->pluck('name','id')->toArray();
        $data['contact'] = EmployeeContact::find($id);
        $data['emp'] = Employee::find($data['contact']->employee_id);

        return view('employees.contacts.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArchiveContactRequest $request, $id)
    {
        $contact = EmployeeContact::find($id);
        $contact->employee_id = $request->employee_id;
        $contact->name= $request->name;
        $contact->relation_id= $request->relation_id;
        $contact->phone_number= $request->phone_number;
        $contact->save();

        Alert::success('Success', 'Contact updated successfully');

        return redirect()->route('employees.contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EmployeeContact::find($id)->delete();

        Alert::success('Success', ' deleted successfully');

        return redirect()->back();
    }

    public function getDetail($id){
        $datas = DB::table('employees')
            ->select('employees.emp_number', 'employee_contracts.position_id', 'employee_contracts.rank_id')
            ->join('employee_contracts', function ($join){
            $join->on('employees.id', 'employee_contracts.employee_id');
            $join->where('employee_contracts.status', 't');
        })->where('employees.id', $id)->first();

        $datas->positionName = $this->listMasters['EJP'][$datas->position_id];
        $datas->rankName = $this->listMasters['EP'][$datas->rank_id];

        return json_encode($datas);
    }
}
