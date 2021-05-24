<?php

namespace App\Http\Controllers;

use App\Models\PbAutoHistory;
use App\Models\PbAutoMatch;
use App\Models\PbAutoSetting;
use App\Models\PbBettingCtl;
use App\Models\PbRoom;
use App\Models\PowerballRange;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pb_Result_Powerball;
use App\Models\Pb_Result_Speedkeno;
use App\Models\PbBetting;
use Illuminate\Support\Facades\Auth;
use DB;
class BetController extends Controller
{
    /* 사용자 베팅요청부분 */
    public function processBet(Request $request){
        $socket_powerball = array();
        $user = Auth::user();
        $roomIdx = $request->roomIdx;
        $bet_history = array();
        /* 로그인 유저가 아니면 되돌린다 */
        if (!Auth::check()) {
            echo json_encode(array("status"=>0,"message"=>"로그인후 이용하실수 있습니다."));
            return;
        }
        /* 다른 테이블에 다시 갱신된 베팅자료들이 있으므로 이미 처리된 베팅자료들은 지워준다. */
        PbBetting::where("is_win",">",'-1')->where("userId",$user->userId)->delete();

        /* 게임 픽 이름 */
        $powerball_picks = array("pb_oe"=>"pb_oe","pb_uo"=>"pb_uo","nb_oe"=>"nb_oe","nb_uo"=>"nb_uo","nb_size"=>"nb_size");
        $speedkeno_picks = array("nb_oe"=>"speed_oe","nb_uo"=>"speed_uo");

        /* 방장픽인지 일반픽인지 검사 1이면 일반픽 2이면 방장픽 */
        $in_room = $request->in_room;
        $in_room = empty($in_room) ? 1 : 2;

        /* 유저아이디에 따르는 채팅방이 있는지 검사한다  존재하지 않으면 일반픽으로 고정한다*/
        if($in_room == 2 && !empty($request->roomIdx)){
            $checked_room = PbRoom::where("super",$user->userIdKey)->where("roomIdx",$roomIdx)->where("active",1)->first();
            if(empty($checked_room))
            {
                $in_room = 1;
                $roomIdx = "";
            }
        }

        /* Bulk INSERT자료 */
        $bulk_items = array();

        $game_type = $request->action;

        if (in_array($game_type, array("betting","speedkenoBetting")) == FALSE) {
            echo json_encode(array("status"=>0,"message"=>"게임이 지정되지 않았습니다."));
            return;
        }
        $remain = TimeController::getTimer($game_type == "betting" ? 2 : 0);
        if($remain[0] < 60){
            echo json_encode(array("status"=>0,"message"=>"마감 1분전까지만 참여 가능합니다."));
            return;
        }
        $next_round = $game_type == "betting" ? Pb_Result_Powerball::orderBy("day_round","DESC")->first():Pb_Result_Speedkeno::orderBy("day_round","DESC")->first();
        if(empty($next_round)){
            echo json_encode(array("status"=>0,"message"=>"회차 없음."));
            return;
        }

        if(!$this->checkTime($next_round["created_date"]))
        {
            echo json_encode(array("status"=>0,"message"=>"진행중 회차가 아닙니다."));
            return;
        }

        /* 진행중 회차를 얻는다. */
        $next_round = $next_round["day_round"] + 1;

        if($game_type == "betting"){
            $pb_oe = $request->powerballOddEven;
            $pb_uo=  $request->powerballUnderOver;
            $nb_oe=  $request->numberOddEven;
            $nb_uo=  $request->numberUnderOver;
            $nb_size = $request->numberPeriod;

            if( !in_array($pb_oe,array("0","1")) AND
                !in_array($pb_uo,array("0","1"))  AND
                !in_array($nb_oe,array("0","1"))  AND
                !in_array($nb_uo,array("0","1"))  AND
                !in_array($nb_size,array("1","2","3")))
            {
                echo json_encode(array("status"=>0,"message"=>"다섯개중 한개이상을 선태해주세요."));
                return;
            }

            $current_state = PbBetting::where("round",$next_round)->where("game_type",1)->where("userId",$user->userId)->first();
            if(!empty($current_state))
            {
                echo json_encode(array("status"=>0,"message"=>"한 회차당 한번만 참여할수 있습니다."));
                return;
            }

            foreach ($powerball_picks as $key => $index){
                $pick_content = $key;
                if(in_array($$pick_content,array("0","1","2","3")))
                {
                    array_push($bulk_items,array(    "round"=>$next_round,
                        "game_type"=>1,
                        "type"=>$in_room,
                        "game_code"=>$index,
                        "userId"=>$user->userId,
                        "roomIdx"=>$roomIdx,
                        "pick"=>$$pick_content,
                        "created_date"=>date("Y-m-d H:i:s"),
                        "updated_date"=>date("Y-m-d H:i:s")));
                    $socket_powerball[$index]["pick"] = $$pick_content;
                    $socket_powerball[$index]["is_win"] = -1;

                    if($key == "pb_oe"){
                        $bet_history["bet_number"] = $user->bet_number + 1;
                        $bet_history["bet_date"] = date("Y-m-d");
                    }
                    if($key == "pb_uo"){
                        $bet_history["bet_number1"] = $user->bet_number1 + 1;
                        $bet_history["bet_date1"] = date("Y-m-d");
                    }
                    if($key == "nb_oe"){
                        $bet_history["bet_number2"] = $user->bet_number2 + 1;
                        $bet_history["bet_date2"] = date("Y-m-d");
                    }
                    if($key == "nb_uo"){
                        $bet_history["bet_number3"] = $user->bet_number3 + 1;
                        $bet_history["bet_date3"] = date("Y-m-d");
                    }
                    if($key == "nb_size"){
                        $bet_history["bet_number4"] = $user->bet_number4 + 1;
                        $bet_history["bet_date4"] = date("Y-m-d");
                    }
                }
            }
        }


        if($game_type == "speedkenoBetting"){
            $nb_oe=  $request->numberSumOddEven;
            $nb_uo=  $request->underOver;
            if( !in_array($nb_oe,array("0","1"))  AND !in_array($nb_uo,array("0","1")))
            {
                echo json_encode(array("status"=>0,"message"=>"두개중 한개이상을 선태해주세요."));
                return;
            }
            $current_state = PbBetting::where("round",$next_round)->where("game_type",2)->where("userId",$user->userId)->first();
            if(!empty($current_state))
            {
                echo json_encode(array("status"=>0,"message"=>"한 회차당 한번만 참여할수 있습니다."));
                return;
            }
            foreach ($speedkeno_picks as $key => $index){
                $pick_content = $key;
                if(in_array($$pick_content,array("0","1")))
                    array_push($bulk_items,array(    "round"=>$next_round,
                        "game_type"=>2,
                        "type"=>$in_room,
                        "game_code"=>$index,
                        "userId"=>$user->userId,
                        "pick"=>$$pick_content,
                        "roomIdx"=>$roomIdx,
                        "created_date"=>date("Y-m-d H:i:s"),
                        "updated_date"=>date("Y-m-d H:i:s")));
            }
        }

        if(!empty($bulk_items))
        {
            PbBetting::insert($bulk_items);

            $bet_count = PbBettingCtl::where("userId",$user->userId)->count();
            if($bet_count % 20 == 19 ){
                $user = Auth::user();
                $user->bread = $user->bread+1;
                $user->save();
            }
            if(!empty($bet_history))
                User::where("userId",$user->userId)->update($bet_history);
            if($in_room == 1)
                echo json_encode(array("status"=>1,"room"=>$in_room ,"message"=>"픽이 완료되였습니다."));
            else
                echo json_encode(array("status"=>1,"room"=>$in_room,"message"=>"픽이 완료되였습니다.","picks"=>array("round"=>$next_round,"result"=>$socket_powerball,"roomIdx"=>$roomIdx,"date"=>date("m")."월 ".date("d")."일")));
            return;
        }
        else
        {
            echo json_encode(array("status"=>0,"message"=>"서버 오류."));
            return;
        }
    }

    public function processSimulatorBet(Request  $request){
        $pb_database = null;    // 년도에 따른 자료기지 얻을 변수
        $year  = date("Y");   // 년도수 담는 변수
        $compare = "";    //////////////
        $is_win= -1;      /////////////  승부
        $pb_oe= $pb_uo=$nb_oe=$nb_uo ="";  //////////////////결과변수
        $bet_type  = $request->bet_type;   //////////////////베팅 타입 지난회차 , 진행중회차
        $current = 0;                     /////////////////////////  현재 베팅하려는 회차
        $pbAutoSetting = new PbAutoSetting();
        $autoConfig = $pbAutoSetting
                        ->with([
                            'itemusers' => function ($query) {
                                $query->where("pb_item_use.terms1","<=",date("Y-m-d H:i:s"))
                                      ->where("pb_item_use.terms2",">=",date("Y-m-d H:i:s"))
                                      ->where("pb_item_use.market_id","PREMIUM_ANALYZER");
                            }
                        ])
                        ->where("betting_type",$bet_type)
                        ->where("state",1)
                        ->get()
                        ->toArray(); /// 유저들 게임 설정들 얻기

        if(empty($autoConfig)){    /////////////비였다면 모의베팅에 참가한 유저들 없음
            echo json_encode(array("status"=>0,"msg"=>"파워볼모의베팅설정이 비였습니다."));
            return;
        }

        foreach($autoConfig as $config){
            //  순환하면서 게임에 대한 베팅 진행
            if(empty($config["itemusers"]))
                continue;
            $first_round  = $config["start_round"]; // 시작 회차와 마감 회차를 얻는다.
            $end_round  = $config["end_round"];    // 시작 회차와 마감 회차를 얻는다.
            $money  = explode(",",$config["mny"]); // 단계별 금액을 얻는다.
            $user_amount =  $config["user_amount"];   // 보유금액을 얻는다.
            if(empty($money[0])){       //////     시작 금액 없으면 다음으로 넘어간다.
                continue;
            }
            if(empty($user_amount)){ /////////////       유저 보유금액 없으면 다음으로 넘긴다.
                continue;
            }

            if($bet_type ==1){         ///////////////    1이면 지난 회차
                if(empty($first_round) || empty($end_round)){  ///   시작라운드와 마감 라운드를 검사한다.
                    continue;
                }

                $current  = empty($config['current_round']) ? $first_round : $config['current_round'];

                if($current > $end_round){   //// 현재 회차가 마감회차보다 커지면 빠진다.
                    PbAutoSetting::where("userId",$config["userId"])->update(["state"=>0]);
                    continue;
                }
                PbAutoSetting::where("userId",$config["userId"])->update(["current_round"=>$current+1]);//// 현재 회차를 설정테이블에 보관한다.
                $database_year = PowerballRange::where("range1","<=",$current)->orderBy("year","DESC")->first(); // 회차에 따르는 년도수를 구하여 현재 년도인지 지난 년도에것인지 검사한다.
                if($database_year["year"] == date("Y")){
                    $pb_database = new Pb_Result_Powerball();
                }
                else{
                    $pb_database = DB::connect("powerball_community".$database_year["year"])->table("pb_result_powerball");
                    $year = $database_year["year"];
                }

                $current_result = json_decode(json_encode($pb_database->where("day_round",$current)->first()));
                if(empty($current_result))
                {
                    continue;
                }
                $pb_oe = $current_result->pb_oe;
                $pb_uo = $current_result->pb_uo;
                $nb_oe = $current_result->nb_oe;
                $nb_uo = $current_result->nb_uo;
                if($database_year["year"] == date("Y")){
                    $pb_database = new Pb_Result_Powerball();
                }
                else{
                    $pb_database = DB::connect("powerball_community".$database_year["year"])->table("pb_result_powerball");
                }
            }
            else{
                $pb_oe = $request->pb_oe;     /// 진행중 회차이면 GET방식으로 결과들이 날아온다.
                $pb_uo = $request->pb_uo;
                $nb_oe = $request->nb_oe;
                $nb_uo = $request->nb_uo;
                $current = $request->rownum;
                $pb_database = new Pb_Result_Powerball();
            }

            $match_type = $pb_database->select(
                DB::raw("GROUP_CONCAT(pb_result_powerball.pb_uo ORDER BY day_round ASC  SEPARATOR '') as `puo`"),
                DB::raw("GROUP_CONCAT(pb_result_powerball.pb_oe ORDER BY day_round ASC  SEPARATOR '') as `poe`"),
                DB::raw("GROUP_CONCAT(pb_result_powerball.nb_oe ORDER BY day_round ASC  SEPARATOR '') as `noe`"),
                DB::raw("GROUP_CONCAT(pb_result_powerball.nb_uo ORDER BY day_round ASC  SEPARATOR '') as `nuo`")
            )->where("day_round","<",$current)->get()->toArray();

            $match_type = json_decode(json_encode($match_type));

            if(empty($match_type[0]->poe))  // 결과가 없다면 다음 순환으로 넘긴다.
            {
                echo json_encode(array("status"=>0,"msg"=>"이전 회차 자료가 존재하지 않습니다."));
                continue;
            }

            if(strlen($match_type[0]->poe) < 50 && $year > 2013){    //  이전회차결과길이가 50보다 작고 현재 년도가 2013년보다 크다면 이전 년도의 자료기지로 넘어간다.
                $year = $year-1;
                $pb_database = $pb_database = DB::connect("powerball_community".$year)->table("pb_result_powerball");
                $match_type_previous = json_decode(json_encode( $pb_database->select(
                    DB::raw("GROUP_CONCAT(pb_result_powerball.pb_uo ORDER BY day_round ASC  SEPARATOR '') as `puo`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.pb_oe ORDER BY day_round ASC  SEPARATOR '') as `poe`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb_oe ORDER BY day_round ASC  SEPARATOR '') as `noe`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb_uo ORDER BY day_round ASC  SEPARATOR '') as `nuo`")
                )->get()->toArray()));
                $match_type_previous[0]->poe .= $match_type[0]->poe;  //이전과 현재 회차를 합치고
                $match_type_previous[0]->puo .= $match_type[0]->puo;
                $match_type_previous[0]->noe .= $match_type[0]->noe;
                $match_type_previous[0]->nuo .= $match_type[0]->nuo;

                $match_type[0]->poe = $match_type_previous[0]->poe;
                $match_type[0]->puo = $match_type_previous[0]->puo;
                $match_type[0]->noe = $match_type_previous[0]->noe;
                $match_type[0]->nuo = $match_type_previous[0]->nuo;
            }

            $match_type[0]->poe = substr($match_type[0]->poe,strlen($match_type[0]->poe)-50); // 최상위문자 길이의 50자를 뽑아낸다.
            $match_type[0]->puo = substr($match_type[0]->puo,strlen($match_type[0]->puo)-50);
            $match_type[0]->noe = substr($match_type[0]->noe,strlen($match_type[0]->noe)-50);
            $match_type[0]->nuo = substr($match_type[0]->nuo,strlen($match_type[0]->nuo)-50);

            $auto_games = json_decode(json_encode(PbAutoMatch::where("userid",$config["userId"])->where("state",1)->get()->toArray())); // 오토 게임들을 뽑아낸다.

            if(!empty($auto_games)){
                foreach ($auto_games as $game){
                    $is_win= -1;     // 승률 변수를 초기화한다.
                    if(empty($game->auto_pattern))  // 패턴이 비였으면 다음으로 넘어간다.
                    {
                        echo json_encode(array("status"=>0,"msg"=>"패턴이 없습니다."));
                        continue;
                    }
                    $step = $game->auto_step;   // 게임 단계를 얻는다.
                    $bet_money = empty($money[$step]) ? 0 : trim($money[$step]); // 단계에 따른 금액을 얻고
                    if(empty($bet_money) || $bet_money > $config["user_amount"]){   // 베팅금액이 비였거나 보유금액이 베팅금액보다 작다면 현재 게임을 종료한다.
                        PbAutoMatch::where("id",$game->id)->update(["state"=>0]);
                        continue;
                    }

                    $check = array(0,-1);  // 베팅검사변수를 초기화한다. 1번이 0이면 베팅조건 불만족, 1일때에만 만족 , 2번 첨수는 베팅하려는 값
                    if($game->auto_kind ==1)  // auto _kind 1이면 물레방아,2,3 이면 페턴배팅 1,2,
                        $check = array(1,-1);
                    else
                    {
                        $real_matches = "";
                        switch ($game->auto_type){
                            case "1":
                                $match_count = $this->sumPatt($game->auto_pattern);  // 패턴에 따르는 최대 픽 개수를 얻고
                                $real_matches = $match_type[0]->poe;  // 배팅 매칭변수에 해당 결과값들을 써넣기한다.
                                $compare = $pb_oe;  //  compare변수에 패턴종류에 따르는 결과값을 넣는다.
                                break;
                            case "2":
                                $match_count = $this->sumPatt($game->auto_pattern);
                                $real_matches = $match_type[0]->puo;
                                $compare = $pb_uo;
                                break;
                            case "3":
                                $match_count = $this->sumPatt($game->auto_pattern);
                                $real_matches= $match_type[0]->noe;
                                $compare = $nb_oe;
                                break;
                            case "4":
                                $match_count = $this->sumPatt($game->auto_pattern);
                                $real_matches = $match_type[0]->nuo;
                                $compare = $nb_uo;
                                break;
                            default:
                                break;

                        }

                        $check = $this->processAutoBackground($current,$game,$real_matches);  // 패턴방식이 조건에 만족하는지 그렇지 않은지 따져 보고 만족하면 체크변수에 해당 값들을 써넣기 한다.
                    }
                    $betting_pick = "-1";
                    if($game->auto_kind ==1){    // 물레방아면 순차적으로 그냥 베팅한다.
                        $process_count = $game->process_count;
                        $autoPatt = explode(",",$game->auto_pattern);
                        $remain = $process_count % sizeof($autoPatt);
                        if($compare !="-1" && $autoPatt[$remain] != $compare)
                            $is_win = 0;
                        if($compare !="-1" && $autoPatt[$remain] == $compare)
                            $is_win = 1;
                        $betting_pick = $autoPatt[$remain];
                        if($is_win !=-1)
                            PbAutoMatch::where("id",$game->id)->update(["process_count"=>$process_count+1]);
                    }
                    if(($game->auto_kind ==2 || $game->auto_kind ==3) && $check[0] ==1){

                        if($game->auto_oppo ==0)
                            $betting_pick = $check[1] == 1 ? 0 : 1;
                        else
                            $betting_pick = $check[1];
                        if($betting_pick == $compare)
                            $is_win =1;
                        else
                            $is_win = 0;
                    }
                    $remain_amount = 0;
                    if($is_win ==1){
                        $remain_amount  =  $config["user_amount"] + ($config["martin"]-1) * $bet_money;
                        $step = 0;
                    }
                    if($is_win ==0){
                        $remain_amount  =  $config["user_amount"] -$bet_money;
                        $step = $step + 1;
                        if($step >= $game->auto_last_step)
                            $step = 0;
                    }
                    if($remain_amount < 0)
                        continue;
                    if($is_win !=-1){
                        $pick = "";
                        $mul = $betting_pick == 1 ? -1 : 0;
                        $pick = $game->auto_type*2 +$mul;
                        $config["user_amount"] = $remain_amount;
                        PbAutoSetting::where("userId",$config["userId"])->update(["user_amount"=>$remain_amount]);
                        PbAutoMatch::where("id",$game->id)->update(["auto_step"=>$step,"auto_start"=>1,"money"=>$bet_money]);
                        PbAutoHistory::insert([
                            'userId'=>$config["userId"],
                            'day_round'=>$current,
                            'auto_kind'=>$game->auto_kind,
                            'auto_type'=>$game->auto_type,
                            "is_win"=>$is_win,
                            'bet_amount'=>$bet_money,
                            "pick"=>$pick
                        ]);
                    }
                    if($is_win == -1){
                        PbAutoMatch::where("id",$game->id)->update(["auto_start"=>0]);
                    }
                }
            }
        }
    }

    private function processAutoBackground($current,$matches,$match_type){
        if($matches->auto_kind == 2 ){
            $proced =  substr($match_type,strlen($match_type)-$this->sumPatt($matches->auto_pattern)-1);

            $first_pattern = $proced[0];
            $proced = substr($proced,1);
            if($matches->auto_pattern == $this->getPattFrom($proced) && $proced[0] != $first_pattern)
                return array(1,$first_pattern);
        }
        if($matches->auto_kind == 3 ){
            $patt_array = explode("/",$matches->auto_pattern);
            foreach ($patt_array as $pat){
                $proced =  substr($match_type,strlen($match_type)-$this->sumPatt($pat)-1);
                $first_pattern = $proced[0];
                $proced = substr($proced,1);
                if($pat == $this->getPattFrom($proced) && $proced[0] != $first_pattern)
                {
                    return array(1,$first_pattern);
                }
            }
        }
        return array(0,-1);
    }

    private function getPattFrom($picks){
        $temp = $picks[0];
        $count = 1;
        $result = "";
        for($i = 1 ;$i < strlen($picks) ; $i++){
            if($temp == $picks[$i]){
                $count++;
                if($i==strlen($picks)-1)
                    $result .=$count;
            }
            else{
                $result .=$count;
                $count=1;
                if($i == strlen($picks)-1)
                    $result .=$count;
            }
            $temp = $picks[$i];
        }
        return $result;
    }

    private function sumPatt($picks){
        $sum = 0;
        for($i = 0;$i<strlen($picks);$i++)
            $sum = $sum+intval($picks[$i]);
        return $sum;
    }

    private function checkTime($time){
        $strTotime  =  strtotime($time);
        $currentToTime = strtotime("now");
        return ($currentToTime - $strTotime) > 300 ? false : true;
    }
}
