<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting\Group;
use App\Models\Setting\GroupModul;
use App\Models\Setting\MenuAccess;
use App\Models\Setting\Modul;
use App\Models\Setting\UserAccess;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sql = Group::query(); //SET QUERY
        $data['filter'] = $request->get('filter'); //GET FILTER
        if (!empty($data['filter']))
            $sql->where('name', 'like', '%' . $data['filter'] . '%'); //check if not empty then where
        $data['groups'] = $sql->paginate(10)->onEachSide(1); //FINAL RESULT

        return view('settings.groups.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['status'] = defaultStatus();
        $data['moduls'] = Modul::active()->orderBy('order')->get();

        return view('settings.groups.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $group = new Group;
        $group->name = $request->name;
        $group->description = $request->description;
        $group->status = $request->status;
        $group->save();

        GroupModul::where('group_id', $group->id)->delete();
        if (is_array($request->moduls)) {
            foreach ($request->moduls as $key => $value) {
                GroupModul::create([
                    'group_id' => $group->id,
                    'modul_id' => $key,
                ]);
            }
        }

        Alert::success('Success', 'Group created successfully');

        return redirect()->route('settings.groups.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['status'] = defaultStatus();
        $data['group'] = Group::find($id);
        $data['moduls'] = Modul::active()->orderBy('order')->get();
        $data['groupModuls'] = GroupModul::where('group_id', $id)->pluck('modul_id', 'modul_id')->toArray();

        return view('settings.groups.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $group = Group::find($id);
        $group->name = $request->name;
        $group->description = $request->description;
        $group->status = $request->status;
        $group->save();

        GroupModul::where('group_id', $id)->delete();
        if (is_array($request->moduls)) {
            foreach ($request->moduls as $key => $value) {
                GroupModul::create([
                    'group_id' => $id,
                    'modul_id' => $key,
                ]);
            }
        }

        Alert::success('Success', 'Group updated successfully');

        return redirect()->route('settings.groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        Group::find($id)->delete();
        GroupModul::where('group_id', $id)->delete();
        UserAccess::where('group_id', $id)->delete();

        Alert::success('Success', 'Group deleted successfully');

        return redirect()->back();
    }
}
