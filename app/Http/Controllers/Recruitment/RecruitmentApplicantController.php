<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\RecruitmentApplicantContactRequest;
use App\Http\Requests\Recruitment\RecruitmentApplicantEducationRequest;
use App\Http\Requests\Recruitment\RecruitmentApplicantFamilyRequest;
use App\Http\Requests\Recruitment\RecruitmentApplicantRequest;
use App\Http\Requests\Recruitment\RecruitmentApplicantWorkRequest;
use App\Models\Recruitment\RecruitmentApplicant;
use App\Models\Recruitment\RecruitmentApplicantContact;
use App\Models\Recruitment\RecruitmentApplicantFamily;
use App\Models\Recruitment\RecruitmentPlan;
use App\Models\Recruitment\RecruitmentApplicantEducation;
use App\Models\Recruitment\RecruitmentApplicantWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class RecruitmentApplicantController extends Controller
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
                'ESH',
                'EDP',
                'ELK',
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
        $plans = DB::table('recruitment_plans as t1')
            ->select('t1.id', DB::raw("CONCAT(t1.title, ' - ' ,t2.name) as name"))
            ->join('app_masters as t2', function($join)
        {
            $join->on('t1.position_id','t2.id');
            $join->where('t2.category','EJP');
        })
            ->orderBy('id')
            ->pluck('name','t1.id')
            ->toArray();
        $this->defaultStatus = defaultStatus();
        $this->gender = array('m' => 'Laki-Laki', 'f' => 'Perempuan');
        $this->bloodTypes = array('A' => 'A', 'B' => 'B', 'O' => 'O', 'AB' => 'AB');
        $this->familyPath = '/uploads/recruitment/family/';
        $this->educationPath = '/uploads/recruitment/education/';
        $this->workPath = '/uploads/recruitment/work/';
        $this->photoPath = '/uploads/recruitment/photo/';
        $this->identityPath = '/uploads/recruitment/identity/';

        \View::share([
            'masters' => $masters,
            'gender' => $this->gender,
            'bloodTypes' => $this->bloodTypes,
            'status' => $this->defaultStatus,
            'photoPath' => $this->photoPath,
            'identityPath' => $this->identityPath,
            'plans' => $plans,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = DB::table('recruitment_applicants as t1')
        ->select('t1.id', 't1.name', 't1.applicant_number', 't1.input_date','t1.selection_step', 't1.selection_result',
            't2.title', 't3.name as position')
            ->join('recruitment_plans as t2', 't1.plan_id','t2.id')
            ->join('app_masters as t3', function ($join){
                $join->on('t2.position_id','t3.id');
                $join->where('t3.category','EJP');
            });
        $data['filter'] = $request->get('filter'); //GET FILTER

        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%')
                ->orWhere('applicant_number', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['applicants'] = $sql->paginate(5);

        return !empty(access('index')) ? view('recruitments.applicants.index', $data) : abort(401);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getLastNumber = RecruitmentApplicant::where(DB::raw('year(input_date)'), date('Y'))
                ->orderBy('applicant_number', 'desc')
                ->pluck('applicant_number')
                ->first() ?? 0;
        $data['applicantNumber'] = 'APPL'.date('y').date('m').Str::padLeft(intval(Str::substr($getLastNumber,8,5)) + 1, '5', '0');

        return !empty(access('create')) ? view('recruitments.applicants.form', $data) : abort(401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecruitmentApplicantRequest $request)
    {
        $photo = uploadFile(
            $request->file('photo'),
            Str::slug($request->input('name')).'_'.time(),
            $this->photoPath);

        $identity_file = uploadFile(
            $request->file('identity_file'),
            Str::slug($request->input('name')).'_'.time(),
            $this->identityPath);

        RecruitmentApplicant::create([
            'applicant_number' => $request->applicant_number,
            'plan_id' => $request->plan_id,
            'input_date' => resetDate($request->input_date),
            'name' => $request->name,
            'nickname' => $request->nickname,
            'identity_number' => $request->identity_number,
            'birth_place' => $request->birth_place,
            'birth_date' => resetDate($request->birth_date),
            'gender' => $request->gender,
            'religion_id' => $request->religion_id,
            'email' => $request->email,
            'marital_id' => $request->marital_id,
            'address' => $request->address,
            'identity_address' => $request->identity_address,
            'blood_type' => $request->blood_type,
            'phone' => $request->phone,
            'mobile_phone' => $request->mobile_phone,
            'height' => $request->height,
            'weight' => $request->weight,
            'photo' => $photo,
            'identity_file' => $identity_file,
        ]);

        Alert::success('Success', 'Applicant created successfully');

        return redirect()->route('recruitments.applicants.index');
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
        $data['appl'] = RecruitmentApplicant::find($id);
        $data['plan'] = RecruitmentPlan::find($data['appl']->plan_id);
        $data['families'] = RecruitmentApplicantFamily::where('applicant_id', $id)->paginate(10);
        $data['education'] = RecruitmentApplicantEducation::where('applicant_id', $id)->paginate(10);
        $data['contacts'] = RecruitmentApplicantContact::where('applicant_id', $id)->paginate(10);
        $data['works'] = RecruitmentApplicantWork::where('applicant_id', $id)->paginate(10);

        return view('recruitments.applicants.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['appl'] = RecruitmentApplicant::find($id);

        return !empty(access('edit')) ? view('recruitments.applicants.form', $data) : abort(401);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RecruitmentApplicantRequest $request, $id)
    {
        $appl = RecruitmentApplicant::find($id);

        $photo = $request->exist_photo ? $appl->photo : '';
        if($appl->photo && $photo == '')
            \Storage::disk('public')->delete($appl->photo);
        if($request->file('photo')){
            \Storage::disk('public')->delete($appl->photo);
            $photo = uploadFile($request->file('photo'), Str::slug($request->input('name')).'_'.time(), $this->photoPath);
        }

        $identity_file = $request->exist_identity_file ? $appl->identity_file : '';
        if($appl->identity_file && $identity_file == '')
            \Storage::disk('public')->delete($appl->identity_file);
        if($request->file('identity_file')){
            \Storage::disk('public')->delete($appl->identity_file);
            $identity_file = uploadFile($request->file('identity_file'), Str::slug($request->input('name')).'_'.time(), $this->identityPath);
        }

        $appl->applicant_number = $request->applicant_number;
        $appl->plan_id = $request->plan_id;
        $appl->input_date = resetDate($request->input_date);
        $appl->name = $request->name;
        $appl->nickname = $request->nickname;
        $appl->identity_number = $request->identity_number;
        $appl->birth_place = $request->birth_place;
        $appl->birth_date = resetDate($request->birth_date);
        $appl->gender = $request->gender;
        $appl->religion_id = $request->religion_id;
        $appl->email = $request->email;
        $appl->marital_id = $request->marital_id;
        $appl->address = $request->address;
        $appl->identity_address = $request->identity_address;
        $appl->blood_type = $request->blood_type;
        $appl->phone = $request->phone;
        $appl->mobile_phone = $request->mobile_phone;
        $appl->height = $request->height;
        $appl->weight = $request->weight;
        $appl->photo = $photo;
        $appl->identity_file = $identity_file;
        $appl->save();

        Alert::success('Success', 'Applicant updated successfully');

        return redirect()->route('recruitments.applicants.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appl = RecruitmentApplicant::find($id);
        \Storage::disk('public')->delete($appl->photo);
        \Storage::disk('public')->delete($appl->identity_file);
        $appl->delete();

        Alert::success('Success', 'Applicant deleted successfully');

        return redirect()->back();
    }

    public function contactCreate($id)
    {
        return !empty(access('contact/create')) ? view('recruitments.applicants.contact_form', compact('id')) : abort(401);
    }

    public function contactStore(RecruitmentApplicantContactRequest $request, $id)
    {
        RecruitmentApplicantContact::create([
            'applicant_id' => $id,
            'relation_id' => $request->relation_id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json([
            'success'=>'Emergency Contact inserted successfully',
            'url'=> route('recruitments.applicants.show', $id)
        ]);
    }

    public function contactEdit($id)
    {
        $data['id'] = $id;
        $data['contact'] = RecruitmentApplicantContact::find($id);

        return !empty(access('contact/edit')) ? view('recruitments.applicants.contact_form', $data) : abort(401);
    }

    public function contactUpdate(RecruitmentApplicantContactRequest $request, $id)
    {
        $contact = RecruitmentApplicantContact::find($id);
        $contact->name = $request->name;
        $contact->relation_id = $request->relation_id;
        $contact->phone_number = $request->phone_number;
        $contact->save();

        return response()->json([
            'success'=>'Contact updated successfully',
            'url'=> route('recruitments.applicants.show', $contact->applicant_id)
        ]);
    }

    public function contactDestroy($id)
    {
        RecruitmentApplicantContact::find($id)->delete();

        Alert::success('Success', 'Contact deleted successfully');

        return redirect()->back();
    }

    public function familyCreate($id)
    {
        return !empty(access('family/create')) ? view('recruitments.applicants.family_form', compact('id')) : abort(401);
    }

    public function familyStore(RecruitmentApplicantFamilyRequest $request, $id)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('name')).'_'.time(),
            $this->familyPath);

        RecruitmentApplicantFamily::create([
            'applicant_id' => $id,
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
            'url'=> route('recruitments.applicants.show', $id)
        ]);
    }

    public function familyEdit($id)
    {
        $data['id'] = $id;
        $data['family'] = RecruitmentApplicantFamily::find($id);

        return !empty(access('family/edit')) ? view('recruitments.applicants.family_form', $data) : abort(401);
    }

    public function familyUpdate(RecruitmentApplicantFamilyRequest $request, $id)
    {
        $family = RecruitmentApplicantFamily::find($id);
        $filename = $request->exist_filename ? $family->filename : '';
        if($family->filename && $filename == '')
            \Storage::disk('public')->delete($family->filename);
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
            'url'=> route('recruitments.applicants.show', $family->applicant_id)
        ]);
    }

    public function familyDestroy($id)
    {
        $family = RecruitmentApplicantFamily::find($id);
        Storage::disk('public')->delete($family->filename);
        $family->delete();

        Alert::success('Success', 'Family deleted successfully');

        return redirect()->back();
    }

    public function educationCreate($id)
    {
        return !empty(access('education/create')) ? view('recruitments.applicants.education_form', compact('id')) : abort(401);
    }

    public function educationStore(RecruitmentApplicantEducationRequest $request, $id)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('name')).'_'.time(),
            $this->educationPath);

        RecruitmentApplicantEducation::create([
            'applicant_id' => $id,
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
            'url'=> route('recruitments.applicants.show', $id)
        ]);
    }

    public function educationEdit($id)
    {
        $data['id'] = $id;
        $data['edu'] = RecruitmentApplicantEducation::find($id);

        return !empty(access('education/edit')) ? view('recruitments.applicants.education_form', $data) : abort(401);
    }

    public function educationUpdate(RecruitmentApplicantEducationRequest $request, $id)
    {
        $education = RecruitmentApplicantEducation::find($id);
        $filename = $request->exist_filename ? $education->filename : '';
        if($education->filename && $filename == '')
            \Storage::disk('public')->delete($education->filename);
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
            'url'=> route('recruitments.applicants.show', $education->applicant_id)
        ]);
    }

    public function educationDestroy($id)
    {
        $education = RecruitmentApplicantEducation::find($id);
        Storage::disk('public')->delete($education->filename);
        $education->delete();

        Alert::success('Success', 'Education deleted successfully');

        return redirect()->back();
    }

    public function workCreate($id)
    {
        return !empty(access('work/create')) ? view('recruitments.applicants.work_form', compact('id')) : abort(401);
    }

    public function workStore(RecruitmentApplicantWorkRequest $request, $id)
    {
        $filename = uploadFile(
            $request->file('filename'),
            Str::slug($request->input('company')).'_'.time(),
            $this->workPath);

        RecruitmentApplicantWork::create([
            'applicant_id' => $id,
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
            'url'=> route('recruitments.applicants.show', $id)
        ]);
    }

    public function workEdit($id)
    {
        $data['id'] = $id;
        $data['work'] = RecruitmentApplicantWork::find($id);

        return !empty(access('work/edit')) ? view('recruitments.applicants.work_form', $data) : abort(401);
    }

    public function workUpdate(RecruitmentApplicantWorkRequest $request, $id)
    {
        $work = RecruitmentApplicantWork::find($id);
        $filename = $request->exist_filename ? $work->filename : '';
        if($work->filename && $filename == '')
            \Storage::disk('public')->delete($work->filename);
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
            'url'=> route('recruitments.applicants.show', $work->applicant_id)
        ]);
    }

    public function workDestroy($id)
    {
        $work = RecruitmentApplicantWork::find($id);
        Storage::disk('public')->delete($work->filename);
        $work->delete();

        Alert::success('Success', 'Work Experience deleted successfully');

        return redirect()->back();
    }
}
