<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\RecruitmentPlanRequest;
use App\Models\Employee\Employee;
use App\Models\Recruitment\RecruitmentApplicant;
use App\Models\Recruitment\RecruitmentPlan;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class RecruitmentPlanController extends Controller
{

    public function __construct()
    {
        $this->planPath = '/uploads/recruitment/plan/';
        $this->genders = array('m' => 'Male', 'f' => 'Female', 'a' => 'All');
        $this->listStatus = array('t' => 'Approve','p'=>'Pending', 'f' =>'Rejected');

        \View::share([
            'listStatus' => $this->listStatus,
            'planPath' => $this->planPath,
            'genders' => $this->genders,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = DB::table('recruitment_plans as t1')->select('t1.id', 't1.title', 't1.propose_date', 't1.number_of_people', 't1.plan_number',
            't2.name', 't1.status')
            ->join('app_masters as t2', function ($join){
            $join->on('t1.position_id', 't2.id');
        });
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('title', 'like', '%' . $data['filter'] . '%');
        $data['plans'] = $sql->paginate(10);

//        dd($data['plans']);

        return !empty($this->access('index')) ? view('recruitments.plans.index', $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['employees'] = Employee::active()->select('id', DB::raw("CONCAT(emp_number, ' - ', name) as empName"))->orderBy('name')
            ->pluck('empName','id')
            ->toArray();
        $data['locations'] = Master::where('category', 'ELK')
            ->orderBy('name')
            ->pluck('name','id')
            ->toArray();
        $data['education'] = Master::where('category', 'SPD')
            ->orderBy('order')
            ->pluck('name','id')
            ->toArray();
        $data['positions'] = Master::where('category', 'EJP')
            ->orderBy('order')
            ->pluck('name','id')
            ->toArray();
        $getLastNumber = RecruitmentPlan::where(DB::raw('year(propose_date)'), date('Y'))
            ->orderBy('plan_number', 'desc')
            ->pluck('plan_number')
            ->first() ?? 0;
        $data['planNumber'] = Str::padLeft(Str::substr($getLastNumber,0,5) + 1, '5', '0').'/RP/'.date('Y');

        return !empty($this->access('create')) ? view('recruitments.plans.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecruitmentPlanRequest $request)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('title')).'_'.time(),
            $this->planPath);

        RecruitmentPlan::create([
            'plan_number' => $request->plan_number,
            'employee_id' => $request->employee_id,
            'title' => $request->title,
            'position_id' => $request->position_id,
            'propose_date' => resetDate($request->propose_date),
            'need_date' => resetDate($request->need_date),
            'education_id' => $request->education_id,
            'location_id' => $request->location_id,
            'age_from' => $request->age_from,
            'age_to' => $request->age_to,
            'number_of_people' => $request->number_of_people,
            'experience' => $request->experience,
            'gender' => $request->gender,
            'notes' => $request->notes,
            'recruitment_reason' => $request->recruitment_reason,
            'filename' => $filename,
            'status' => $request->status
        ]);

        Alert::success('Success', 'Recruitment Plan created successfully');

        return redirect()->route('recruitments.plans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['applicants'] = RecruitmentApplicant::where('plan_id', $id)->get();

        return view('recruitments.plans.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['plan'] = RecruitmentPlan::find($id);
        $data['employees'] = Employee::orderBy('name')
            ->pluck('name','id')
            ->toArray();
        $data['locations'] = Master::where('category', 'ELK')
            ->orderBy('name')
            ->pluck('name','id')
            ->toArray();
        $data['education'] = Master::where('category', 'SPD')
            ->orderBy('order')
            ->pluck('name','id')
            ->toArray();
        $data['positions'] = Master::where('category', 'EJP')
            ->orderBy('order')
            ->pluck('name','id')
            ->toArray();

        return view('recruitments.plans.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RecruitmentPlanRequest $request, $id)
    {
        $plan = RecruitmentPlan::find($id);

        $filename = $plan->filename;
        if($request->file('filename')){
            \Storage::disk('public')->delete($plan->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($request->input('title')).'_'.time(), $this->planPath);
        }

        $plan->plan_number = $request->plan_number;
        $plan->employee_id = $request->employee_id;
        $plan->title = $request->title;
        $plan->position_id = $request->position_id;
        $plan->propose_date = resetDate($request->propose_date);
        $plan->need_date = resetDate($request->need_date);
        $plan->education_id = $request->education_id;
        $plan->location_id = $request->location_id;
        $plan->age_from = $request->age_from;
        $plan->age_to = $request->age_to;
        $plan->number_of_people = $request->number_of_people;
        $plan->experience = $request->experience;
        $plan->gender = $request->gender;
        $plan->notes = $request->notes;
        $plan->recruitment_reason = $request->recruitment_reason;
        $plan->filename = $filename;
        $plan->status = $request->status;
        $plan->save();

        Alert::success('Success', 'Recruitment Plan updated successfully');

        return redirect()->route('recruitments.plans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = RecruitmentPlan::find($id);
        \Storage::disk('public')->delete($plan->filename);
        $plan->delete();

        Alert::success('Success', 'Recruitment Plan deleted successfully');

        return redirect()->back();
    }
}
