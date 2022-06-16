<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Modul;
use App\Models\Setting\SubModul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class SubModulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['moduls'] = Modul::orderBy('order')->pluck('name','id')->toArray();
        $sql = SubModul::orderBy('order'); //GET MODEL
        $data['filter'] = $request->get('filter'); //GET FILTER
        $data['filterModul'] = $request->get('filterModul') ?? DB::table('app_moduls')->orderBy('order','asc')->value('id') ; //GET FILTER
        if(!empty($data['filter']))
            $sql->where('name', '=', $data['filter']); //check if not empty then where
        $sql->where('modul_id', '=', $data['filterModul']); //check if not empty then where
        $data['submoduls'] = $sql->paginate(10)->onEachSide(1); //FINAL RESULT

        return view('settings.submoduls.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['defaultModul'] = DB::table('app_moduls')
            ->orderBy('order','asc')
            ->value('id'); // GET FIRST MODUL IN COMBODATA
        $data['lastSubModul'] = DB::table('app_sub_moduls')
                ->where('modul_id', $request->filterModul ?? $data['defaultModul'])
                ->orderBy('order','desc')
                ->value('order') + 1;
        $data['status'] = defaultStatus();

        $data['moduls'] = Modul::orderBy('name')->pluck('name','id')->toArray();

        return view('settings.submoduls.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SubModul::create([
            'modul_id' => $request->modul_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'order' => $request->order,
        ]);


        Alert::success('Success', 'Sub Modul created successfully');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['status'] = defaultStatus();
        $data['submoduls'] = SubModul::find($id);
        $data['moduls'] = Modul::orderBy('name')->pluck('name','id')->toArray();

        return view('settings.submoduls.form', $data);
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
        $submoduls = SubModul::find($id);
        $submoduls->modul_id = $request->modul_id;
        $submoduls->name = $request->name;
        $submoduls->description = $request->description;
        $submoduls->order = $request->order;
        $submoduls->status = $request->status;
        $submoduls->save();

        Alert::success('Success', 'Sub Modul updated successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SubModul::find($id)->delete();

        Alert::success('Success', 'Sub Modul deleted successfully');

        return redirect()->back();
    }
}
