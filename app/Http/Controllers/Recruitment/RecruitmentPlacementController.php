<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\RecruitmentPlacementRequest;
use App\Models\Attendance\AttendanceShift;
use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeContact;
use App\Models\Employee\EmployeeContract;
use App\Models\Employee\EmployeeEducation;
use App\Models\Employee\EmployeeFamily;
use App\Models\Employee\EmployeePayroll;
use App\Models\Employee\EmployeeWork;
use App\Models\Employee\MasterPlacement;
use App\Models\Recruitment\RecruitmentApplicant;
use App\Models\Recruitment\RecruitmentApplicantContact;
use App\Models\Recruitment\RecruitmentApplicantFamily;
use App\Models\Recruitment\RecruitmentContract;
use App\Models\Recruitment\RecruitmentPlacement;
use App\Models\Recruitment\RecruitmentPlan;
use App\Models\Recruitment\RecruitmentApplicantEducation;
use App\Models\Recruitment\RecruitmentApplicantWork;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class RecruitmentPlacementController extends Controller
{

    public function __construct()
    {
        $this->masters = DB::table('app_masters')
            ->select('id', 'name','category')
            ->whereIn('category', [
                'EP', //MASTER PANGKAT
                'EG', //MASTER GRADE
                'ELK', //MASTER LOKASI
                'EJPR', //MASTER JENIS PAYROLL
                'SB' //MASTER BANK
            ])
            ->where('status', 't')
            ->orderBy('category')
            ->orderBy('order')
            ->get();

        foreach ($this->masters as $key => $value){
            $masters[$value->category][$value->id] = $value->name;
        }

        $this->placementPath = '/uploads/recruitment/placement/';
        $this->statusApprove = array('t' => 'Approve', 'f' => 'Not Approve');
        $this->photoPathEmp = '/uploads/employee/photo/';
        $this->identityPathEmp = '/uploads/employee/identity/';
        $this->photoPathAppl = '/uploads/recruitment/photo/';
        $this->identityPathAppl = '/uploads/recruitment/identity/';

        \View::share([
            'masters' => $masters,
            'statusApprove' => $this->statusApprove
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['plans'] = RecruitmentPlan::orderBy('title')->pluck('title','id')->toArray(); //GET DATA PLAN
        //GET DATA PLACEMENT EMPLOYEE
        $data['placement'] = MasterPlacement::active()->select('name', 'id')->pluck('name', 'id')->toArray();
        $sql = DB::table('recruitment_applicants as t1')
            ->select('t1.name', 't1.applicant_number', 't2.title', 't4.name as position', 't3.id as contractId', 't5.id', 't5.rank_id',
                't5.placement_id', 't5.location_id', 't5.status')
            ->join('recruitment_plans as t2', 't1.plan_id', 't2.id')
            ->join('app_masters as t4', function ($join){
                $join->on('t2.position_id','t4.id');
                $join->where('t4.category','EJP');
            }) // join masters for position
            ->join('recruitment_contracts as t3',function ($join) {
                $join->on('t3.applicant_id', 't1.id');
                $join->on('t3.plan_id', 't1.plan_id');
            }) // join contract table
            ->leftJoin('recruitment_placements as t5',function ($join) {
                $join->on('t3.id', 't5.contract_id');
            })  //join placement table
            ->where('t3.status', 't'); //GET SQL
        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['filterPlan'] = $request->get('filterPlan'); //GET FILTER
        if (!empty($data['filter'])) //check if not empty then where
            $sql->where('title', 'like', '%'.$data['filter'].'%')
                ->orWhere('t4.name', 'like', '%'.$data['filter'].'%')
                ->orWhere('t1.name', 'like', '%'.$data['filter'].'%');
        if(!empty($data['filterPlan']))
            $sql->where('t1.plan_id', '=', $data['filterPlan']); //check if not empty then where

        $data['placements'] = $sql->paginate($this->defaultPagination($request)); // PAGINATE

        return view('recruitments.placements.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['shifts'] = AttendanceShift::orderBy('id')->pluck('name','id')->toArray();
        $data['contract'] = RecruitmentContract::find($id);
        $data['appl'] = RecruitmentApplicant::find($data['contract']->applicant_id);
        $getPosition = RecruitmentPlan::find($data['appl']->plan_id)->position_id;
        $data['appl']->position = Master::find($getPosition)->name;
        $data['placements'] = MasterPlacement::active()->select('name', 'id')->pluck('name', 'id')->toArray();


        return view('recruitments.placements.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, RecruitmentPlacementRequest $request)
    {
        $contract = RecruitmentContract::find($id);
        $appl = RecruitmentApplicant::find($contract->applicant_id);

        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($appl->name).'_'.time(),
            $this->placementPath);

        $placement = RecruitmentPlacement::create([
            'contract_id' => $id,
            'applicant_id' => $appl->id,
            'rank_id' => $request->rank_id,
            'grade_id' => $request->grade_id,
            'placement_id' => $request->placement_id,
            'location_id' => $request->location_id,
            'shift_id' => $request->shift_id,
            'payroll_id' => $request->payroll_id,
            'bank_id' => $request->bank_id,
            'bank_branch' => $request->bank_branch,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'filename' => $filename,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        //IF APPROVED, THEN MIGRATE ALL APPLICANT DATA TO EMPLOYEE
        if($placement->status == 't') {
            $getLastNumber = Employee::where(DB::raw('year(created_at)'), date('Y'))
                    ->orderBy('emp_number', 'desc')
                    ->pluck('emp_number')
                    ->first() ?? 0;
            $empNumber = 'EMP' . date('Y') . Str::padLeft(intval(Str::substr($getLastNumber, 8, 5)) + 1, '5', '0');

            //MIGRATE IDENTITY
            $emp = Employee::create([
                'name' => $appl->name,
                'nickname' => $appl->nickname,
                'emp_number' => $empNumber,
                'birth_place' => $appl->birth_place,
                'birth_date' => $appl->birth_date,
                'identity_number' => $appl->identity_number,
                'religion_id' => $appl->religion_id,
                'gender' => $appl->gender,
                'email' => $appl->email,
                'address' => $appl->address,
                'identity_address' => $appl->identity_address,
                'marital_id' => $appl->marital_id,
                'phone' => $appl->phone,
                'mobile_phone' => $appl->mobile_phone,
                'blood_type' => $appl->blood_type,
                'status_id' => $this->getParameter('SA'), // AKTIF
                'join_date' => $contract->start_date,
                'leave_date' => $contract->end_date,
                'identity_file' => $appl->identity_file,
                'photo' => $appl->photo,
                'applicant_id' => $appl->id
            ]);

            \File::copy('storage' . $appl->identity_file, 'storage' . Str::replaceFirst('recruitment', 'employee', $appl->identity_file));
            \File::copy('storage' . $appl->photo, 'storage' . Str::replaceFirst('recruitment', 'employee', $appl->photo));

            //MIGRATE CONTRACT
            EmployeeContract::create([
                'employee_id' => $emp->id,
                'type_id' => $contract->type_id,
                'position_id' => $contract->position_id,
                'rank_id' => $placement->rank_id,
                'grade_id' => $placement->grade_id,
                'rank_id' => $placement->rank_id,
                'sk_number' => $contract->sk_number,
                'start_date' => $contract->start_date,
                'end_date' => $contract->end_date,
                'shift_id' => $placement->shift_id,
                'placement_id' => $placement->placement_id,
                'location_id' => $placement->location_id,
                'status' => 't' //AKTIF
            ]);

            //MIGRATE PAYROLL
            EmployeePayroll::create([
                'employee_id' => $emp->id,
                'payroll_id' => $placement->payroll_id,
                'bank_id' => $placement->bank_id,
                'bank_branch' => $placement->bank_branch,
                'account_number' => $placement->account_number,
                'account_name' => $placement->account_name
            ]);

            //MIGRATE CONTACT
            $contact = RecruitmentApplicantContact::where('applicant_id', $appl->id)->get();
            if(!$contact->isEmpty()) {
                foreach ($contact as $key => $value) {
                    EmployeeContact::create([
                        'employee_id' => $emp->id,
                        'name' => $value->name,
                        'relation_id' => $value->relation_id,
                        'phone_number' => $value->phone_number,
                    ]);
                }
            }

            //MIGRATE FAMILY
            $family = RecruitmentApplicantFamily::where('applicant_id', $appl->id)->get();
            if(!$family->isEmpty()) {
                foreach ($family as $key => $value) {
                    EmployeeFamily::create([
                        'employee_id' => $emp->id,
                        'name' => $value->name,
                        'identity_number' => $value->identity_number,
                        'relation_id' => $value->relation_id,
                        'gender' => $value->gender,
                        'birth_place' => $value->birth_place,
                        'birth_date' => $value->birth_date,
                        'filename' => $value->filename,
                    ]);
                    \File::copy('storage' . $value->filename, 'storage' . Str::replaceFirst('recruitment', 'employee', $value->filename));
                }
            }

            //MIGRATE EDUCATION
            $education = RecruitmentApplicantEducation::where('applicant_id', $appl->id)->get();
            if(!$education->isEmpty()) {
                foreach ($education as $key => $value) {
                    EmployeeEducation::create([
                        'employee_id' => $emp->id,
                        'level_id' => $value->level_id,
                        'name' => $value->name,
                        'major' => $value->major,
                        'essay' => $value->essay,
                        'city' => $value->city,
                        'score' => $value->score,
                        'start_year' => $value->start_year,
                        'end_year' => $value->end_year,
                        'description' => $value->description,
                        'filename' => $value->filename,
                    ]);
                    \File::copy('storage' . $value->filename, 'storage' . Str::replaceFirst('recruitment', 'employee', $value->filename));
                }
            }

            $work = RecruitmentApplicantWork::where('applicant_id', $appl->id)->get();
            if(!$work->isEmpty()) {
                foreach ($work as $key => $value) {
                    EmployeeWork::create([
                        'employee_id' => $emp->id,
                        'company' => $value->company,
                        'position' => $value->position,
                        'start_date' => $value->start_date,
                        'end_date' => $value->end_date,
                        'city' => $value->city,
                        'job_desc' => $value->job_desc,
                        'filename' => $value->filename,
                        'description' => $value->description,
                    ]);
                    \File::copy('storage' . $value->filename, 'storage' . Str::replaceFirst('recruitment', 'employee', $value->filename));
                }
            }

        }

        Alert::success('Success', 'Placement created successfully');

        return redirect()->route('recruitments.placements.index');
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
        $data['placement'] = RecruitmentPlacement::find($id);
        $data['appl'] = RecruitmentApplicant::find($data['placement']->applicant_id);
        $getPosition = RecruitmentPlan::find($data['appl']->plan_id)->position_id;
        $data['appl']->position = Master::find($getPosition)->name;
        $data['shifts'] = AttendanceShift::orderBy('id')->pluck('name','id')->toArray();
        $data['placements'] = MasterPlacement::active($data['placement']->placement_id)->select('name', 'id')->pluck('name', 'id')->toArray();


        return view('recruitments.placements.form', $data);
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
        $placement = RecruitmentPlacement::find($id);
        $filename = $request->exist_filename ? $placement->filename : '';
        $name = RecruitmentApplicant::find($placement->applicant_id)->name;
        if($placement->filename && $filename == '')
            \Storage::disk('public')->delete($placement->filename);
        if($request->file('filename')){
            Storage::disk('public')->delete($placement->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($name).'_'.time(), $this->placementPath);
        }

        $placement->rank_id = $request->rank_id;
        $placement->grade_id = $request->grade_id;
        $placement->placement_id = $request->placement_id;
        $placement->location_id = $request->location_id;
        $placement->shift_id = $request->shift_id;
        $placement->payroll_id = $request->payroll_id;
        $placement->bank_id = $request->bank_id;
        $placement->bank_branch = $request->bank_branch;
        $placement->account_name = $request->account_name;
        $placement->account_number = $request->account_number;
        $placement->filename = $filename;
        $placement->description = $request->description;
        $placement->status = $request->status;
        $placement->save();

        Alert::success('Success', 'Placement updated successfully');

        return redirect()->route('recruitments.placements.index');
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

    public function subMasters($id){
        $cities = DB::table("app_masters")
            ->where("parent_id",$id)
            ->pluck("name","id");
        return json_encode($cities);
    }
}
