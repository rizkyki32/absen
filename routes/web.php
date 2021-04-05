<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PresenceInController;
use App\Http\Controllers\PresenceOutController;
use App\Http\Controllers\PresenceListController;

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
