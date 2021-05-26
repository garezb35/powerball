<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::middleware('auth:api')->group(function(){
    Route::post("/processBet",[App\Http\Controllers\BetController::class,'processBet'])->name("processBet");
//    Route::post("/pattern-lists",[App\Http\Controllers\PowerballController::class,'patternLists']);
    Route::post("/setAutoConfig",[App\Http\Controllers\PowerballController::class,'setAutoConfig']);
    Route::post("/setAutoMatch",[App\Http\Controllers\PowerballController::class,'setAutoMatch']);
    Route::post("/setAutoStart",[App\Http\Controllers\PowerballController::class,'setAutoStart']);
    Route::post("/buyItem",[App\Http\Controllers\MarketController::class,'buyItem']);
    Route::post("/useItem",[App\Http\Controllers\MarketController::class,'useItem']);
    Route::post("/checkNickName",[App\Http\Controllers\MemberController::class,'checkNickName']);
    Route::post("/sendMail",[App\Http\Controllers\MemberController::class,'sendMail']);
    Route::post("/checkActiveRoom",[App\Http\Controllers\ChatController::class,'checkActiveRoom']);
    Route::post("/verifyPass",[App\Http\Controllers\ChatController::class,'verifyPass']);
    Route::post("/checkOtherRoom",[App\Http\Controllers\ChatController::class,'checkOtherRoom']);
    Route::post("/createRoom",[App\Http\Controllers\ChatController::class,'createRoom'])->name("createRoom");
    Route::post("/getChatPicks",[App\Http\Controllers\PowerballController::class,'getChatPicks'])->name("getChatPicks");
    Route::post("/recommendChatRoom",[App\Http\Controllers\ChatController::class,'reChatRoom']);
    Route::post("/setFavorite",[App\Http\Controllers\ChatController::class,'setFavorite']);
    Route::post("/setFroze",[App\Http\Controllers\ChatController::class,'setFroze']);
    Route::post("/modifyRoom",[App\Http\Controllers\ChatController::class,'modifyRoom']);
    Route::post("/deleteChatRoom",[App\Http\Controllers\ChatController::class,'deleteChatRoom']);
    Route::post("/getBullet",[App\Http\Controllers\ChatController::class,'getBullet']);
    Route::post("/giveBullet",[App\Http\Controllers\ChatController::class,'giveBullet']);
    Route::post("/setMute",[App\Http\Controllers\MemberController::class,'setMute']);
    Route::post("/kickUser",[App\Http\Controllers\MemberController::class,'kickUser']);
    Route::post("/updateManage",[App\Http\Controllers\MemberController::class,'updateManage']);
    Route::post("/updateFixManage",[App\Http\Controllers\MemberController::class,'updateFixManage']);
    Route::post("/user-modify",[App\Http\Controllers\MemberController::class,'umodify']);
    Route::post("/imgCheck",[App\Http\Controllers\MemberController::class,'imgCheck']);
    Route::post("/deleteComment",[App\Http\Controllers\BoardController::class,'deleteComment']);
    Route::post("/setRecommend",[App\Http\Controllers\BoardController::class,'setRecommend']);
    Route::post("/deletePost",[App\Http\Controllers\BoardController::class,'deletePost']);
    Route::post("/addFriend",[App\Http\Controllers\MemberController::class,'addFriend']);
    Route::post("/sendGift",[App\Http\Controllers\MemberController::class,'sendGift']);
    Route::post("/sendItem",[App\Http\Controllers\MemberController::class,'sendItem']);
    Route::post("/setPresent",[App\Http\Controllers\MemberController::class,'setPresent']);
});

Route::post("/get_more/powerball",[App\Http\Controllers\PowerballController::class,'resultList']);
Route::post("/get_more/speedkeno",[App\Http\Controllers\SpeedkenoController::class,'resultList']);
Route::post("/get_more/analyseDate",[App\Http\Controllers\PowerballController::class,'analyseDate']);
Route::post("/get_more/analysePattern",[App\Http\Controllers\PowerballController::class,'patternAnalyse']);
Route::post("/get_more/analyseSix",[App\Http\Controllers\PowerballController::class,'getSixAnalyse']);
Route::post("/get_more/analyseMinMax",[App\Http\Controllers\PowerballController::class,'analyseMinMax']);
Route::post("/get_more/analyseMinMaxByDate",[App\Http\Controllers\PowerballController::class,'anaylseMinMaxByDate']);
Route::get ("/synctime",[App\Http\Controllers\HomeController::class,'syncTImeWith']);
Route::post("/pattern-lists",[App\Http\Controllers\PowerballController::class,'patternLists']);
Route::post("/checkedPattern",[App\Http\Controllers\PowerballController::class,'checkedPattern']);
Route::get("/processSimulatorBet",[App\Http\Controllers\BetController::class,'processSimulatorBet']);
Route::post("/getRoundBox",[App\Http\Controllers\PowerballController::class,'getRoundBox']);
Route::get("/patternTotal",[App\Http\Controllers\PowerballController::class,'patternTotal']);
Route::get("/calculateWinning",[App\Http\Controllers\PowerballController::class,'calculateWinning']);
Route::post("/bettingResultLayer",[App\Http\Controllers\MemberController::class,'bettingResultLayer']);


Route::prefix('psadari')->group(function () {
    Route::post("/get_more/powerball",[App\Http\Controllers\PowerSadariController::class,'resultList']);
    Route::post("/get_more/analysePattern",[App\Http\Controllers\PowerSadariController::class,'patternAnalyse']);
    Route::post("/get_more/analyseDate",[App\Http\Controllers\PowerSadariController::class,'analyseDate']);
    Route::post("/get_more/analyseMinMax",[App\Http\Controllers\PowerSadariController::class,'analyseMinMax']);
    Route::post("/get_more/analyseMinMaxByDate",[App\Http\Controllers\PowerSadariController::class,'anaylseMinMaxByDate']);
    Route::post("/get_more/analyseSix",[App\Http\Controllers\PowerSadariController::class,'getSixAnalyse']);
    Route::post("/getRoundBox",[App\Http\Controllers\PowerSadariController::class,'getRoundBox']);
    Route::post("/checkedPattern",[App\Http\Controllers\PowerSadariController::class,'checkedPattern']);
    Route::post("/pattern-lists",[App\Http\Controllers\PowerSadariController::class,'patternLists']);
});


Route::get("/virtualBet",[App\Http\Controllers\PowerballController::class,'virtualBet']);

Route::post("/getChatRooms",[App\Http\Controllers\ChatController::class,'getChatRooms']);


Route::post("/live/result",[App\Http\Controllers\PowerballController::class,'liveResult']);

Route::post("/getWinners",[App\Http\Controllers\MemberController::class,'getWinners']);
Route::get("/rankingWinner",[App\Http\Controllers\MemberController::class,'rankingWinner']);
Route::get("/winnerGift",[App\Http\Controllers\MemberController::class,'winnerGift']);
Route::get("/set_round/{name}",[App\Http\Controllers\PowerballController::class,'setRound']);

