<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'first'])->name('default');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::namespace('Auth')->group(function () {
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'process_login'])->name('login');
    Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});

Route::get('/p_analyse', [App\Http\Controllers\PowerballController::class, 'view'])->name('p_analyse');
Route::get('/board', [App\Http\Controllers\BoardController::class, 'view'])->name('board');
Route::get('/lotto', [App\Http\Controllers\LottoController::class, 'index'])->name('lotto');
Route::get('/speedkenoLog', [App\Http\Controllers\SpeedkenoController::class, 'view'])->name('speeds');
Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat');
Route::get("/market",[App\Http\Controllers\MarketController::class, 'view'])->name('market');
Route::get("/chatRoom",[App\Http\Controllers\ChatController::class,'roomWait'])->name('room_wait');
Route::get("/discussion",[App\Http\Controllers\ChatController::class,'viewChat'])->name('view-chat');
Route::get("/updateLevelUsers",[App\Http\Controllers\PbUsersController::class,'getUpdateUserLevel']);
Route::prefix('pick')->group(function () {
    Route::get("/powerball",[App\Http\Controllers\PowerballController::class, 'pick'])->name("pick-powerball");
    Route::get("/speedkeno",[App\Http\Controllers\SpeedkenoController::class, 'pick'])->name("pick-speedkeno");
    Route::get("/simulator",[App\Http\Controllers\PowerballController::class, 'check'])->name("pick-simulator");
    Route::get("/winning-machine",[App\Http\Controllers\PowerballController::class, 'winning'])->name("pick-win");
});

Route::get("/member",[App\Http\Controllers\MemberController::class,'index'])->name("member");

