<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Group;
use App\Models\Setting\GroupModul;
use App\Models\Setting\Menu;
use App\Models\Setting\MenuAccess;
use App\Models\Setting\Modul;
use App\Models\Setting\SubModul;
use App\Models\Setting\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = Modul::query()->orderBy('order'); //SET QUERY
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['moduls'] = $sql->paginate($this->defaultPagination($request)); //FINAL RESULT

        return  view('settings.moduls.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['status'] = defaultStatus();
        $data['lastModul'] = DB::table('app_moduls')
                ->orderBy('order','desc')
                ->value('order') + 1; //GET LAST ORDER


        return view('settings.moduls.form', $data);
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
            ['name','target']
        )
        ,[
            'name' => 'required',
            'target' => 'required',

        ]);

        if ($validator->fails())
        {
            return response()->json(
                ['errors'=>$validator->errors()]
            );
        }

        Modul::create([
            'name' => $request->name,
            'target' => $request->target,
            'description' => $request->description ?? '',
            'icon' => $request->icon ?: '',
            'status' => $request->status ?: '',
            'order' => $request->order ?: '',
        ]);

        return response()->json([
            'success'=>'Modul inserted successfully',
            'url'=> route('settings.moduls.index')
        ]);
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
        $data['modul'] = Modul::find($id);

        return view('settings.moduls.form', $data);
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
                ['name','target']
            )
            ,[
            'name' => 'required',
            'target' => 'required',

        ]);

        if ($validator->fails())
        {
            return response()->json(
                ['errors'=>$validator->errors()]
            );
        }

        $modul = Modul::find($id);
        $modul->name = $request->name;
        $modul->target = $request->target;
        $modul->description = $request->description ?? '';
        $modul->icon = $request->icon ?? '';
        $modul->status = $request->status ?? '';
        $modul->order = $request->order ?? '';
        $modul->save();

        return response()->json([
            'success'=>'Modul updated successfully',
            'url'=> route('settings.moduls.index')
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
        Modul::find($id)->delete();
        GroupModul::where('modul_id', $id)->delete();
        SubModul::where('modul_id', $id)->delete();
        $menus = Menu::where('modul_id', $id)->get();
        foreach ($menus as $key => $menu){
            MenuAccess::where('menu_id', $menu->id)->delete();
            UserAccess::where('menu_id', $menu->id)->delete();
            Menu::find($menu->id)->delete();
        }

        Alert::success('Success', 'Modul deleted successfully');

        return redirect()->back();
    }
}
