<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Category;
use App\Models\Setting\Master;
use App\Models\Setting\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['moduls'] = Modul::orderBy('order', 'asc')->pluck('name','id')->toArray();
        $sql = Category::query(); //GET MODEL
        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['filterModul'] = $request->get('filterModul') ??
            DB::table('app_moduls')->orderBy('order','asc')->value('id') ; //GET FILTER
        if(!empty($data['filter']))
            $sql->where('name', '=', $data['filter']); //check if not empty then where
        $sql->where('modul_id', '=', $data['filterModul']); //check if not empty then where
        $data['categories'] = $sql->paginate($this->defaultPagination($request));

        return view('settings.masters.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['defaultModul'] = DB::table('app_moduls')
            ->orderBy('name','asc')
            ->value('id'); // GET FIRST MODUL IN COMBODATA
        $data['categories'] = Category::where('modul_id', $request->filterModul ?? $data['defaultModul'])
            ->orderBy('name')
            ->pluck('name','id')
            ->toArray();
        $data['lastCategory'] = DB::table('app_categories')
                ->where('modul_id', $request->filterModul ?? $data['defaultModul'])
                ->orderBy('order','desc')
                ->value('order') + 1; //GET LAST CATEGORY
        $data['moduls'] = Modul::orderBy('name')->pluck('name','id')->toArray();

        return view('settings.masters.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->only(
                [ 'modul_id', 'name', 'code']
            )
            ,[
            'modul_id' => 'required',
            'name' => 'required',
            'code' => 'required',
        ],
        );

        if ($validator->fails())
        {
            return response()->json(
                ['errors'=>$validator->errors()]
            );
        }

        Category::create([
            'parent_id' => $request->parent_id ?? '',
            'modul_id' => $request->modul_id,
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description ?? '',
            'order' => $request->order ?: '',
        ]);

        return response()->json([
            'success'=>'Category inserted successfully',
            'url'=> route('settings.masters.index')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data['defaultModul'] = DB::table('app_moduls')
            ->orderBy('name','asc')
            ->value('id'); // GET FIRST MODUL IN COMBODATA
        $data['categories'] = Category::where('modul_id', $request->filterModul ?? $data['defaultModul'])
            ->orderBy('name')
            ->pluck('name','id')
            ->toArray();
        $data['category'] = Category::find($id);
        $data['moduls'] = Modul::orderBy('name')->pluck('name','id')->toArray();

        return view('settings.masters.form', $data);
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
        $validator = \Validator::make(
            $request->only(
                [ 'modul_id', 'name', 'code']
            )
            ,[
            'modul_id' => 'required',
            'name' => 'required',
            'code' => 'required',
        ],
        );

        if ($validator->fails())
        {
            return response()->json(
                ['errors'=>$validator->errors()]
            );
        }

        $category = Category::find($id);
        $category->modul_id  = $request->modul_id;
        $category->parent_id  = $request->parent_id;
        $category->name  = $request->name;
        $category->code  = $request->code;
        $category->description  = $request->description;
        $category->order  = $request->order;
        $category->save();

        return response()->json([
            'success'=>'Category updated successfully',
            'url'=> route('settings.masters.index')
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
        $category = Category::find($id);
        $category->delete();
        Master::where('category', $category->code)->delete();

        Alert::success('Success', 'Category deleted successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function master(Request $request, $code)
    {
        $data['id'] = $code;
        $getParentCode = Category::where('code', $code)->value('parent_id');
        if(!empty($getParentCode))
            $data['parents'] = Master::where('app_categories.id', DB::raw($getParentCode))
                ->join('app_categories','app_masters.category','app_categories.code')
                ->active()
                ->pluck('app_masters.name','app_masters.id')->toArray();
        $sql = Master::where('category', $code)->orderBy('order'); //GET MODEL
        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['filterParent'] = $request->get('filterParent'); //GET FILTER
        if(!empty($data['filter']))
            $sql->where('name', 'like', '%'.$data['filter'].'%'); //check if not empty then where
        if(!empty($data['filterParent']))
            $sql->where('parent_id', $data['filterParent']); //check if not empty then where
        $data['masters'] = $sql->paginate($this->defaultPagination($request));

        return view('settings.masters.detail', $data);
    }

    public function masterCreate($code)
    {
        $data['code'] = $code;
        $getParentCode = Category::where('code', $code)->value('parent_id');
        if(!empty($getParentCode))
            $data['parents'] = Master::where('app_categories.id', DB::raw($getParentCode))
                ->join('app_categories', 'app_masters.category', 'app_categories.code')
                ->active()
                ->pluck('app_masters.name', 'app_masters.id')->toArray();
        $data['status'] = defaultStatus();
        $data['lastMaster'] = DB::table('app_masters')
                ->where('category', $code)
                ->orderBy('order','desc')
                ->value('order') + 1; //GET LAST MASTER
        $data['lastCode'] = $code.str_pad($data['lastMaster'], 3, "0", STR_PAD_LEFT);

        return view('settings.masters.master_form', $data);
    }

    public function masterStore(Request $request, $code)
    {

        $validator = \Validator::make(
            $request->only(
                ['name', 'code']
            )
            ,[
            'name' => 'required',
            'code' => 'required',
        ],
        );

        if ($validator->fails())
        {
            return response()->json(
                ['errors'=>$validator->errors()]
            );
        }

        Master::create([
            'parent_id' => $request->parent_id ?: 0,
            'category' => $code ?: '',
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description ?: '',
            'parameter' => $request->parameter ?: '',
            'additional_parameter' => $request->additional_parameter ?: '',
            'status' => $request->status ?: '',
            'order' => $request->order ?: '',
        ]);

        $data['code'] = $code;
        $data['filterParent'] =$request->get('filterParent');
        $data['filter'] =$request->get('filter');

        return response()->json([
            'success'=>'Master inserted successfully',
            'url'=> route('settings.masters.master', $data)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function masterEdit($id)
    {
        $data['master'] = Master::find($id);
        $data['status'] = defaultStatus();

        return view('settings.masters.master_form', $data);
    }

    public function masterUpdate(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->only(
                [ 'name', 'code']
            )
            ,[
            'name' => 'required',
            'code' => 'required',
        ],
        );

        if ($validator->fails())
        {
            return response()->json(
                ['errors'=>$validator->errors()]
            );
        }

        $master = Master::find($id);
        $master->name  = $request->name;
        $master->code  = $request->code;
        $master->description  = $request->description;
        $master->parameter  = $request->parameter;
        $master->additional_parameter  = $request->additional_parameter;
        $master->status  = $request->status;
        $master->order  = $request->order;
        $master->save();

        return response()->json([
            'success'=>'Master updated successfully',
            'url'=> route('settings.masters.master', $master->category)
        ]);
    }

    public function masterDestroy($id)
    {
        Master::find($id)->delete();

        Alert::success('Success', 'Master deleted successfully');

        return redirect()->back();
    }
}
