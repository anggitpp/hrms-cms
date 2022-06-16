<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\ContactRequest;
use App\Http\Requests\Employee\ContractRequest;
use App\Http\Requests\Employee\EducationRequest;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Http\Requests\Employee\FamilyRequest;
use App\Http\Requests\Employee\WorkRequest;
use App\Models\Attendance\AttendanceShift;
use App\Models\BMS\Building;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeContact;
use App\Models\Employee\EmployeeContract;
use App\Models\Employee\EmployeeEducation;
use App\Models\Employee\EmployeeFamily;
use App\Models\Employee\EmployeePayroll;
use App\Models\Employee\EmployeeWork;
use App\Models\Employee\MasterPlacement;
use App\Models\Payroll\PayrollType;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Storage;

class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
            'SAG',
            'ESK',
            'ESP',
            'EJP',
            'ETP',
            'EP',
            'EG',
            'EDP',
            'ELK',
            'EAK',
            'EJPR',
            'SB',
            'EHK',
            'SPD'
        ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();
        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
        }
        $this->defaultStatus = defaultStatus();
        $this->gender = array('m' => 'Laki-Laki', 'f' => 'Perempuan');
        $this->bloodTypes = array('A' => 'A', 'B' => 'B', 'O' => 'O', 'AB' => 'AB');
        $this->familyPath = '/uploads/employee/family/';
        $this->educationPath = '/uploads/employee/education/';
        $this->workPath = '/uploads/employee/work/';
        $this->photoPath = '/uploads/employee/photo/';
        $this->identityPath = '/uploads/employee/identity/';
        $this->contractPath = '/uploads/employee/contract/';

        \View::share([
            'masters' => $masters,
            'gender' => $this->gender,
            'bloodTypes' => $this->bloodTypes,
            'status' => $this->defaultStatus,
            'familyPath' => $this->familyPath,
            'workPath' => $this->workPath,
            'photoPath' => $this->photoPath,
            'identityPath' => $this->identityPath,
            'contractPath' => $this->contractPath,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['payrolls'] = PayrollType::where('status', 't')->pluck('name','id')->toArray();
        $sql = DB::table('employees')
            ->select('employees.id', 'employees.name', 'employees.emp_number', 'employees.join_date', 'employees.status_id',
                'employee_contracts.position_id', 'employee_contracts.type_id','employee_contracts.rank_id')
            ->join('employee_contracts', function ($join){
                $join->on('employees.id', 'employee_contracts.employee_id');
                $join->where('employee_contracts.status', 't');
            });
        if($this->menu()->target == 'actives')
            $sql->where('employees.status_id', $this->getParameter('SA'));
        else
            $sql->where('employees.status_id','!=', $this->getParameter('SA'));

        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%')->orWhere('emp_number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['employees'] = $sql->paginate($this->defaultPagination($request));

        return !empty(access('index')) ? view('employees.employees.'.$this->menu()->target, $data) : abort(401);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['shifts'] = AttendanceShift::orderBy('id')->pluck('name','id')->toArray();
        $data['payrolls'] = PayrollType::where('status', 't')->pluck('name','id')->toArray();
        $getLastNumber = Employee::where(DB::raw('year(created_at)'), date('Y'))
                ->orderBy('emp_number', 'desc')
                ->pluck('emp_number')
                ->first() ?? 0;
        $data['empNumber'] = 'EMP'.date('Y').Str::padLeft(intval(Str::substr($getLastNumber,8,5)) + 1, '5', '0');
        $data['placements'] = MasterPlacement::active()->select('name', 'id')->pluck('name', 'id')->toArray();

        return !empty(access('create')) ? view('employees.employees.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {

        $photo = uploadFile(
            $request->file('photo'),
            Str::slug($request->input('name')).'_'.time(),
            $this->photoPath);

        $identity_file = uploadFile(
            $request->file('identity_file'),
            Str::slug($request->input('name')).'_'.time(),
            $this->identityPath);

        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('name')).'_'.time(),
            $this->contractPath);

        $employee = Employee::create([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'emp_number' => $request->emp_number,
            'birth_place' => $request->birth_place,
            'birth_date' => resetDate($request->birth_date),
            'identity_number' => $request->identity_number,
            'religion_id' => $request->religion_id,
            'gender' => $request->gender,
            'email' => $request->email,
            'address' => $request->address,
            'identity_address' => $request->identity_address,
            'marital_id' => $request->marital_id,
            'phone' => $request->phone,
            'mobile_phone' => $request->mobile_phone,
            'blood_type' => $request->blood_type,
            'status_id' => $request->status_id,
            'join_date' => resetDate($request->join_date),
            'leave_date' => $request->leave_date ? resetDate($request->leave_date) : '',
            'photo' => $photo,
            'identity_file' => $identity_file,
        ]);

        EmployeeContract::create([
            'employee_id' => $employee->id,
            'position_id' => $request->position_id,
            'type_id' => $request->type_id,
            'rank_id' => $request->rank_id,
            'grade_id' => $request->grade_id,
            'sk_number' => $request->sk_number,
            'location_id' => $request->location_id,
            'area_id' => $request->area_id,
            'start_date' =>  resetDate($request->start_date),
            'end_date' =>  $request->end_date ? resetDate($request->end_date) : '',
            'placement_id' =>  $request->placement_id,
            'shift_id' =>  $request->shift_id,
            'status' =>  't',
            'description' =>  $request->description,
            'filename' => $filename
        ]);

        EmployeePayroll::create([
            'employee_id' => $employee->id,
            'payroll_id' => $request->payroll_id,
            'bank_id' => $request->bank_id,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'npwp_date' => $request->npwp_date ? resetDate($request->npwp_date) : '',
            'npwp_number' => $request->npwp_number,
            'bpjs_tk_number' => $request->bpjs_tk_number,
            'bpjs_tk_date' => $request->bpjs_tk_date ? resetDate($request->bpjs_tk_date) : '',
            'bpjs_date' => $request->bpjs_date ? resetDate($request->bpjs_date) : '',
            'bpjs_number' => $request->bpjs_number,
        ]);

        Alert::success('Success', 'Employee created successfully');

        return redirect()->route('employees.'.$this->menu()->target.'.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['id'] = $id;
        $data['emp'] = Employee::find($id);
        $data['empc'] = EmployeeContract::where([
            ['employee_id', $id],
            ['status', 't']
        ])
            ->first();
        $data['shifts'] = AttendanceShift::orderBy('id')->pluck('name','id')->toArray();
        $data['empp'] = EmployeePayroll::where('employee_id', $id)->first();
        $data['families'] = EmployeeFamily::where('employee_id', $id)->paginate(10);
        $data['education'] = EmployeeEducation::where('employee_id', $id)->paginate(10);
        $data['contacts'] = EmployeeContact::where('employee_id', $id)->paginate(10);
        $data['works'] = EmployeeWork::where('employee_id', $id)->paginate(10);
        $data['contracts'] = EmployeeContract::where('employee_id', $id)->paginate(10);
        $data['placements'] = MasterPlacement::active()->select('name', 'id')->pluck('name', 'id')->toArray();

        return view('employees.employees.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['payrolls'] = PayrollType::where('status', 't')->pluck('name','id')->toArray();
        $data['shifts'] = AttendanceShift::orderBy('id')->pluck('name','id')->toArray();
        $data['emp'] = Employee::find($id);
        $data['empc'] = EmployeeContract::where([
            ['employee_id', $id],
            ['status', 't']
        ])->first();
        $data['empp'] = EmployeePayroll::where('employee_id', $id)->first();
        $data['placements'] = MasterPlacement::active($data['empc']->placement_id)->select('name', 'id')->pluck('name', 'id')->toArray();
        $data['placementData'] = DB::table('employee_master_placements as t1')
            ->select('t2.name as leaderName', 't3.name as adminName')
            ->join('employees as t2', 't1.leader_id', 't2.id')
            ->join('employees as t3', 't1.administration_id', 't3.id')
            ->where('t1.id', $data['empc']->placement_id)
            ->first();

        return !empty(access('edit')) ? view('employees.employees.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        $emp = Employee::find($id);
        $photo = $request->exist_photo ? $emp->photo : '';
        if($emp->photo && $photo == '')
            \Storage::disk('public')->delete($emp->photo);
        if($request->file('photo')){
            Storage::disk('public')->delete($emp->photo);
            $photo = uploadFile($request->file('photo'), Str::slug($request->input('name')).'_'.time(), $this->photoPath);
        }
        $identity_file = $request->exist_identity_file ? $emp->identity_file : '';
        if($emp->identity_file && $identity_file == '')
            \Storage::disk('public')->delete($emp->identity_file);
        if($request->file('identity_file')){
            Storage::disk('public')->delete($emp->identity_file);
            $identity_file = uploadFile($request->file('identity_file'), Str::slug($request->input('name')).'_'.time(), $this->identityPath);
        }
        $emp->name = $request->name;
        $emp->nickname = $request->nickname;
        $emp->emp_number = $request->emp_number;
        $emp->birth_place = $request->birth_place;
        $emp->birth_date = resetDate($request->birth_date);
        $emp->identity_number = $request->identity_number;
        $emp->religion_id = $request->religion_id;
        $emp->gender = $request->gender;
        $emp->email = $request->email;
        $emp->address = $request->address;
        $emp->identity_address = $request->identity_address;
        $emp->marital_id = $request->marital_id;
        $emp->phone = $request->phone;
        $emp->mobile_phone = $request->mobile_phone;
        $emp->blood_type = $request->blood_type;
        $emp->status_id = $request->status_id;
        $emp->join_date = resetDate($request->join_date);
        $emp->leave_date = $request->leave_date ? resetDate($request->leave_date) : '';
        $emp->photo = $photo;
        $emp->identity_file = $identity_file;
        $emp->save();

        $empc = EmployeeContract::where([
            ['employee_id', $id],
            ['status', 't']
        ])->first();

        $filename = $request->exist_filename ? $empc->filename : '';
        if($empc->filename && $filename == '')
            \Storage::disk('public')->delete($empc->filename);
        if($request->file('filename')){
            Storage::disk('public')->delete($empc->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($request->input('name')).'_'.time(), $this->contractPath);
        }

        $empc->position_id = $request->position_id;
        $empc->type_id = $request->type_id;
        $empc->rank_id = $request->rank_id;
        $empc->grade_id = $request->grade_id;
        $empc->sk_number = $request->sk_number;
        $empc->location_id = $request->location_id;
        $empc->area_id = $request->area_id;
        $empc->start_date =  resetDate($request->start_date);
        $empc->end_date =  $request->end_date ? resetDate($request->end_date) : '';
        $empc->placement_id =  $request->placement_id;
        $empc->shift_id =  $request->shift_id;
        $empc->description =  $request->description;
        $empc->filename =  $filename;
        $empc->save();

        EmployeePayroll::updateOrCreate(
            [
                'employee_id' => $id
            ],
        [
            'payroll_id' => $request->payroll_id,
            'bank_id' => $request->bank_id,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'npwp_date' => $request->npwp_date ? resetDate($request->npwp_date) : '',
            'npwp_number' => $request->npwp_number,
            'bpjs_tk_number' => $request->bpjs_tk_number,
            'bpjs_tk_date' => $request->bpjs_tk_date ? resetDate($request->bpjs_tk_date) : '',
            'bpjs_date' => $request->bpjs_date ? resetDate($request->bpjs_date) : '',
            'bpjs_number' => $request->bpjs_number,
        ]
        );

        Alert::success('Success', 'Employee updated successfully');

        return redirect()->route('employees.'.$this->menu()->target.'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emp = Employee::find($id);
        Storage::disk('public')->delete($emp->photo);
        Storage::disk('public')->delete($emp->identity_file);
        $emp->delete();
        EmployeePayroll::where('employee_id', $id)->delete();
        $contracts = EmployeeContract::where('employee_id', $id)->get();
        foreach ($contracts as $key => $value){
            Storage::disk('public')->delete($value->filename);
            EmployeeContract::find($value->id)->delete();
        }
        $families = EmployeeFamily::where('employee_id', $id)->get();
        foreach ($families as $key => $value){
            Storage::disk('public')->delete($value->filename);
            EmployeeFamily::find($value->id)->delete();
        }
        $education = EmployeeEducation::where('employee_id', $id)->get();
        foreach ($education as $key => $value){
            Storage::disk('public')->delete($value->filename);
            EmployeeEducation::find($value->id)->delete();
        }
        $works = EmployeeWork::where('employee_id', $id)->get();
        foreach ($works as $key => $value){
            Storage::disk('public')->delete($value->filename);
            EmployeeWork::find($value->id)->delete();
        }
        EmployeeContact::where('employee_id', $id)->delete();

        Alert::success('Success', 'Employee deleted successfully');

        return redirect()->back();
    }

    public function familyCreate($id)
    {
        return !empty(access('family/create')) ? view('employees.employees.family_form', compact('id')) : abort(401);
    }

    public function familyStore(FamilyRequest $request, $id)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('name')).'_'.time(),
            $this->familyPath);

        EmployeeFamily::create([
            'employee_id' => $id,
            'name' => $request->name,
            'relation_id' => $request->relation_id,
            'identity_number' => $request->identity_number,
            'gender' => $request->gender,
            'birth_place' => $request->birth_place,
            'filename' => $filename,
            'birth_date' => $request->birth_date ? resetDate($request->birth_date) : '',
            'description' => $request->description
        ]);

        return response()->json([
            'success'=>'Family inserted successfully',
            'url'=> route('employees.'.$this->menu()->target.'.show', $id)
        ]);
    }

    public function familyEdit($id)
    {
        $data['id'] = $id;
        $data['family'] = EmployeeFamily::find($id);

        return !empty(access('family/edit')) ? view('employees.employees.family_form', $data) : abort(401);
    }

    public function familyUpdate(FamilyRequest $request, $id)
    {
        $family = EmployeeFamily::find($id);
        $filename = $family->filename;
        if($request->file('filename')){
            Storage::disk('public')->delete($family->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($request->input('name')).'_'.time(), $this->familyPath);
        }
        $family->name = $request->name;
        $family->relation_id = $request->relation_id;
        $family->identity_number = $request->identity_number;
        $family->gender = $request->gender;
        $family->birth_place = $request->birth_place;
        $family->birth_date = $request->birth_date ? resetDate($request->birth_date) : '';
        $family->filename = $filename;
        $family->description = $request->description;
        $family->save();

        return response()->json([
            'success'=>'Family updated successfully',
            'url'=> route('employees.'.$this->menu()->target.'.show', $family->employee_id)
        ]);
    }

    public function familyDestroy($id)
    {
        $family = EmployeeFamily::find($id);
        Storage::disk('public')->delete($family->filename);
        $family->delete();

        Alert::success('Success', 'Family deleted successfully');

        return redirect()->back();
    }

    public function educationCreate($id)
    {
        return !empty(access('education/create')) ? view('employees.employees.education_form', compact('id')) : abort(401);
    }

    public function educationStore(EducationRequest $request, $id)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('name')).'_'.time(),
            $this->educationPath);

        EmployeeEducation::create([
            'employee_id' => $id,
            'level_id' => $request->level_id,
            'name' => $request->name,
            'major' => $request->major,
            'essay' => $request->essay,
            'city' => $request->city,
            'score' => $request->score,
            'start_year' => $request->start_year,
            'end_year' => $request->end_year,
            'filename' => $filename,
            'description' => $request->description
        ]);

        return response()->json([
            'success'=>'Education inserted successfully',
            'url'=> route('employees.'.$this->menu()->target.'.show', $id)
        ]);
    }

    public function educationEdit($id)
    {
        $data['id'] = $id;
        $data['edu'] = EmployeeEducation::find($id);

        return !empty(access('education/edit')) ? view('employees.employees.education_form', $data) : abort(401);
    }

    public function educationUpdate(EducationRequest $request, $id)
    {
        $education = EmployeeEducation::find($id);
        $filename = $education->filename;
        if($request->file('filename')){
            Storage::disk('public')->delete($education->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($request->input('name')).'_'.time(), $this->educationPath);
        }
        $education->name = $request->name;
        $education->level_id = $request->level_id;
        $education->major = $request->major;
        $education->score = $request->score;
        $education->city = $request->city;
        $education->start_year = $request->start_year;
        $education->end_year = $request->end_year;
        $education->essay = $request->essay;
        $education->filename = $filename;
        $education->description = $request->description;
        $education->save();

        return response()->json([
            'success'=>'Education updated successfully',
            'url'=> route('employees.'.$this->menu()->target.'.show', $education->employee_id)
        ]);
    }

    public function educationDestroy($id)
    {
        $education = EmployeeEducation::find($id);
        Storage::disk('public')->delete($education->filename);
        $education->delete();

        Alert::success('Success', 'Education deleted successfully');

        return redirect()->back();
    }

    public function contactCreate($id)
    {
        return !empty(access('contact/create')) ? view('employees.employees.contact_form', compact('id')) : abort(401);
    }

    public function contactStore(ContactRequest $request, $id)
    {
        EmployeeContact::create([
            'employee_id' => $id,
            'relation_id' => $request->relation_id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json([
            'success'=>'Emergency Contact inserted successfully',
            'url'=> route('employees.'.$this->menu()->target.'.show', $id)
        ]);
    }

    public function contactEdit($id)
    {
        $data['id'] = $id;
        $data['contact'] = EmployeeContact::find($id);

        return !empty(access('contact/edit')) ? view('employees.employees.contact_form', $data) : abort(401);
    }

    public function contactUpdate(ContactRequest $request, $id)
    {
        $contact = EmployeeContact::find($id);
        $contact->name = $request->name;
        $contact->relation_id = $request->relation_id;
        $contact->phone_number = $request->phone_number;
        $contact->save();

        return response()->json([
            'success'=>'Contact updated successfully',
            'url'=> route('employees.'.$this->menu()->target.'.show', $contact->employee_id)
        ]);
    }

    public function contactDestroy($id)
    {
        EmployeeContact::find($id)->delete();

        Alert::success('Success', 'Contact deleted successfully');

        return redirect()->back();
    }

    public function workCreate($id)
    {
        return !empty(access('work/create')) ? view('employees.employees.work_form', compact('id')) : abort(401);
    }

    public function workStore(WorkRequest $request, $id)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('company')).'_'.time(),
            $this->workPath);

        EmployeeWork::create([
            'employee_id' => $id,
            'company' => $request->company,
            'position' => $request->position,
            'start_date' => resetDate($request->start_date),
            'end_date' => $request->end_date ? resetDate($request->end_date) : '',
            'city' => $request->city,
            'job_desc' => $request->job_desc,
            'filename' => $filename,
            'description' => $request->description
        ]);

        return response()->json([
            'success'=>'Work Experience inserted successfully',
            'url'=> route('employees.'.$this->menu()->target.'.show', $id)
        ]);
    }

    public function workEdit($id)
    {
        $data['id'] = $id;
        $data['work'] = EmployeeWork::find($id);

        return !empty(access('work/edit')) ? view('employees.employees.work_form', $data) : abort(401);
    }

    public function workUpdate(WorkRequest $request, $id)
    {
        $work = EmployeeWork::find($id);
        $filename = $work->filename;
        if($request->file('filename')){
            Storage::disk('public')->delete($work->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($request->input('company')).'_'.time(), $this->workPath);
        }
        $work->company = $request->company;
        $work->position = $request->position;
        $work->start_date = resetDate($request->start_date);
        $work->end_date = $request->end_date ? resetDate($request->end_date) : '';
        $work->city = $request->city;
        $work->job_desc = $request->job_desc;
        $work->filename = $filename;
        $work->description = $request->description;
        $work->save();

        return response()->json([
            'success'=>'Work Experience updated successfully',
            'url'=> route('employees.'.$this->menu()->target.'.show', $work->employee_id)
        ]);
    }

    public function workDestroy($id)
    {
        $work = EmployeeWork::find($id);
        Storage::disk('public')->delete($work->filename);
        $work->delete();

        Alert::success('Success', 'Work Experience deleted successfully');

        return redirect()->back();
    }

    public function contractCreate($id)
    {
        $data['shifts'] = AttendanceShift::orderBy('id')->pluck('name','id')->toArray();
        $data['id'] = $id;

        return !empty(access('contract/create')) ? view('employees.employees.contract_form', $data) : abort(401);
    }

    public function contractStore(ContractRequest $request, $id)
    {
        if($request->status == 't')
            DB::table('employee_contracts')->where('employee_id', $id)->update(['status' => 'f']);

        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('name')).'_'.time(),
            $this->contractPath);

        EmployeeContract::create([
            'employee_id' => $id,
            'position_id' => $request->position_id,
            'type_id' => $request->type_id,
            'rank_id' => $request->rank_id,
            'grade_id' => $request->grade_id,
            'sk_number' => $request->sk_number,
            'location_id' => $request->location_id,
            'start_date' => resetDate($request->start_date),
            'end_date' => $request->end_date ? resetDate($request->end_date) : '',
            'placement_id' => $request->placement_id,
            'shift_id' => $request->shift_id,
            'status' => $request->status,
            'description' => $request->description,
            'filename' => $filename,
        ]);

        return response()->json([
            'success'=>'Contract inserted successfully',
            'url'=> route('employees.'.$this->menu()->target.'.show', $id)
        ]);
    }

    public function contractEdit($id)
    {
        $data['id'] = $id;
        $data['contract'] = EmployeeContract::find($id);
        $data['shifts'] = AttendanceShift::orderBy('id')->pluck('name','id')->toArray();

        return !empty(access('contract/edit')) ? view('employees.employees.contract_form', $data) : abort(401);
    }

    public function contractUpdate(ContractRequest $request, $id)
    {
        $contract = EmployeeContract::find($id);

        if($request->status == 't')
            DB::table('employee_contracts')->where('employee_id', $contract->employee_id)->update(['status' => 'f']);

        $filename = $request->exist_filename ? $contract->filename : '';
        if($contract->filename && $filename == '')
            \Storage::disk('public')->delete($contract->filename);
        if($request->file('filename')){
            Storage::disk('public')->delete($contract->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($request->input('name')).'_'.time(), $this->contractPath);
        }

        $contract->position_id = $request->position_id;
        $contract->type_id = $request->type_id;
        $contract->rank_id = $request->rank_id;
        $contract->grade_id = $request->grade_id;
        $contract->sk_number = $request->sk_number;
        $contract->location_id = $request->location_id;
        $contract->start_date =  resetDate($request->start_date);
        $contract->end_date =  $request->end_date ? resetDate($request->end_date) : '';
        $contract->placement_id =  $request->placement_id;
        $contract->shift_id =  $request->shift_id;
        $contract->status =  $request->status;
        $contract->description =  $request->description;
        $contract->filename =  $filename;
        $contract->save();

        return response()->json([
            'success'=>'Contract updated successfully',
            'url'=> route('employees.'.$this->menu()->target.'.show', $contract->employee_id)
        ]);
    }

    public function contractDestroy($id)
    {
        $contract = EmployeeContract::find($id);
        Storage::disk('public')->delete($contract->filename);
        $contract->delete();

        Alert::success('Success', 'Contract deleted successfully');

        return redirect()->back();
    }

    public function getPlacementDetail($id){
        $data = DB::table('employee_master_placements as t1')
            ->select('t2.name as leaderName', 't3.name as adminName')
            ->join('employees as t2', 't1.leader_id', 't2.id')
            ->join('employees as t3', 't1.administration_id', 't3.id')
            ->where('t1.id', $id)
            ->first();

        return json_encode($data);
    }

    public function subMasters($id){
        $cities = DB::table("app_masters")
            ->where("parent_id",$id)
            ->pluck("name","id");
        return json_encode($cities);
    }
}
