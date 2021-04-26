<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PresenceInController;
use App\Http\Controllers\PresenceOutController;
use App\Http\Controllers\PresenceListController;
use App\Http\Controllers\PresenceHistoryController;
use App\Http\Controllers\PresenceReportController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleTypeCotroller;
use App\Http\Controllers\ShiftController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('presence_in', PresenceInController::class);
Route::resource('presence_out', PresenceOutController::class);

Route::post('/presence_list/department_json', [PresenceListController::class, 'department_json']);
Route::match(["get", "post"], '/presence_list/search_json', [PresenceListController::class, 'search_json']);
Route::match(["get", "post"], "/presence_search", [PresenceListController::class, 'search']);
Route::get('/presence_list/json', [PresenceListController::class, 'json']);
Route::resource('presence_list', PresenceListController::class);

Route::get('/shift/json', [ShiftController::class, 'json']);
Route::resource('shift', ShiftController::class);

Route::get('/leave/json', [LeaveController::class, 'json']);
Route::resource('leave', LeaveController::class);

Route::get('/schedule_json', [ScheduleController::class, 'schedule_json']);
Route::get('/schedule_manage', [ScheduleController::class, 'schedule_manage']);
Route::match(["get", "post"], "/calendar", [ScheduleController::class, 'calendar']);

Route::post('/import_action', [ScheduleController::class, 'import_action'])->name('import_action');
Route::post('/schedule/user_json', [ScheduleController::class, 'user_json']);
Route::resource('schedule', ScheduleController::class);

Route::get('/schedule_type/json', [ScheduleTypeCotroller::class, 'json']);
Route::resource('schedule_type', ScheduleTypeCotroller::class);

Route::post('/presence_history/department_json', [PresenceHistoryController::class, 'department_json']);
Route::match(["get", "post"], '/presence_history/search_json', [PresenceHistoryController::class, 'search_json']);
Route::resource('presence_history', PresenceHistoryController::class);

Route::get('/presence_report/{id}', [PresenceReportController::class, 'index']);