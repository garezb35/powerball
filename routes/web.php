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

Route::group(array('middleware' => 'forceSSL'), function() {
  Auth::routes();

  Route::get('/', [App\Http\Controllers\HomeController::class, 'first'])->name('default');
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  //Route::get('/register', [App\Http\Controllers\HomeController::class, 'register'])->name('register');
  Route::namespace('Auth')->group(function () {
      Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'process_login'])->name('login');
      Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
      Route::any('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm']);
  });


  Route::get('/p_analyse', [App\Http\Controllers\PowerballController::class, 'view'])->name('p_analyse');
  Route::get('/board', [App\Http\Controllers\BoardController::class, 'view'])->name('board');
  Route::get('/lotto', [App\Http\Controllers\LottoController::class, 'index'])->name('lotto');
  Route::get('/speedkenoLog', [App\Http\Controllers\SpeedkenoController::class, 'view'])->name('speeds');
  Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat');
  Route::get("/market",[App\Http\Controllers\MarketController::class, 'view'])->name('market');
  Route::get("/memo",[App\Http\Controllers\MemberController::class,'goMemo'])->name("memo");
  Route::get("/chatRoom",[App\Http\Controllers\ChatController::class,'roomWait'])->name('room_wait');
  Route::get("/discussion",[App\Http\Controllers\ChatController::class,'viewChat'])->name('view-chat');
  Route::get("/updateLevelUsers",[App\Http\Controllers\PbUsersController::class,'getUpdateUserLevel']);
  Route::post("/deleteMemo",[App\Http\Controllers\MemberController::class,'deleteMemo']);
  Route::post("/memoSave",[App\Http\Controllers\MemberController::class,'memoSave']);
  Route::post("/memoReport",[App\Http\Controllers\MemberController::class,'memoReport']);
  Route::post("/processFrd",[App\Http\Controllers\MemberController::class,'processFrd']);

  Route::prefix('pick')->group(function () {
      Route::get("/powerball",[App\Http\Controllers\PowerballController::class, 'pick'])->name("pick-powerball");
      Route::get("/speedkeno",[App\Http\Controllers\SpeedkenoController::class, 'pick'])->name("pick-speedkeno");
      Route::get("/simulator",[App\Http\Controllers\PowerballController::class, 'check'])->name("pick-simulator");
      Route::get("/winning-machine",[App\Http\Controllers\PowerballController::class, 'winning'])->name("pick-win");
      Route::get("/powerball/live",[App\Http\Controllers\PowerballController::class,'powLive']);
      Route::get("/psadari/live",[App\Http\Controllers\PowerSadariController::class,'psadariLive']);

  });

  Route::get("/psadari_analyse",[App\Http\Controllers\PowerSadariController::class,'view'])->name("psadari_analyse");

  Route::get("/member",[App\Http\Controllers\MemberController::class,'index'])->name("member");

  Route::get("/myinfo-modify",[App\Http\Controllers\MemberController::class,'modify'])->name("modify");

  Route::post("/uploadImage",[App\Http\Controllers\MemberController::class,'uploadImage']);

  Route::post("/setCharge",[App\Http\Controllers\MemberController::class,'setCharge'])->name("setCharge");

  Route::post("/commentProcess",[App\Http\Controllers\BoardController::class,'commentProcess']);

  Route::get("/board_write",[App\Http\Controllers\BoardController::class,'boardWrite']);

  Route::post("/writePost",[App\Http\Controllers\BoardController::class,'writePost']);

  Route::get("/giftBox",[App\Http\Controllers\MemberController::class,'giftBox']);

  Route::get("/giftPop",[App\Http\Controllers\MemberController::class,'giftPop']);

  Route::get("/ranking",[App\Http\Controllers\MemberController::class,'ranking'])->name("ranking");

  Route::get("/present",[App\Http\Controllers\MemberController::class,'present'])->name("present");

  Route::get("/memberSecurity",[App\Http\Controllers\MemberController::class,'memberSecurity']);

  Route::get("/veriPass",[App\Http\Controllers\VerifyController::class,'veriPass'])->name("veriPass");

  Route::post("/verifySeconds",[App\Http\Controllers\VerifyController::class,'verifySeconds'])->name("verifySeconds");

  Route::get("/authIp",[App\Http\Controllers\VerifyController::class,'authIp'])->name("authIp");

  Route::post("/saveIP",[App\Http\Controllers\VerifyController::class,'saveIP'])->name("saveIP");

  Route::get("/findIdPw",[App\Http\Controllers\MemberController::class,'findIdPw'])->name("findIdPw");

  Route::post("/requestExchange",[App\Http\Controllers\MemberController::class,'requestExchange'])->name("request-exchange");

  Route::get("/prison",[App\Http\Controllers\MemberController::class,'prison'])->name("prison");

  Route::get("/accessProtected",[App\Http\Controllers\BlockController::class,'accessProtected'])->name("accessProtected");

  Route::get("/protectedip",[App\Http\Controllers\BlockController::class,'accessProtected'])->name("protectedip");

  Route::get("/user-view",[App\Http\Controllers\MemberController::class,'userView'])->name("userView");
  
  Route::get("/live",[App\Http\Controllers\MemberController::class,'live'])->name("live");
  
  Route::get("/checkplus_success",[App\Http\Controllers\MemberController::class,'checkplus_success'])->name("checkplus_success");
  
  Route::get("/checkplus_fail",[App\Http\Controllers\MemberController::class,'checkplus_fail'])->name("checkplus_fail");
  
  Route::get("/exchange_suc",[App\Http\Controllers\MemberController::class,'exchange_suc'])->name("exchange_suc");

});
