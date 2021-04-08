<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PresenceInController;
use App\Http\Controllers\PresenceOutController;
use App\Http\Controllers\PresenceListController;
use App\Http\Controllers\ScheduleController;

use App\Http\Controllers\FullCalenderController;

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

Route::get('/presence_list/json', [PresenceListController::class, 'json']);
Route::resource('presence_list', PresenceListController::class);

Route::get('/schedule_json', [ScheduleController::class, 'schedule_json']);
Route::get('/schedule_manage', [ScheduleController::class, 'schedule_manage']);
Route::post('/import_action', [ScheduleController::class, 'import_action'])->name('import_action');
Route::resource('schedule', ScheduleController::class);

Route::get('fullcalender', [FullCalenderController::class, 'index']);
Route::post('fullcalenderAjax', [FullCalenderController::class, 'ajax']);