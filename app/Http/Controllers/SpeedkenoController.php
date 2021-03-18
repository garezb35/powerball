<?php

namespace App\Http\Controllers;

use App\Models\Pb_Result_Speedkeno;
use App\Models\PbBetting;
use App\Models\PbBettingCtl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class SpeedkenoController extends Controller
{

    /* 스피드키노 픽처리부분 */
    public function  pick(Request $request){
        if(!Auth::check())
        {
            echo "<script>alert('잘못된 접근입니다.')</script>";
            return;
        }
        $current_picks = array();
        $temp = array();
        $current_records = PbBetting::select(
            DB::raw("id"),
            DB::raw("userId"),
            DB::raw("round"),
            DB::raw("CONCAT('{',GROUP_CONCAT(CONCAT('\"',game_code,'\"',':','{','\"pick\":',pick,',','\"is_win\":',is_win,'}') SEPARATOR ','),'}') as content"),
            DB::raw("game_type"),
            DB::raw("type"),
            DB::raw("created_date"),
            DB::raw("updated_date"),
            DB::raw("created_date as pick_date")

        )
            ->where("userId",Auth::user()->userId)
            ->where("game_type",2)
            ->where("type",1)
            ->where("is_win",-1)
            ->orderBy("round","DESC")
            ->groupBy("round")
            ->groupBy("userId");

        $history_picks = PbBettingCtl::where("game_type",2)->where("type",1)->where("userId",Auth::user()->userId)->orderBy("round","DESC");
        return view('speedkeno_pick',[ "js"=>"",
                                            "css"=>"pball-pick.css",
                                            "pick_visible"=>"block",
                                            "s_remain"=>TimeController::getTimer(0),
                                            "type"=>2,
                                            "token"=>empty(Auth::user()->api_token) ? "" : Auth::user()->api_token,
                                            "picks" => $current_records->union($history_picks)->orderBy("round","DESC")->paginate(30)]);
    }

    public function view(Request $request){
        return view('speedkeno',["js"=>"speedkeno.js","css"=>"pball-pick.css","pick_visible"=>"block","token"=>empty(Auth::user()->api_token) ? "" : Auth::user()->api_token]);
    }

    /*  스피드키노 분석 데이터  선형 자료*/
    public function resultList(Request $request)
    {
        $skip = empty($request->skip) ? 0 : $request->skip;
        $speedkeno_list = new Pb_Result_Speedkeno;
        $speedkeno_list = $speedkeno_list->orderBy("day_round","DESC");
            if($skip >=288)
                $speedkeno_list = array();
            else
                $speedkeno_list = $speedkeno_list->offset($skip)->take(30)->get()->toArray();

        if(empty($speedkeno_list))
            echo json_encode(array("status"=>0,"result"=>array()));
        else {
            $speedkeno_list = json_decode(json_encode($speedkeno_list));
            echo json_encode(array("status" => 1, "result" => $speedkeno_list));
        }
    }

}
