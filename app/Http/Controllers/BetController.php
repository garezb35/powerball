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
                        ,"game","winlose"])
                        ->where("betting_type",$bet_type)
                        ->where("state",1)
                        ->get()
                        ->toArray(); /// 유저들 게임 설정들 얻기

        if(empty($autoConfig)){    /////////////비였다면 모의베팅에 참가한 유저들 없음
            echo json_encode(array("status"=>0,"msg"=>"파워볼모의베팅설정이 비였습니다.no empty setting"));
            return;
        }

        foreach($autoConfig as $config){
          $bet_all_mny = $config["bet_amount"];
          $history = array();
          $insert_config  = array();
          if(!empty($config["winlose"])){
            foreach($config["winlose"] as $cons){
              if($cons["times"] > 0 && $cons["rest"] > 0 ){
                if($cons["win_type"] == 1 && $config["w".$cons["game_type"]] >= $cons["times"])
                {
                  $insert_config["rest".$cons["game_type"]] = $cons["rest"];
                }
                if($cons["win_type"] == 2 && $config["w".$cons["game_type"]] <=(-1) * $cons["times"]){
                    $insert_config["rest".$cons["game_type"]] = $cons["rest"];
                }
              }
            }
          }
          PbAutoHistory::where("userId",$config["userId"])->delete();
            //  순환하면서 게임에 대한 베팅 진행
            $w= array();
            $w[1] = $config["w1"];
            $w[2] = $config["w2"];
            $w[3] = $config["w3"];
            $w[4] = $config["w4"];
            if(empty($config["itemusers"]))
                continue;
            if(empty($config["game"]))
              continue;
            $day_round = 0;
            $start_round = $config["start_round"];
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
                $database_year = PowerballRange::where("range1","<=",$current)->orderBy("year","DESC")->first(); // 회차에 따르는 년도수를 구하여 현재 년도인지 지난 년도에것인지 검사한다.

                if($database_year["year"] == date("Y")){
                    $pb_database = new Pb_Result_Powerball();
                }
                else{
                    $pb_database = DB::connection("powerball_community".$database_year["year"])->table("pb_result_powerball");
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
                $day_round = (int)$current_result->round;
                if($database_year["year"] == date("Y")){
                    $pb_database = new Pb_Result_Powerball();
                }
                else{
                    $pb_database = DB::connection("comm".$database_year["year"])->table("pb_result_powerball");
                }
            }
            else{
                $pb_oe = $request->pb_oe;     /// 진행중 회차이면 GET방식으로 결과들이 날아온다.
                $pb_uo = $request->pb_uo;
                $nb_oe = $request->nb_oe;
                $nb_uo = $request->nb_uo;
                $current = $request->rownum;
                $day_round = (int)$request->day_round;
                $pb_database = new Pb_Result_Powerball();
                if(empty($config['current_round'])){
                  $start_round = $current;
                  $insert_config["start_round"] = $current;
                }
            }



            $history["type"] = "current_result";
            $history["pb_oe"] = $pb_oe;
            $history["pb_uo"] = $pb_uo;
            $history["nb_oe"] = $nb_oe;
            $history["nb_uo"] = $nb_uo;
            $history["date"] = date("Y-m-d H:i:s");
            $history["rownum"] = $current;

            PbAutoHistory::insert(["userId"=>$config["userId"],"reason"=>json_encode($history)]);
            $history = array();

            $match_type = $pb_database->select(
                DB::raw("GROUP_CONCAT(pb_result_powerball.pb_uo ORDER BY day_round ASC  SEPARATOR '') as `puo`"),
                DB::raw("GROUP_CONCAT(pb_result_powerball.pb_oe ORDER BY day_round ASC  SEPARATOR '') as `poe`"),
                DB::raw("GROUP_CONCAT(pb_result_powerball.nb_oe ORDER BY day_round ASC  SEPARATOR '') as `noe`"),
                DB::raw("GROUP_CONCAT(pb_result_powerball.nb_uo ORDER BY day_round ASC  SEPARATOR '') as `nuo`")
            )->where("day_round","<=",$current)->where("day_round",'>=',$start_round)->get()->toArray();

            $match_type = json_decode(json_encode($match_type));


            if(empty($match_type[0]->poe))  // 결과가 없다면 다음 순환으로 넘긴다.
            {
                echo json_encode(array("status"=>0,"msg"=>"이전 회차 자료가 존재하지 않습니다.no previous rounds"));
                continue;
            }

            if(strlen($match_type[0]->poe) < 20 && $year > 2013 && $bet_type == 1){
                $pb_database = DB::connection("comm".$year)->table("pb_result_powerball");
                $match_type_previous = json_decode(json_encode( $pb_database->select(
                    DB::raw("GROUP_CONCAT(pb_result_powerball.pb_uo ORDER BY day_round ASC  SEPARATOR '') as `puo`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.pb_oe ORDER BY day_round ASC  SEPARATOR '') as `poe`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb_oe ORDER BY day_round ASC  SEPARATOR '') as `noe`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb_uo ORDER BY day_round ASC  SEPARATOR '') as `nuo`")
                )->where("day_round",'>=',$start_round)->get()->toArray()));
                $match_type_previous[0]->poe .= $match_type[0]->poe;
                $match_type_previous[0]->puo .= $match_type[0]->puo;
                $match_type_previous[0]->noe .= $match_type[0]->noe;
                $match_type_previous[0]->nuo .= $match_type[0]->nuo;

                $match_type[0]->poe = $match_type_previous[0]->poe;
                $match_type[0]->puo = $match_type_previous[0]->puo;
                $match_type[0]->noe = $match_type_previous[0]->noe;
                $match_type[0]->nuo = $match_type_previous[0]->nuo;
            }

            $match_type[0]->poe = str_replace("0","2",substr($match_type[0]->poe,strlen($match_type[0]->poe)-20)); // 최상위문자 길이의 50자를 뽑아낸다.
            $match_type[0]->puo = str_replace("0","2",substr($match_type[0]->puo,strlen($match_type[0]->puo)-20));
            $match_type[0]->noe = str_replace("0","2",substr($match_type[0]->noe,strlen($match_type[0]->noe)-20));
            $match_type[0]->nuo = str_replace("0","2",substr($match_type[0]->nuo,strlen($match_type[0]->nuo)-20));

            $games = $config["game"];
            $auto_games = json_decode(json_encode($games)); // 오토 게임들을 뽑아낸다.
            if(!empty($auto_games)){
              $remain_amount = $user_amount;
              $is_win= -1;
              foreach ($auto_games as $game){
                  if(!empty($config["rest".$game->game_kind])){
                    $insert_config["rest".$game->game_kind] = $config["rest".$game->game_kind]-1;
                    if($config["rest".$game->game_kind] == 1)
                      {
                        $w[$game->game_kind] = 0;
                      }
                    continue;
                  }
                     // 승률 변수를 초기화한다.
                  if(empty($game->auto_pattern))  // 패턴이 비였으면 다음으로 넘어간다.
                  {
                      echo json_encode(array("status"=>0,"msg"=>"패턴이 없습니다.no pattern"));
                      continue;
                  }
                  $split_pattern = array();
                  $step = $game->auto_step;   // 게임 단계를 얻는다.
                  $bet_money = 0;
                  $next_step = 0;
                  $next_cruiser = 0;
                  $past_pattern = "";
                  $past_cruiser = 0;
                  $past_step = 0;
                  $amount_step = 0;
                  $check = array(0,-1);  // 베팅검사변수를 초기화한다. 1번이 0이면 베팅조건 불만족, 1일때에만 만족 , 2번 첨수는 베팅하려는 값
                  $amounts = array();

                  switch ($game->game_kind){
                      case "1":
                          $compare = $pb_oe;  //  compare변수에 패턴종류에 따르는 결과값을 넣는다.
                          break;
                      case "2":
                          $compare = $pb_uo;
                          break;
                      case "3":
                          $compare = $nb_oe;
                          break;
                      case "4":
                          $compare = $nb_uo;
                          break;
                      default:
                          break;
                  }
                  if($game->auto_type ==1)  // auto _kind 1이면 물레방아,2,3 이면 페턴배팅 1,2,
                  {
                    if(empty(trim($game->money))) continue;
                    $check = array(1,-1);
                    $pattern = trim(str_replace("<br>","",strip_tags($game->auto_pattern)));
                    $moneys = strip_tags($game->money,"<div>");
                    $first_val = strip_tags_content($moneys);
                    if(!empty($first_val))
                    {
                      array_push($amounts,$first_val);
                    }
                    preg_match_all('#<div>(.+?)</div>#', $moneys, $parts );
                    if(!empty($parts[1]))
                      $amounts = array_merge($amounts,$parts[1]);
                    if(sizeof($amounts) == 0 || empty($pattern)) continue;
                  }
                  else
                  {
                      $pattern = array();
                      $pat = strip_tags($game->auto_pattern,"<div>");
                      $first_val = strip_tags_content($pat);
                      if(!empty($first_val))
                      {
                        array_push($pattern,$first_val);
                      }
                      preg_match_all('#<div>(.+?)</div>#', $pat, $parts );
                      if(!empty($parts[1]))
                        $pattern = array_merge($pattern,$parts[1]);
                      $real_matches = "";

                      switch ($game->game_kind){
                          case "1":
                              $match_count = $this->sumPatt($game->auto_pattern);  // 패턴에 따르는 최대 픽 개수를 얻고
                              $real_matches = $match_type[0]->poe;  // 배팅 매칭변수에 해당 결과값들을 써넣기한다.
                              break;
                          case "2":
                              $match_count = $this->sumPatt($game->auto_pattern);
                              $real_matches = $match_type[0]->puo;
                              break;
                          case "3":
                              $match_count = $this->sumPatt($game->auto_pattern);
                              $real_matches= $match_type[0]->noe;
                              break;
                          case "4":
                              $match_count = $this->sumPatt($game->auto_pattern);
                              $real_matches = $match_type[0]->nuo;
                              break;
                          default:
                              break;
                      }

                      $check = $this->processAutoBackground($game,$pattern,$real_matches);  // 패턴방식이 조건에 만족하는지 그렇지 않은지 따져 보고 만족하면 체크변수에 해당 값들을 써넣기 한다.
                  }
                  $betting_pick = "-1";
                  if($game->auto_type ==1){    // 물레방아면 순차적으로 그냥 베팅한다.
                      $amount_step = $game->amount_step;
                      if(empty($amounts[$amount_step]) || !is_numeric($amounts[$amount_step])) continue;
                      $bet_money = $amounts[$amount_step];
                      $step = $game->auto_step;
                      $split_pattern = str_split(str_replace("2","0",$pattern));
                      if($game->auto_cate == 1){
                          if(empty($day_round)) continue;
                          $step = $day_round % sizeof($split_pattern);
                      }
                      if(!isset($split_pattern[$step])){
                        $step = 0;
                        return;
                      }
                      $betting_pick = $split_pattern[$step];
                      if($compare !="-1" && $betting_pick != $compare)
                      {
                          $is_win = 0;
                          $amount_step += 1;
                      }
                      if($compare !="-1" && $betting_pick == $compare)
                      {
                        $is_win = 1;
                        if($game->auto_cate == 2 || $game->auto_cate == 1){
                            $amount_step = 0;
                        }
                        if($game->auto_cate == 3){
                            $amount_step +=1;
                        }
                      }
                      if($amount_step >=sizeof($amounts)) $amount_step = 0;
                      $betting_pick = $split_pattern[$step];
                      if($game->auto_cate != 1){
                        $step = $step + 1;
                        if($step >= sizeof($split_pattern))
                          $step = 0;
                      }
                      else{
                        if($day_round == 288){
                          $step = 1;
                        }
                        else $step = ($day_round + 1) % sizeof($split_pattern);
                      }
                      $next_step = $step;
                  }
                  else if($check["status"] == "pick"){

                      $betting_pick = $check["pick"] == 1 ? 1 : 0;
                      if($betting_pick == $compare)
                      {
                          $is_win = 1;
                          $next_step = $check["next_win"]["step"];
                          $next_cruiser = $check["next_win"]["curiser_step"];
                      }
                      else
                      {
                        $is_win = 0;
                        $next_step = $check["next_lose"]["step"];
                        $next_cruiser = $check["next_lose"]["curiser_step"];
                      }
                      $past_pattern = $check["current"]["pattern"];
                      $past_cruiser = $check["current"]["current_cruiser"];
                      $past_step = $check["current"]["current_step"];
                      $bet_money = $check["bet_money"];
                  }

                  if(!is_numeric($bet_money) || empty($bet_money)) continue;
                  $bet_all_mny += $bet_money;
                  if($is_win ==1){
                      $remain_amount  += ($config["martin"]-1) * $bet_money;
                      if($w[$game->game_kind] <= 0) $w[$game->game_kind] = 1;
                      else  $w[$game->game_kind]++;
                  }
                  if($is_win ==0){
                      $remain_amount  -= $bet_money;
                      if($w[$game->game_kind] >= 0) $w[$game->game_kind] = -1;
                      else  $w[$game->game_kind]--;
                  }
                  if($remain_amount < 0)
                      continue;
                  if($is_win !=-1){

                      $pick = "";
                      $mul = $betting_pick == 1 ? -1 : 0;
                      $pick = $game->auto_type*2 +$mul;
                      $config["user_amount"] = $remain_amount;
                      PbAutoMatch::where("id",$game->id)->update(["auto_step"=>$next_step,"auto_train"=>$next_cruiser,"auto_start"=>1,"past_cruiser"=>$past_cruiser,"past_step"=>$past_step,"past_pattern"=>$past_pattern,"amount_step"=>$amount_step]);
                      if($betting_pick !=-1 && $bet_money . 0){
                        $history = array();
                        $history["type"] = "betting";
                        $history["win_type"] = $is_win;
                        if($is_win == 1)
                          $history["amount"] = number_format($bet_money)."=>".number_format(1.95 * $bet_money);
                        else {
                          $history["amount"] = number_format($bet_money);
                        }
                        $history["auto_kind"] = $game->game_kind;
                        $history["auto_type"] = $game->auto_type;
                        $history["pick"] = $betting_pick;
                        PbAutoHistory::insert(["userId"=>$config["userId"],"reason"=>json_encode($history)]);
                      }
                  }
                  if($is_win == -1){
                      PbAutoMatch::where("id",$game->id)->update(["auto_start"=>0]);
                  }
              }
              if($current >= $end_round){   //// 현재 회차가 마감회차보다 커지면 빠진다.
                  $insert_config["state"] = 0;
              }
              if(($remain_amount >= $config["win_limit"] || $remain_amount <= $config["win_limit"] * (-1)) && $config["win_limit"]  != 0 && $config["win_limit"] != ""){
                $insert_config["state"] = 0;
              }
              $insert_config["current_round"] = $current+1;
              $insert_config["user_amount"] = $remain_amount;
              $insert_config["w1"] = $w[1];
              $insert_config["w2"] = $w[2];
              $insert_config["w3"] = $w[3];
              $insert_config["w4"] = $w[4];
              $insert_config["bet_amount"] = $bet_all_mny;
              PbAutoSetting::where("userId",$config["userId"])->update($insert_config);
            }
        }
    }

    private function processAutoBackground($game,$matches,$match_type){

            $m = 0;
            $next_step = 0;
            $next_cruiser = 0;
            $curiser_length = 0;
            $lose_step = 0;
            $next_step = $game->auto_step;
            $current_step = 0;
            $current_curiser = 0;
            if(!empty($matches) && !empty($matches[$next_step])){
              $dan_split = explode("단-",$matches[$next_step]);
              if(sizeof($dan_split) == 1) return array("status"=>"nopick");;
              $cruiser_split = explode("/",$dan_split[1]);
              $curiser_length = sizeof($cruiser_split);
              if($curiser_length > $game->auto_train){
                 // 현재 단계
                $next_cruiser = $game->auto_train + 1; // 이긴 경우에는 크루즈 단계 다음 단계
                $lose_step = $next_step + 1; //진 경우에는 무조건 다음 단계로
                if($lose_step >= sizeof($matches))
                  $lose_step = 0;
                if($next_cruiser >= $curiser_length)
                {
                  $next_step = 0;
                  $next_cruiser = 0;
                }
                $pattern_cruiser = $cruiser_split[$game->auto_train];
                $parts_m = explode(":",$pattern_cruiser);
                if(sizeof($parts_m) < 2 || !is_numeric($parts_m[0]))
                  return array("status"=>"nopick");
                $m = $parts_m[0];
                unset($parts_m[0]);
                usort($parts_m,'sort_custrom');
                foreach($parts_m as $key=>$v){
                  $spi_dash  = explode("-",$v);
                  if(sizeof($spi_dash) < 2 || !is_numeric($spi_dash[0]) || !is_numeric($spi_dash[1]))
                    return  array("status"=>"nopick");
                    $proced =  substr($match_type,strlen($match_type)-strlen($spi_dash[0]));
                    if($proced == $spi_dash[0])
                      return array( "status"=>"pick",
                                    "cruiser_check"=>$curiser_length,
                                    "pick"=>$spi_dash[1],
                                    "next_win"=>array("step"=>$next_step,"curiser_step"=>$next_cruiser),
                                    "bet_money"=>$m,
                                    "bet_info"=>$spi_dash[0],
                                    "current"=>array("current_step"=>$game->auto_step,"current_cruiser"=>$game->auto_train,"pattern"=>$v),
                                    "next_lose"=>array("step"=>$lose_step,"curiser_step"=>0));

                }
              }
            }
        return array("status"=>"nopick");
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
