<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Setting\Modul;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$access = config('global.access');

Route::get('/', function () {
    if(Auth::check()) {
        $firstMenu = DB::table('app_moduls')
            ->select('app_moduls.target as modulTarget', 'app_menus.target as menuTarget')
            ->join('app_menus', function ($join) {
                $join->on('app_menus.modul_id', 'app_moduls.id');
                $join->where('app_moduls.status', 't');
                $join->where('app_menus.status', 't');
            })
            ->join('app_sub_moduls', 'app_sub_moduls.modul_id', 'app_moduls.id')
            ->join('app_user_accesses', function ($join) {
                $join->on('app_menus.id', 'app_user_accesses.menu_id');
                $join->where('app_user_accesses.name', 'index');
                $join->on('app_user_accesses.group_id', DB::raw(\Auth::user()->group_id));
            })
            ->orderBy('app_moduls.order', 'asc')
            ->orderBy('app_sub_moduls.order', 'asc')
            ->orderBy('app_menus.order', 'asc')
            ->get()->first();

        return isset($firstMenu) ? redirect()->route(implode('.', array($firstMenu->modulTarget, $firstMenu->menuTarget, 'index'))) : abort(404);
    }

    return view('auth.login');

});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Modul::all()->each(function ($modul) { //LOOP ALL MODUL
        Route::prefix($modul->target)->group(function () use($modul) { //SET PREFIX MODUL
            $modul->menu->each(function ($menu) { //LOOP MENU FROM MODUL
                $menu->menuAccess->each(function ($menuAccess) use ($menu) { //LOOP MENU ACCESS FROM MENU
                    $arrParam = explode(', ', $menuAccess->param); //MAKE PARAM TO ARRAY
                    $listParam = '';
                    foreach ($arrParam as $key => $value) {
                        if (!empty($value)) {
                            $listParam .= '{' . $value . '}/'; //COMBINE PARAMETER
                        }
                    }

                    $controllerName = $menuAccess->name ;
                    if(str_contains($menuAccess->name, '/')) {
                        list($subgroup, $accessname) = explode('/', $menuAccess->name);
                        $controllerName = $subgroup . ucfirst($accessname);
                    } //CHECK IF MENU HAVE MORE CRUDS

                    Route::{$menuAccess->method}//GET ROUTE METHOD
                    (
                        $menu->target . "/" . //GET MENU TARGET
                        ($menuAccess->name != 'index' ? $menuAccess->name . "/" : '') . //GET ACCESS NAME
                        ($listParam ?? '') //CHECK IF ANY PARAM THEN USE
                        , "App\Http\Controllers\\" . $menu->controller . '@' . $controllerName) //SET CONTROLLER AND METHOD USING
                        ->name(implode('.', array($menu['modul']->target,
                        $menu->target,str_replace('/','.', $menuAccess->name)))); // SET ROUTE NAME
                });
            });
        });
    });
});
