<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Group;
use App\Models\Setting\MenuAccess;
use App\Models\Setting\Modul;
use App\Models\Setting\SubModul;
use App\Models\Setting\UserAccess;
use Illuminate\Http\Request;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class UserAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = Group::query(); //SET QUERY
        $sql->where('status', 't');
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['groups'] = $sql->paginate(10)->onEachSide(1); //FINAL RESULT

        return view('settings.accesses.index', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['group'] = Group::find($id);
        $data['moduls'] = Modul::active()
//            ->where('id', 2)
            ->with('submodul')
            ->orderBy('order')
            ->get();
        $data['listPermissions'] = array(
            "view" => "View",
            "add" => "Add",
            "edit" => "Edit",
            "delete" => "Delete",
            "import" => "Import",
            "export" => "Export",
            "acclv1" => "Level 1",
            "acclv2" => "Level 2",
            "acclv3" => "Level 3");
        $menuAccess = DB::table('app_menu_accesses')
            ->leftJoin('app_user_accesses',function($join) use ($id){
                $join->on('app_menu_accesses.menu_id', 'app_user_accesses.menu_id');
                $join->on('app_menu_accesses.name', 'app_user_accesses.name');
                $join->on('app_user_accesses.group_id', DB::raw($id));
            })
            ->select( 'app_menu_accesses.name', 'app_menu_accesses.menu_id', 'app_user_accesses.id')
            ->get();
        foreach ($menuAccess as $key => $value){
            $data['menuAccesses'][$value->menu_id][$value->name] = $value->id ?? '';
        }

        return view('settings.accesses.form', $data);
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
        UserAccess::where('group_id',$id)->delete();
        foreach ($request->access as $key => $value){
            list($menu_id, $name) = explode("_", $key);
            UserAccess::create([
                'group_id' => $id,
                'menu_id' => $menu_id,
                'name' => $name,
            ]);
        }

        Alert::success('Success', 'User Access updated successfully');

        return redirect()->route('settings.accesses.index');    }

}
