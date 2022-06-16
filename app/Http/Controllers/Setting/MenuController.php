<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Menu;
use App\Models\Setting\MenuAccess;
use App\Models\Setting\Modul;
use App\Models\Setting\SubModul;
use App\Models\Setting\User;
use App\Models\Setting\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['moduls'] = Modul::orderBy('order')
            ->pluck('name','id')
            ->toArray(); //GET LIST MODUL

        $data['filterModul'] = $request->get('filterModul') ??
            DB::table('app_moduls')
                ->orderBy('order')
                ->value('id') ; //GET FILTER MODUL

        $data['submoduls'] = SubModul::where('modul_id', '=', $data['filterModul'])
            ->orderBy('order')
            ->pluck('name','id')
            ->toArray(); //GET LIST MODUL

        $getFirstSubModul = DB::table('app_sub_moduls')
            ->where('modul_id', '=', $data['filterModul'])
            ->orderBy('order')
            ->value('id'); //GET FIRST SUB MODUL

        $filterSubModul = $request->get('filterSubModul') ??
            DB::table('app_sub_moduls')
                ->where('modul_id', '=', $data['filterModul'])
                ->orderBy('order')
                ->value('id'); //GET FILTER SUB MODUL

        $getExist = SubModul::where('modul_id', $data['filterModul'])
        ->where('id', $filterSubModul)
        ->pluck('id', 'id')->all(); //CHECK IF CHOOSED SUB MODUL ARE PART OF MODUL

        $data['filterSubModul'] = empty($getExist) ? $getFirstSubModul : $filterSubModul;

        $sql = Menu::query(); //GET MODEL
        $data['filter'] = $request->get('filter'); //GET FILTER

        if(!empty($data['filter']))
            $sql->where('name', 'like', '%'.$data['filter'].'%'); //check if not empty then where
        $sql->where('modul_id', '=', $data['filterModul']); //check if not empty then where
        $sql->where('parent_id', 0);
        $sql->where('sub_modul_id', '=', $data['filterSubModul']); //check if not empty then where
        $data['menus'] = $sql->orderBy('order')->paginate(10)->onEachSide(1); //FINAL RESULT

        return view('settings.menus.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['status'] = defaultStatus();
        $data['screen'] = array("f" => 'Tidak', "t" => 'Ya');
        $data['listAccess'] = array("1" => "CRUD", "2" => "View Only");

        $data['defaultModul'] = DB::table('app_moduls')
            ->orderBy('order')
            ->value('id'); // GET FIRST MODUL IN COMBODATA

        $data['moduls'] = Modul::orderBy('name')
            ->pluck('name','id')
            ->toArray(); //GET LIST MODUL

        $data['sub_moduls'] = SubModul::where('modul_id',$request->filterModul ?? $data['defaultModul']) //CHECK IF FILTERED
        ->orderBy('order')
            ->pluck('name','id')
            ->toArray();//GET LIST SUB MODUL WHERE FIRST MODUL

        $checkSubModulValid = DB::table('app_sub_moduls')
            ->where('id', $request->filterSubModul)
            ->where('modul_id', $request->filterModul)
            ->orderBy('order','asc')
            ->value('id'); //CHECK IS FILTERED SUB MODUL VALID WITH MODUL

        $data['defaultSubModul'] = $request->filterSubModul && $checkSubModulValid ? $request->filterSubModul //IF FILTER VALID THEN USE FILTER, IF NOT USE FIRST SUB MODUL IN SELECTED MODUL
            : DB::table('app_sub_moduls')
                ->where('modul_id','=',$request->filterModul ?? $data['defaultModul']) //CHECK IF FILTERED
                ->orderBy('order','asc')
                ->value('id');

        $data['lastMenu'] = DB::table('app_menus')
                ->where('modul_id', '=',$request->filterModul ?? $data['defaultModul'])
                ->where('sub_modul_id', $data['defaultSubModul'])
                ->where('parent_id', 0)
                ->orderBy('order','desc')
                ->value('order') + 1; //GET LAST ORDER

        return  view('settings.menus.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request->parent_id)){
            $parentData = Menu::find($request->parent_id);
        }
        $menu = Menu::create([
            'parent_id' => $request->parent_id ?? '',
            'modul_id' => $request->modul_id ?? $parentData->modul_id,
            'sub_modul_id' => $request->sub_modul_id ?? $parentData->sub_modul_id,
            'name' => $request->name,
            'target' => $request->target,
            'description' => $request->description,
            'icon' => $request->icon,
            'status' => $request->status,
            'order' => $request->order,
            'controller' => $request->controller,
            'parameter' => $request->parameter,
            'full_screen' => $request->full_screen,
        ]);

        $arrPermission = array(
            "index" => array("get", "")
        );

        if($request->access == 1) {
            $arrPermission = array(
                "index" => array("get", ""),
                "create" => array("get", ""),
                "store" => array("post", ""),
                "edit" => array("get", "id"),
                "update" => array("patch", "id"),
                "destroy" => array("delete", "id"),
            );
        }

        foreach ($arrPermission as $key => $value){
          MenuAccess::create([
              'menu_id' => $menu->id,
              'name' => $key,
              'method' => $value[0],
              'param' => $value[1]
          ]);

          UserAccess::create([
              'group_id' => 1,
              'menu_id' => $menu->id,
              'name' => $key
          ]);
        }


        Alert::success('Success', 'Menu inserted successfully');

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['menu'] = Menu::find($id);
        $data['status'] = defaultStatus();
        $data['screen'] = array("f" => 'Tidak', "t" => 'Ya');
        $data['moduls'] = Modul::orderBy('name')
            ->pluck('name','id')
            ->toArray(); //GET LIST MODUL

        $data['sub_moduls'] = SubModul::where('modul_id','=', $data['menu']->modul_id) //CHECK IF FILTERED
        ->orderBy('name')
            ->pluck('name','id')
            ->toArray();//GET LIST SUB MODUL WHERE FIRST MODUL

        $data['menuAccesses'] = MenuAccess::where('menu_id',$id)->pluck('name','name')->toArray();

        return  view('settings.menus.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        $menu->modul_id = $request->modul_id ?? $menu->modul_id;
        $menu->sub_modul_id = $request->sub_modul_id ?? $menu->sub_modul_id;
        $menu->name = $request->name;
        $menu->target = $request->target;
        $menu->description = $request->description;
        $menu->icon = $request->icon;
        $menu->status = $request->status;
        $menu->order = $request->order;
        $menu->controller = $request->controller;
        $menu->parameter = $request->parameter;
        $menu->full_screen = $request->full_screen;
        $menu->save();

        Alert::success('Success', 'Menu updated successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Menu::find($id)->delete();
        MenuAccess::where('menu_id', $id)->delete();
        UserAccess::where('menu_id', $id)->delete();

        Alert::success('Success', 'Menu deleted successfully');

        return redirect()->back();
    }

    /**
     * Display a listing of the permission menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function permission($id)
    {
        $data['accesses'] = MenuAccess::where('menu_id',$id)->where('type', NULL)->get();

        return view('settings.menus.permission', $data);
    }

    public function permissionCreate($id)
    {
        $data['menu'] = Menu::find($id);
        $data['listMethod'] = array('get' => 'get', 'post' => 'post', 'patch' => 'patch', 'delete' => 'delete');

        return view('settings.menus.permission_form', $data);
    }

    public function permissionStore(Request $request, $id){
        MenuAccess::create([
            'menu_id' => $id,
            'name' => $request->name,
            'method' => $request->methods,
            'param' => $request->param,
        ]);

        UserAccess::create([
            'group_id' => 1,
            'menu_id' => $id,
            'name' => $request->name
        ]);

        Alert::success('Success', 'Menu Access inserted successfully');

        return redirect()->route('settings.menus.permission', $id);
    }

    public function permissionEdit($id)
    {
        $data['accesses'] = MenuAccess::find($id);
        $data['listMethod'] = array('get' => 'get', 'post' => 'post', 'patch' => 'patch', 'delete' => 'delete');

        return view('settings.menus.permission_form', $data);
    }

    public function permissionUpdate(Request $request, $id)
    {
        $accesses = MenuAccess::find($id);

        $useraccess = UserAccess::where([
            ['menu_id', $accesses->menu_id],['name', $accesses->name]
        ])->first();
        $useraccess->name = $request->name;
        $useraccess->save();

        $accesses->name = $request->name;
        $accesses->method = $request->methods;
        $accesses->param = $request->param;
        $accesses->save();


        Alert::success('Success', 'Menu Access updated successfully');

        return redirect()->route('settings.menus.permission', $accesses->menu_id);
    }

    public function permissionDestroy($id)
    {
        $accesses = MenuAccess::find($id);
        $accesses->delete();

        $useraccess = UserAccess::where([
            ['menu_id', $accesses->menu_id],['name', $accesses->name]
        ])->first();

        if($useraccess){
            $useraccess->delete();
        }

        Alert::success('Success', 'Menu Access deleted successfully');

        return redirect()->route('settings.menus.permission', $accesses->menu_id);
    }

    public function permissionCreateCRUD($menuId){
        $menu = Menu::find($menuId);

        return view('settings.menus.permission_crud', compact('menu'));
    }

    public function permissionStoreCRUD(Request $request, $menuId){
        $arrPermission = array(
            "index" => array("get", $request->param),
            "create" => array("get", $request->param),
            "store" => array("post", $request->param),
            "edit" => array("get", $request->param),
            "update" => array("patch", $request->param),
            "destroy" => array("delete", $request->param),
        );

        foreach ($arrPermission as $key => $value){
            $name = $key == "index" ? $request->name : $request->name."/".$key;
            MenuAccess::create([
                'menu_id' => $menuId,
                'name' => $name,
                'method' => $value[0],
                'param' => $value[1]
            ]);

            //GIVE ACCESS TO DEVELOPER
            UserAccess::create([
                'group_id' => 1,
                'menu_id' => $menuId,
                'name' => $name
            ]);
        }

        Alert::success('Success', 'Menu Access inserted successfully');

        return redirect()->route('settings.menus.permission', $menuId);
    }

    public function createChild(Request $request, $id)
    {
        $data['status'] = defaultStatus();
        $data['listAccess'] = array("1" => "CRUD", "2" => "View Only");

        $data['parentMenu'] = Menu::find($id); //GET DATA PARENT

        $data['defaultModul'] = DB::table('app_moduls')
            ->orderBy('order')
            ->value('id'); // GET FIRST MODUL IN COMBODATA

        $data['moduls'] = Modul::orderBy('name')
            ->pluck('name','id')
            ->toArray(); //GET LIST MODUL

        $data['sub_moduls'] = SubModul::where('modul_id',$request->filterModul ?? $data['defaultModul']) //CHECK IF FILTERED
        ->orderBy('order')
            ->pluck('name','id')
            ->toArray();//GET LIST SUB MODUL WHERE FIRST MODUL

        $checkSubModulValid = DB::table('app_sub_moduls')
            ->where('id', $request->filterSubModul)
            ->where('modul_id', $request->filterModul)
            ->orderBy('order','asc')
            ->value('id'); //CHECK IS FILTERED SUB MODUL VALID WITH MODUL

        $data['defaultSubModul'] = $request->filterSubModul && $checkSubModulValid ? $request->filterSubModul //IF FILTER VALID THEN USE FILTER, IF NOT USE FIRST SUB MODUL IN SELECTED MODUL
            : DB::table('app_sub_moduls')
                ->where('modul_id','=',$request->filterModul ?? $data['defaultModul']) //CHECK IF FILTERED
                ->orderBy('order','asc')
                ->value('id');

        $data['lastMenu'] = DB::table('app_menus')
                ->where('parent_id', $id)
                ->orderBy('order','desc')
                ->value('order') + 1; //GET LAST ORDER

        return  view('settings.menus.form', $data);
    }

    public function functions($id)
    {
        $data['accesses'] = MenuAccess::where([
            ['menu_id',$id],
            ['type',1]
        ])
            ->get();
        $data['id'] = $id;

        return view('settings.menus.function', $data)->with($id);
    }

    public function functionCreate($id)
    {
        $data['menu'] = Menu::find($id);
        $data['listMethod'] = array('get' => 'get', 'post' => 'post', 'patch' => 'patch', 'delete' => 'delete');

        return view('settings.menus.function_form', $data);
    }

    public function functionStore(Request $request, $id){
        MenuAccess::create([
            'menu_id' => $id,
            'type' => 1,
            'name' => $request->name,
            'method' => $request->methods,
            'param' => $request->param,
        ]);

        Alert::success('Success', 'Function inserted successfully');

        return redirect()->route('settings.menus.functions', $id);
    }

    public function functionEdit($id)
    {
        $data['accesses'] = MenuAccess::find($id);
        $data['listMethod'] = array('get' => 'get', 'post' => 'post', 'patch' => 'patch', 'delete' => 'delete');

        return view('settings.menus.function_form', $data);
    }

    public function functionUpdate(Request $request, $id)
    {
        $accesses = MenuAccess::find($id);

        $accesses->name = $request->name;
        $accesses->method = $request->methods;
        $accesses->param = $request->param;
        $accesses->save();


        Alert::success('Success', 'Function updated successfully');

        return redirect()->route('settings.menus.functions', $accesses->menu_id);
    }

    public function functionDestroy($id)
    {
        $accesses = MenuAccess::find($id);
        $accesses->delete();

        Alert::success('Success', 'Function deleted successfully');

        return redirect()->route('settings.menus.functions', $accesses->menu_id);
    }
}
