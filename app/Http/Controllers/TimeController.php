<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pb_Result_Powerball;
use App\Models\Pb_Result_Speedkeno;

class TimeController extends Controller
{

    public static function getTimer(int $type)
    {
        $round = 0;
        $day_round = 0;
        switch ($type){
            case 2:
                $pb_result = new Pb_Result_Powerball;
                $pb_result = $pb_result->orderBy("day_round","DESC")->first();
                if(!empty($pb_result)){
                  $round = $pb_result["day_round"] + 1;
                  $day_round = $pb_result["round"]  == 288 ? 1 : $pb_result["round"] + 1;
                }

                break;
            case 0:
                $sp_result = new Pb_Result_Speedkeno;
                $sp_result=$sp_result->orderBy("day_round","DESC")->first();
                $round = !empty($sp_result) ?  $sp_result["day_round"] + 1 : 0;
                break;
        }
        $minute = (int)date("i");
        $second = (int)date("s");
        $g_nMinute = 4 - ($minute + $type) % 5;
        $g_nSecond = 55 - $second;
        --$g_nSecond;
        if ($g_nSecond < 0)
        {
            --$g_nMinute;
            if ($g_nMinute < 0)
                $g_nMinute = 4;
            $g_nSecond = 60 + $g_nSecond;
        }
        return array($g_nMinute*60 + $g_nSecond,$round,$day_round);
    }
    public static function getTimerInPast(){
        $second = (int)date("s");
        return array(20-$second % 20,0);
    }
}
