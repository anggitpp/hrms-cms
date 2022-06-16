<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\RecruitmentSelectionRequest;
use App\Models\Recruitment\RecruitmentApplicant;
use App\Models\Recruitment\RecruitmentPlan;
use App\Models\Recruitment\RecruitmentSelection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecruitmentSelectionController extends Controller
{
    public function __construct()
    {
        $this->results = array('t' => 'Lulus', 'f' => 'Tidak Lulus');
        $this->selectionPath = '/uploads/recruitment/selection/';

        \View::share([
            'results' => $this->results,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $arrStepBefore = array('psychological' => 'verification', 'hr' => 'psychological', 'user' => 'hr', 'mcu' => 'user',
            'final' => 'mcu'); //MAKE ARRAY FOR STEP BEFORE
        $parameterMenu = $this->menu()->parameter;

        $data['plans'] = RecruitmentPlan::orderBy('title')->pluck('title','id')->toArray(); //GET DATA PLAN
        $sql = DB::table('recruitment_applicants as t1')
            ->select('t1.id as applId', 't1.name', 't1.applicant_number', 't2.title', 't5.name as position', 't3.selection_date', 't3.selection_time',
                't3.result', 't3.id', 't3.filename')
            ->join('recruitment_plans as t2', 't1.plan_id', 't2.id')
            ->join('app_masters as t5', function ($join){
                $join->on('t2.position_id','t5.id');
                $join->where('t5.category','EJP');
            })
            ->leftJoin('recruitment_selections as t3',function ($join) use ($parameterMenu) {
                $join->on('t3.applicant_id', 't1.id');
                $join->where('t3.step', $parameterMenu);
            }); //GET SQL
        if($parameterMenu != 'verification')
            $sql->join('recruitment_selections as t4', function ($join) use ($arrStepBefore, $parameterMenu) {
                $join->on('t4.applicant_id', 't1.id');
                $join->where('t4.step', $arrStepBefore[$parameterMenu]);
                $join->where('t4.result', 't');
            });//FILTER FOR APPLICANT WHO PASSED STEP BEFORE

        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['filterPlan'] = $request->get('filterPlan'); //GET FILTER
        if (!empty($data['filter'])) //check if not empty then where
            $sql->where('title', 'like', '%' . $data['filter'] . '%')
                ->orWhere('position', 'like', '%' . $data['filter'] . '%')
                ->orWhere('name', 'like', '%' . $data['filter'] . '%');
        if(!empty($data['filterPlan']))
            $sql->where('t1.plan_id', '=', $data['filterPlan']); //check if not empty then where
        $data['selections'] = $sql->paginate($this->defaultPagination($request)); // PAGINATE

        return !empty(access('index')) ? view('recruitments.selections.'.$this->menu()->target, $data) : abort(401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['planId'] = RecruitmentApplicant::find($id)
        ->pluck('plan_id')
        ->first();

        $data['id'] = $id;

        return view('recruitments.selections.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, $planId, RecruitmentSelectionRequest $request)
    {
        $appl = RecruitmentApplicant::find($id);
        $appl->selection_result = $request->result;
        $appl->selection_step = $this->menu()->parameter;
        $appl->save();

        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($appl->name).'_'.time(),
            $this->selectionPath);

        RecruitmentSelection::create([
            'applicant_id' => $id,
            'plan_id' => $planId,
            'step' => $this->menu()->parameter,
            'selection_date' => resetDate($request->selection_date),
            'selection_time' => $request->selection_time,
            'result' => $request->result,
            'filename' => $filename,
            'description' => $request->description
        ]);

        return response()->json([
            'success'=>'Recruitment Selection inserted successfully',
            'url'=> route('recruitments.'.$this->menu()->target.'.index')
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
        $data['selection'] = RecruitmentSelection::find($id);

        return view('recruitments.selections.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RecruitmentSelectionRequest $request, $id)
    {
        $selection = RecruitmentSelection::find($id);
        $appl = RecruitmentApplicant::find($selection->applicant_id);
        $appl->selection_result = $request->result;
        $appl->selection_step = $this->menu()->parameter;
        $appl->save();
        $filename = $request->exist_filename ? $selection->filename : '';
        if($selection->filename && $filename == '')
            \Storage::disk('public')->delete($selection->filename);
        if($request->file('filename')){
            Storage::disk('public')->delete($selection->filename);
            $filename = uploadFile($request->file('filename'), Str::slug($name).'_'.time(), $this->selectionPath);
        }
        $selection->selection_date = resetDate($request->selection_date);
        $selection->selection_time = $request->selection_time;
        $selection->result = $request->result;
        $selection->filename = $filename;
        $selection->description = $request->description;
        $selection->save();

        return response()->json([
            'success'=>'Selection updated successfully',
            'url'=> route('recruitments.'.$this->menu()->target.'.index')
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
