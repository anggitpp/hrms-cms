<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\RecruitmentContractRequest;
use App\Models\Recruitment\RecruitmentApplicant;
use App\Models\Recruitment\RecruitmentContract;
use App\Models\Recruitment\RecruitmentPlan;
use App\Models\Setting\Master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class RecruitmentContractController extends Controller
{
    public function __construct()
    {
        $this->contractPath = '/uploads/recruitment/contract/';
        $this->statusApprove = array('t' => 'Disetujui', 'f' => 'Ditolak' );

        \View::share([
            'statusApprove' => $this->statusApprove,
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
        $sql = DB::table('recruitment_applicants as t1')
            ->select('t1.id as applId', 't1.name', 't1.applicant_number', 't2.title', 't4.name as position', 't3.start_date', 't3.end_date',
                't3.id', 't3.filename', 't3.status')
            ->join('recruitment_plans as t2', 't1.plan_id', 't2.id')
            ->join('app_masters as t4', function ($join){
                $join->on('t2.position_id','t4.id');
                $join->where('t4.category','EJP');
            })
            ->leftJoin('recruitment_contracts as t3',function ($join) {
                $join->on('t3.applicant_id', 't1.id');
            })
            ->where([
                ['selection_step','final'],
                ['selection_result','t'], // FIND APPLICANT WHO PASS THE FINALS
            ]); //GET SQL
        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['filterPlan'] = $request->get('filterPlan'); //GET FILTER
        if (!empty($data['filter'])) //check if not empty then where
            $sql->where('title', 'like', '%'.$data['filter'].'%')
                ->orWhere('t4.name', 'like', '%'.$data['filter'].'%')
                ->orWhere('t1.name', 'like', '%'.$data['filter'].'%');
        if(!empty($data['filterPlan']))
            $sql->where('t1.plan_id', '=', $data['filterPlan']); //check if not empty then where
        $data['contracts'] = $sql->paginate($this->defaultPagination($request)); // PAGINATE

        return view('recruitments.contracts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['appl'] = RecruitmentApplicant::find($id);
        $getPosition = RecruitmentPlan::find($data['appl']->plan_id)->position_id;
        $data['appl']->position = Master::find($getPosition)->name;
        $data['types'] = Master::where('category', 'ETP')->orderBy('name')->pluck('name','id')->toArray(); //GET DATA PLAN

        return view('recruitments.contracts.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, RecruitmentContractRequest $request)
    {
        $appl = RecruitmentApplicant::find($id);
        $plan = RecruitmentPlan::find($appl->plan_id);

        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($appl->name).'_'.time(),
            $this->contractPath);

        RecruitmentContract::create([
            'applicant_id' => $id,
            'position_id' => $plan->position_id,
            'plan_id' => $appl->plan_id,
            'type_id' => $request->type_id,
            'sk_number' => $request->sk_number,
            'start_date' => resetDate($request->start_date),
            'end_date' => $request->end_date ? resetDate($request->end_date) : '',
            'filename' => $filename,
            'description' => $request->description,
            'status' => $request->status
        ]);

        Alert::success('Success', 'Contract created successfully');

        return redirect()->route('recruitments.contracts.index');
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
        $data['contract'] = RecruitmentContract::find($id);
        $data['appl'] = RecruitmentApplicant::find($data['contract']->applicant_id);
        $data['appl']->position = Master::find($data['contract']->position_id)->name;
        $data['types'] = Master::where('category', 'ETP')->orderBy('name')->pluck('name','id')->toArray(); //GET DATA PLAN


        return view('recruitments.contracts.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RecruitmentContractRequest $request, $id)
    {
        $contract = RecruitmentContract::find($id);
        $filename = $request->exist_filename ? $contract->filename : '';
        if($contract->filename && $filename == '')
            \Storage::disk('public')->delete($contract->filename);
        if($request->file('filename')){
            Storage::disk('public')->delete($contract->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($name).'_'.time(), $this->contractPath);
        }
        $contract->type_id = $request->type_id;
        $contract->sk_number = $request->sk_number;
        $contract->start_date = resetDate($request->start_date);
        $contract->end_date = $request->end_date ? resetDate($request->end_date) : '';
        $contract->filename = $filename;
        $contract->description = $request->description;
        $contract->status = $request->status;
        $contract->save();

        Alert::success('Success', 'Contract updated successfully');

        return redirect()->route('recruitments.contracts.index');
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
