<?php

namespace App\Http\Controllers;

use App\Models\Setting\Menu;
use App\Models\Setting\Parameter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function access($name)
    {
        $arrURL = explode('/', \Request::url());//GET URL
        $modul = !empty($arrURL[3]) ? $arrURL[3] : ''; //GET MODUL
        $menu = !empty($arrURL[4]) ? explode('?', $arrURL[4])[0] ?? '' : ''; //GET MENU WITHOUT PARAM

        $access = DB::table('app_user_accesses')
            ->select('app_user_accesses.name', 'app_user_accesses.id')
            ->join('app_menus', function ($join) use ($menu, $name) {
                $join->on('app_user_accesses.menu_id', 'app_menus.id');
                $join->on('app_user_accesses.group_id', DB::raw(\Auth::user()->group_id));
                $join->where('app_menus.target', $menu);
                $join->where('app_user_accesses.name', $name);
            })
            ->join('app_moduls', function ($join) use ($modul) {
                $join->on('app_menus.modul_id', 'app_moduls.id');
                $join->where('app_moduls.target', $modul);
            })
            ->pluck('app_user_accesses.id', 'app_user_accesses.name')->toArray(); //JOIN TO GET ACCESS

//        dd($access);

        return $access;
    }

    public function menu($menu = null, $modul = null)
    {
        $arrURL = explode('/', \Request::url());//GET URL
        $currentModul = $modul ?? $arrURL[3]; //GET MODUL
        if(isset($arrURL[4])){
            $currentMenu = $menu ?? explode('?', $arrURL[4])[0]; //GET MENU WITHOUT PARAM
            $list = DB::table('app_menus')
                ->select('app_menus.*')
                ->join('app_moduls', function ($join) use ($currentMenu, $currentModul) {
                    $join->on('app_menus.modul_id', 'app_moduls.id');
                    $join->where('app_moduls.target', $currentModul);
                    $join->where('app_menus.target', $currentMenu);
                })->first();
        }

        return $list ?? [];
    }

    public function defaultPagination($request)
    {
        return $request->get('paginate') ?? 10;
    }

    public function getParameter($value)
    {
        $parameter =Parameter::where('code', $value)->first();

        return $parameter->value;
    }
}
