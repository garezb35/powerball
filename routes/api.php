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


