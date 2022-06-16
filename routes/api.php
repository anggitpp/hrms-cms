<?php

use App\Http\Controllers\API\ApprovalController;
use App\Http\Controllers\API\LeaveController;
use App\Http\Controllers\API\MonitoringController;
use App\Http\Controllers\API\OvertimeController;
use App\Http\Controllers\API\PayrollController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\ReimbursementController;
use App\Http\Controllers\API\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function (){
    //USER SECTION
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/userUpdate', [UserController::class, 'update']);
    Route::post('/updatePassword', [UserController::class, 'updatePassword']);
    Route::get('/users', [UserController::class, 'users']);

    //ATTENDANCE SECTION
    Route::prefix('attendance')->group(function (){
        Route::get('/data/{id}/{date}', [AttendanceController::class, 'getData']);
        Route::post('/inOut', [AttendanceController::class, 'inOut']);
        Route::get('/data/monthly/{id}/{month}/{year}', [AttendanceController::class, 'getDataMonthly']);
    });

    //OVERTIME SECTION
    Route::prefix('overtime')->group(function (){
        Route::post('/store', [OvertimeController::class, 'store']);
        Route::get('/data/monthly/{id}/{month}/{year}', [OvertimeController::class, 'getDataMonthly']);
        Route::get('/getLastNumber', [OvertimeController::class, 'getLastNumber']);
        Route::get('/edit/{id}', [OvertimeController::class, 'edit']);
        Route::delete('/delete/{id}', [OvertimeController::class, 'destroy']);
    });

    //PERMISSION SECTION
    Route::prefix('permission')->group(function (){
        Route::get('/data/monthly/{id}/{month}/{year}', [PermissionController::class, 'getDataMonthly']);
        Route::post('/store', [PermissionController::class, 'store']);
        Route::get('/getLastNumber', [PermissionController::class, 'getLastNumber']);
        Route::get('/edit/{id}', [PermissionController::class, 'edit']);
        Route::delete('/delete/{id}', [PermissionController::class, 'destroy']);
    });

    //LEAVE SECTION
    Route::prefix('leave')->group(function (){
        Route::get('/data/monthly/{id}/{month}/{year}', [LeaveController::class, 'getDataMonthly']);
        Route::post('/store', [LeaveController::class, 'store']);
        Route::get('/edit/{id}', [LeaveController::class, 'edit']);
        Route::delete('/delete/{id}', [LeaveController::class, 'destroy']);
        Route::get('/getLastNumber', [LeaveController::class, 'getLastNumber']);
        Route::get('/getDetailMaster/{id}/{startDate}/{endDate}', [LeaveController::class, 'getDetailMaster']);
        Route::get('/masters', [LeaveController::class, 'getMasters']);
    });

    //REIMBURSEMENT SECTION
    Route::prefix('reimbursement')->group(function (){
        Route::get('/data/monthly/{month}/{year}', [ReimbursementController::class, 'getDataMonthly']);
        Route::post('/store', [ReimbursementController::class, 'store']);
        Route::get('/getLastNumber', [ReimbursementController::class, 'getLastNumber']);
        Route::get('/edit/{id}', [ReimbursementController::class, 'edit']);
        Route::delete('/delete/{id}', [ReimbursementController::class, 'destroy']);
    });

    //SETTING & MASTER SECTION
    Route::prefix('setting')->group(function () {
        Route::get('/masters/{category}', [SettingController::class, 'masters']);
    });

    //APPROVAL SECTION
    Route::prefix('approval')->group(function (){
        Route::get('/list', [ApprovalController::class, 'getListApproval']);
        Route::get('/leaves', [ApprovalController::class, 'getLeaves']);
        Route::get('/leave/{id}', [ApprovalController::class, 'getLeave']);
        Route::post('/leave/update', [ApprovalController::class, 'updateLeave']);

        Route::get('/permissions', [ApprovalController::class, 'getPermissions']);
        Route::get('/permission/{id}', [ApprovalController::class, 'getPermission']);
        Route::post('/permission/update', [ApprovalController::class, 'updatePermission']);

        Route::get('/overtimes', [ApprovalController::class, 'getOvertimes']);
        Route::get('/overtime/{id}', [ApprovalController::class, 'getOvertime']);
        Route::post('/overtime/update', [ApprovalController::class, 'updateOvertime']);

        Route::get('/reimbursements', [ApprovalController::class, 'getReimbursements']);
        Route::get('/reimbursement/{id}', [ApprovalController::class, 'getReimbursement']);
        Route::post('/reimbursement/update', [ApprovalController::class, 'updateReimbursement']);
    });

    //MONITORING SECTION
    Route::prefix('monitoring')->group(function () {
        Route::get('/reports/{date}', [MonitoringController::class, 'getDataReportByDate']);
        Route::get('/report/{id}', [MonitoringController::class, 'getDataReportById']);
        Route::post('/reports/store', [MonitoringController::class, 'storeReport']);
        Route::post('/update', [MonitoringController::class, 'update']);
        Route::get('/lists', [MonitoringController::class, 'getListMonitoring']);
    });

    //PAYROLL SECTION
    Route::prefix('payroll')->group(function () {
        Route::get('/detail/{month}/{year}', [PayrollController::class, 'detail']);
        Route::get('/print/{month}/{year}', [PayrollController::class, 'printPdf']);
    });
});

Route::get('/userDetail/{id}', [UserController::class, 'userDetail']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/activation', [UserController::class, 'activation']);


