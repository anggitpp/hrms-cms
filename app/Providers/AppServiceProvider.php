<?php

namespace App\Providers;

use App\Models\Setting\Menu;
use App\Models\Setting\Parameter;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Artisan::call('storage:link');
        Paginator::useBootstrap();
        $listFolder = DB::table("app_moduls")->select(DB::raw("CONCAT(target, '.*') as target"))->pluck("target")->toArray();
        view()->composer($listFolder, function ($view) {
            if (\Auth::check()) {
                $arrURL = explode('/', $this->app->request->getRequestUri());//GET URL
                $selectedModul = $arrURL[1];
                $param = !empty($arrURL[2]) ? explode('?', $arrURL[2])[1] ?? '' : ''; //GET LIST PARAM
                $selectedMenu = !empty($arrURL[2]) ? explode('?', $arrURL[2])[0] ?? '' : ''; //GET LIST PARAM
                $dataAccess = DB::table('app_user_accesses as t1')
                    ->select('t1.id', 't1.group_id', 't1.menu_id', 't1.name',
                        't2.modul_id', 't2.name as menuName', 't2.target as menuTarget', 't2.icon as menuIcon', 't2.parent_id as parentMenu', 't2.parameter',
                        't3.name as modulName', 't3.icon as modulIcon', 't3.target as modulTarget',
                        't4.name as subModulName', 't4.id as subModulId'
                    )
                    ->join('app_menus as t2', 't1.menu_id', 't2.id')
                    ->join('app_moduls as t3', 't2.modul_id', 't3.id')
                    ->join('app_sub_moduls as t4', 't2.sub_modul_id', 't4.id')
                    ->where('t1.group_id', DB::raw(\Auth::user()->group_id))
                    ->orderBy('t3.order', 'asc')
                    ->orderBy('t4.order', 'asc')
                    ->orderBy('t2.order', 'asc')
                    ->get();
                //GET ACCESS MODUL, SUBMODUL, MENU
                foreach ($dataAccess as $key => $value){
                    //GET ACTION ACCESS FOR MENU
                    $accessed[$value->modulTarget]['access'][$value->menuTarget][$value->name] = $value->menu_id;
                    //GET DATA FROM ACCESSED MODUL
                    $accessed[$value->modulTarget]['modul'] = implode('|', array($value->modulName, $value->modulIcon, $value->modulTarget));
                    //GET DATA FROM ACCESSED SUB MODUL
                    $accessed[$value->modulTarget]['submodul'][$value->subModulId] = implode('|', array($value->subModulName));
                    //GET DATA FROM ACCESSED MENU WITHOUT PARENT
                    if($value->parentMenu == 0)
                        $accessed[$value->modulTarget]['menu'][$value->subModulId][$value->menu_id] = implode('|', array($value->menuName, $value->menuTarget, $value->menuIcon));
                    //GET DATA FROM ACCESSED MENU WITH PARENT
                    if($value->parentMenu != 0)
                        $accessed[$value->modulTarget]['parentMenu'][$value->parentMenu][$value->menu_id] = implode('|', array($value->menuName, $value->menuTarget, $value->menuIcon));
                    $menu[$value->modulTarget][$value->menuTarget] = array("name" => $value->menuName, "target" => $value->menuTarget, "parameter" => $value->parameter);
                }

                foreach ($accessed as $moduls => $lists){
                    if(!empty($lists['parentMenu'])) {
                        foreach ($lists['parentMenu'] as $key => $values) {
                            if ($key != 0) {
                                foreach ($values as $k => $v) {
                                    $accessed[$moduls]['childMenus'][$key][$k] = $v;
                                }
                            }
                        }
                    }
                }

                if (!empty($arrURL[1])) {
                    $view->with('parameter', $param);
                    $view->with('maincolor', '#7367F0');
                    $view->with('accessed', $accessed);
                    $view->with('access', $accessed[$selectedModul]['access'][$selectedMenu]);
                    $view->with('arrMenu', $menu[$selectedModul][$selectedMenu]);
                }
            }
        });
    }
}
