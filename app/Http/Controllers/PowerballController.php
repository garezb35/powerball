<?php

namespace App\Http\Controllers;
use App\Models\PbAutoHistory;
use App\Models\PbAutoMatch;
use App\Models\PbBetting;
use App\Models\PbItemUse;
use App\Models\PbMarket;
use App\Models\PbRoom;
use App\Models\TblWinning;
use App\Models\User;
use App\Models\PbRange;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use App\Models\Pb_Result_Powerball;
use App\Models\PbAutoSetting;
use App\Models\PbBettingCtl;
use App\Models\PbWinLose;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use DB;
use DateTime;
use Prophecy\Doubler\Generator\Node\ReturnTypeNode;
use Ramsey\Uuid\Type\Time;

class PowerballController extends SecondController
{

    public function  __construct()
    {
        parent::__construct();
    }

    public function view(Request $request)
    {
        if (!$request->has("terms"))
            $key = "date";
        else
            $key = $request->terms;

        switch ($key) {
            case "date":
                $from = !empty($request->from) ? $request->from : date("Y-m-d");
                return view('powerball_date', [    "js" =>
                                                        "powerball_date.js",
                                                        "css" => "powerball_date.css",
                                                        "pick_visible" => "none",
                                                        "p_remain"=>TimeController::getTimer(2),
                                                        "from"=>$from,
                                                        "type"=>1,
                                                        "title"=>date("Y",strtotime($from))."년 ".date("m",strtotime($from))."월 ".date("d",strtotime($from))."일 기준 오늘 통계데이터",
                                                        "token"=>""
                                                    ]
                            );
                break;
            case "lates":
                $token = empty($this->user) ? "" : $this->user->api_token;
                if($request->pageType == "late")
                    $default = 50;
                else
                    $default =288;
                $limit = !empty($request->limit) ? $request->limit : $default;

                $next = $limit + 50;
                if($next > 2000)
                    $next = 50;
                $prev = $limit-50;
                if($prev < 50)
                    $prev = 2000;
                return view('powerball_lates', [   "js" => "powerball_lates.js",
                                                        "css" => "powerball_date.css",
                                                        "pick_visible" => "block",
                                                        "p_remain"=>TimeController::getTimer(2),
                                                        "from"=>"",
                                                        "next"=>$next,
                                                        "prev"=>$prev,
                                                        "token"=>$token,
                                                        "title"=>"최근 {$limit}회차 기준 오늘 통계데이터",
                                                        "limit"=>$limit]
                            );
                break;
            case "period":
                if(!empty($request->dateType)){
                    $request->dateType = $request->dateType-1;
                    $to = date("Y-m-d");
                    $from = date('Y-m-d', strtotime('-'.$request->dateType.' days', strtotime($to)));
                }
                else{
                    $to = !empty($request->to) ? $request->to : date("Y-m-d");
                    $from = !empty($request->from) ? $request->from : date('Y-m-d', strtotime('-29 days', strtotime($to)));
                }
                $date1 =  new \DateTime($from);
                $date2 =  new \DateTime($to);
                $interval = $date1->diff($date2);
                $dif = $interval->days;
                $dif++;
                return view('powerball_period', [  "js" => "powerball_period.js",
                                                        "css" => "powerball_date.css",
                                                        "pick_visible" => "none",
                                                        "from"=>$from,
                                                        "to"=>$to,
                                                        "p_remain"=>TimeController::getTimer(2),
                                                        "diff"=>$dif,
                                                        "title"=>date("Y",strtotime($from))."년 ".date("m",strtotime($from))."월 ".date("d",strtotime($from))."일부터 ".
                                                            date("Y",strtotime($to))."년 ".date("m",strtotime($to))."월 ".date("d",strtotime($to))."일까지의 통계데이터"
                                                     ]
                            );
                break;
            case "pattern":
                $model = Pb_Result_Powerball::orderBy("day_round","DESC")->first();
                $last_round = !empty($model["day_round"]) ? $model["day_round"] : 0;
                return view('powerball_pattern', [     "js" => "powerball_pattern.js",
                                                            "css" => "powerball_date.css",
                                                            "pick_visible" => "none",

                                                            "next_round"=>$last_round+1]);
                break;
            case "round":
                if(!empty($request->dateType)){
                    $to = date("Y-m-d");
                    $from = date('Y-m-d', strtotime('-'.$request->dateType.' days', strtotime($to)));
                }
                else{
                    $to = !empty($request->to) ? $request->to : date("Y-m-d");
                    $from = !empty($request->from) ? $request->from : date('Y-m-d', strtotime('-29 days', strtotime($to)));
                }
                $current = 0;
                if($request->current == 1 || empty($request->toRound)){
                    $powerball = Pb_Result_Powerball::orderBy("day_round","DESC")->first();
                    if(empty($powerball)){
                        echo "<script>alert('지난 내역이 없습니다.');window.parent.document.getElementById('mainFrame').height = '500px';</script>";
                        return;
                    }
                    $current=$powerball["round"]+1;
                }

                if(!empty($request->toRound))
                    $current = $request->toRound;
                $next = $current + 1;
                if($next > 288)
                    $next = 1;
                $prev = $current-1;
                if($prev < 1)
                    $prev = 288;
                return view('powerball_round', [     "js" => "powerball_round.js",
                    "css" => "powerball_date.css",
                    "p_remain"=>TimeController::getTimer(2),
                    "current_round"=>$current,
                    "from"=>$from,
                    "to"=>$to,
                    "next"=>$next,
                    "prev"=>$prev,
                    "title"=>date("Y",strtotime($from))."년 ".date("m",strtotime($from))."월 ".date("d",strtotime($from))."일부터 ".
                        date("Y",strtotime($to))."년 ".date("m",strtotime($to))."월 ".date("d",strtotime($to))."일 ".$current."회차 통계데이터",
                    "pick_visible" => "none"]);
                break;
            case "roundbox":
                $from_round =$request->fromRound;
                $to_round = $request->toRound;
                $mode = empty($request->mode) ? "pb_oe":$request->mode;
                if(!empty($request->dateType)){
                    $request->dateType = $request->dateType-1;
                    $to = date("Y-m-d");
                    $from = date('Y-m-d', strtotime('-'.$request->dateType.' days', strtotime($to)));
                }
                else{
                    $to = !empty($request->to) ? $request->to : date("Y-m-d");
                    $from = !empty($request->from) ? $request->from : date('Y-m-d', strtotime('-14 days', strtotime($to)));
                }
                if($request->current == 1 || empty($request->toRound)){
                    $powerball = Pb_Result_Powerball::orderBy("day_round","DESC")->first();
                    if(empty($powerball)){
                        echo "<script>alert('지난 내역이 없습니다.');window.parent.document.getElementById('mainFrame').height = '500px';</script>";
                        return;
                    }
                    $to_round=$powerball["round"]+1;
                }
                if(empty($request->fromRound))
                    $from_round = $to_round-10;
                if($from_round < 0) $from_round =$from_round+288;
                if($from_round > $to_round)
                {
                    $temp = $to_round;
                    $to_round = $from_round;
                    $from_round = $temp;
                }
                return view('powerball_roundbox', [     "js" => "powerball_roundbox.js",
                    "css" => "powerball_date.css",
                    "p_remain"=>TimeController::getTimer(2),
                    "from_round"=>$from_round,
                    "to_round"=>$to_round,
                    "from"=>$from,
                    "to"=>$to,
                    "mode"=>$mode,
                    "title"=>date("Y",strtotime($from))."년 ".date("m",strtotime($from))."월 ".date("d",strtotime($from))."일 ~ ".
                        date("Y",strtotime($to))."년 ".date("m",strtotime($to))."월 ".date("d",strtotime($to))."일  , ".$from_round."회차 ~ ".$to_round."회차 통계데이터",
                    "pick_visible" => "none"]);
                break;
            default:
                return "";
                break;
        }
    }

    /* 파워볼 픽 페이지 */
    public function pick(Request $request)
    {

        if(!$this->isLogged)
        {
            echo "<script>alert('로그인 후 이용가능합니다.');window.history.go(-1);</script>";
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
            DB::raw("roomIdx"),
            DB::raw("status"),
            DB::raw("created_date"),
            DB::raw("updated_date"),
            DB::raw("created_date as pick_date")

        )
            ->where("userId",$this->user->userId)
            ->where("game_type",1)
            ->where("type",1)
            ->where("is_win",-1)
            ->orderBy("round","DESC")
            ->groupBy("round")
            ->groupBy("userId");
        $history_picks = PbBettingCtl::where("game_type",1)->where("type",1)->where("userId",$this->user->userId)->orderBy("round","DESC");

        return view('powerball_pick', [    "js" => "",
                                                "css" => "pball-pick.css",
                                                "pick_visible" => "block",
                                                "p_remain"=>TimeController::getTimer(2),
                                                "type"=>1,
                                                "token"=>$this->user->api_token,
                                                "picks" => $current_records->union($history_picks)->orderBy("round","DESC")->paginate(20)
                                               ]);

    }

    /*  파워볼 분석 데이터  선형 자료*/
    public function resultList(Request $request)
    {
        $skip = empty($request->skip) ? 0 : $request->skip;
        $from = empty($request->from) ? "" : $request->from;
        $to = empty($request->to) ? "" : $request->to;
        $limit = empty($request->limit) ? 30 : $request->limit;
        $from_year  = date("Y",strtotime($from));
        $round = empty($request->round) ? 0 : $request->round;
        if($from !="" && $to !=""){
            if($from_year == date('Y'))
                $powerball_list = new Pb_Result_Powerball;
            else
                $powerball_list = DB::connection("comm" . $from_year)->table("pb_result_powerball");
            if($round > 0)
                $powerball_list = $powerball_list->where("round",$round);
            $powerball_list = $powerball_list->orderBy("day_round", "DESC");
            if(!empty($from) && !empty($to)){
                $powerball_list = $powerball_list->where("created_date", ">=", $from . " 00:00:00");
                $powerball_list = $powerball_list->where("created_date", "<=", $to . " 23:59:59");
                $powerball_list = $powerball_list->offset($skip)->take(30)->get()->toArray();

            }
        }
        elseif ($limit !="")
        {
            $powerball_list = new Pb_Result_Powerball;
            if($skip >=$limit)
                $powerball_list = array();
            else
                $powerball_list = $powerball_list->offset($skip)->take(30)->orderBy("day_round", "DESC")->get()->toArray();
        }

        if(empty($powerball_list))
            echo json_encode(array("status"=>0,"result"=>array()));
        else {
            $powerball_list = json_decode(json_encode($powerball_list));
            echo json_encode(array("status" => 1, "result" => $powerball_list));
        }
    }

    /*  파워볼 전체 분석 데이터  */
    public function analyseDate(Request $request)
    {
        $total = array();
        $poe = $puo = $nuo = $noe = $nsize = "";
        $from_year = $to_year = 0;
        $from = empty($request->from) ? "" : $request->from;
        $to = empty($request->to) ? "" : $request->to;
        $limit = empty($request->limit) ? "" : $request->limit;
        $round = empty($request->round) ? 0 : $request->round;
        if ($from != "" && $to != "")
        {
            $from_year  = date("Y",strtotime($from));
            $to_year  = date("Y",strtotime($to));
            for($i = $to_year ; $i >=$from_year;$i--) {
                if ($i > date("Y")  || $i < "2013")
                    continue;
                if ($i == date("Y"))
                    $powerball_list_to = new Pb_Result_Powerball;
                if ($i < date("Y"))
                    $powerball_list_to = DB::connection("comm" . $i)->table("pb_result_powerball");

                $powerball_list_to = $powerball_list_to->orderBy("day_round", "DESC");
                if ($i == $to_year || $i == $from_year) {
                    $powerball_list_to = $powerball_list_to->where("created_date", ">=", $from . " 00:00:00");
                    $powerball_list_to = $powerball_list_to->where("created_date", "<=", $to . " 23:59:59");
                }
                if(!empty($round))
                    $powerball_list_to = $powerball_list_to->where("round", $round);
                $powerball_list_to = $powerball_list_to->select(
                    DB::raw("GROUP_CONCAT(pb_result_powerball.pb_uo ORDER BY day_round DESC  SEPARATOR ',') as `puo`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.pb_oe ORDER BY day_round DESC  SEPARATOR ',') as `poe`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb_oe ORDER BY day_round DESC  SEPARATOR ',') as `noe`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb_uo ORDER BY day_round DESC  SEPARATOR ',') as `nuo`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb_size ORDER BY day_round DESC  SEPARATOR ',') as `nsize`"));
                $powerball_list_to = $powerball_list_to->groupBy("group")->get()->toArray();

                if (!empty($powerball_list_to[0])) {
                    if(!empty($poe))
                        $poe .=",";
                    if(!empty($puo))
                        $puo .=",";
                    if(!empty($noe))
                        $noe .=",";
                    if(!empty($nuo))
                        $nuo .=",";
                    if(!empty($nsize))
                        $nsize .=",";
                    $poe .= $i != date('Y') ? $powerball_list_to[0]->poe : $powerball_list_to[0]["poe"];
                    $puo .= $i != date('Y') ? $powerball_list_to[0]->puo : $powerball_list_to[0]["puo"];
                    $nuo .= $i != date('Y') ? $powerball_list_to[0]->nuo : $powerball_list_to[0]["nuo"];
                    $noe .= $i != date('Y') ? $powerball_list_to[0]->noe : $powerball_list_to[0]["noe"];
                    $nsize .= $i != date('Y') ? $powerball_list_to[0]->nsize : $powerball_list_to[0]["nsize"];
                }
            }
            $total = array( "poe"=>$poe,
                                    "puo"=>$puo,
                                    "noe"=>$noe,
                                    "nuo"=>$nuo,
                                    "nsize"=>$nsize);


        }
        elseif ($limit !=""){
            $powerball_list_to = new Pb_Result_Powerball;
            if(!empty($round))
                $powerball_list_to = $powerball_list_to->where("round", $round);
            $powerball_list_to = $powerball_list_to->orderBy("day_round", "DESC");
            $powerball_list_to = $powerball_list_to->select(
                DB::raw("GROUP_CONCAT(pb_result_powerball.pb_uo ORDER BY day_round DESC SEPARATOR ',' ) as `puo`"),
                DB::raw("GROUP_CONCAT(pb_result_powerball.pb_oe ORDER BY day_round DESC SEPARATOR ',' ) as `poe`"),
                DB::raw("GROUP_CONCAT(pb_result_powerball.nb_oe ORDER BY day_round DESC SEPARATOR ',') as `noe`"),
                DB::raw("GROUP_CONCAT(pb_result_powerball.nb_uo ORDER BY day_round DESC SEPARATOR ',' ) as `nuo`"),
                DB::raw("GROUP_CONCAT(pb_result_powerball.nb_size ORDER BY day_round DESC SEPARATOR ',' ) as `nsize`"));

            $powerball_list_to = $powerball_list_to->limit($limit)->groupBy("group")->get()->toArray();
            $total = !empty($powerball_list_to[0]) ? $powerball_list_to[0] : array();
        }

        if(empty($total))
        {
            echo json_encode(array("status"=>0,"result"=>array()));
            return;
        }

        $nuo_max=$noe_max=$puo_max=$poe_max = $noe_count = $nuo_count = $poe_count = $puo_count  = array(0,0);
        $nsize_max = $nsize_count = array(1=>0,2=>0,3=>0);


        if(!empty($total["poe"])){
            $poe_array = $limit !="" ? explode(",",$this->delIndex($limit,$total["poe"])) : explode(",",$total["poe"]);
            $poe_max = $this->getMax($poe_array,1);
            $poe_count = array_count_values($poe_array);
        }

        if(!empty($total["puo"])){
            $puo_array = $limit !="" ? explode(",",$this->delIndex($limit ,$total["puo"])) : explode(",",$total["puo"]);
            $puo_max = $this->getMax($puo_array,1);
            $puo_count = array_count_values($puo_array);
        }

        if(!empty($total["noe"])){
            $noe_array = $limit !="" ? explode(",",$this->delIndex($limit,$total["noe"])) : explode(",",$total["noe"]);
            $noe_max = $this->getMax($noe_array,1);
            $noe_count = array_count_values($noe_array);
        }

        if(!empty($total["nuo"])){
            $nuo_array = $limit !="" ? explode(",",$this->delIndex($limit ,$total["nuo"])) : explode(",",$total["nuo"]);
            $nuo_max = $this->getMax($nuo_array,1);
            $nuo_count = array_count_values($nuo_array);
        }

        if(!empty($total["nsize"])){
            $nsize_array = $limit !="" ? explode(",",$this->delIndex($limit ,$total["nsize"])) : explode(",",$total["nsize"]);
            $nsize_max = $this->getMax($nsize_array,2);
            $nsize_count = array_count_values($nsize_array);
        }

        echo json_encode(   array(  "status"=>1,
                                    "result"=>array(    "poe" => array("max"=>$poe_max,"count"=>$poe_count),
                                                        "puo" => array("max"=>$puo_max,"count"=>$puo_count),
                                                        "noe" => array("max"=>$noe_max,"count"=>$noe_count),
                                                        "nuo" => array("max"=>$nuo_max,"count"=>$nuo_count),
                                                        "nsize" => array("max"=>$nsize_max,"count"=>$nsize_count)
                                        )));


    }

    /* 패턴별 분석 데이터 */
    public function patternAnalyse(Request $request){
        $from_year = $to_year = 0;
        $from = empty($request->from) ? "" : $request->from;
        $to = empty($request->to) ? "" : $request->to;
        $limit = empty($request->limit) ? 288 : $request->limit;
        $type = !empty($request->type) ? $request->type : "pb_oe";
        $result = array();
        $list = array();
        if ($from != "" && $to != "")
        {
            $from_year  = date("Y",strtotime($from));
            $to_year  = date("Y",strtotime($to));
            for($i = $to_year ; $i >=$from_year;$i--) {
                if ($i > date("Y")  || $i < "2013")
                    continue;
                if ($i == date("Y"))
                    $powerball_list_to = new Pb_Result_Powerball;
                if ($i < date("Y"))
                    $powerball_list_to = DB::connection("comm" . $i)->table("pb_result_powerball");
                $powerball_list_to = $powerball_list_to->orderBy("day_round", "ASC");
                if ($i == $to_year || $i == $from_year) {
                    $powerball_list_to = $powerball_list_to->where("created_date", ">=", $from . " 00:00:00");
                    $powerball_list_to = $powerball_list_to->where("created_date", "<=", $to . " 23:59:59");
                }
                $powerball_list_to = json_decode(json_encode($powerball_list_to->get()->toArray()));
                $list = array_merge($list,$powerball_list_to);
            }

            echo json_encode($this->getPatternDataFromArray($list,$type,$i));
            return;
        }

        elseif ($limit != ""){
            $powerball_list_to = new Pb_Result_Powerball;
            $powerball_list_to = $powerball_list_to->orderBy("day_round", "DESC");
            $powerball_list_to = $powerball_list_to->offset(0)->limit($limit)->get()->toArray();
            $powerball_list_to = array_reverse($powerball_list_to);
            $powerball_list_to = json_decode(json_encode($powerball_list_to));
            $list = array_merge($list,$powerball_list_to);
            echo json_encode($this->getPatternDataFromArray($list,$type,date('Y')));
            return;
        }

        echo json_encode(array("status"=>0,"result"=>array()));
    }

    public function dataSimulate(Request $request){
      $list = array();
      $round = $request->post("round");
      $start_round = $request->post("start_round");
      $type = $request->post("type");
      $range  = PbRange::where("range1","<=",$round)->orderBy("year","DESC")->first();
      if(empty($range)){
        echo json_encode(array("status"=>0,"msg"=>"정의되지 않은 라운드입니다."));
        return;
      }
      $powerball_list_to1 = array();
      $year = $range["year"];
      if($year == date("Y"))
        $powerball_list_to = new Pb_Result_Powerball;
      else {
        $powerball_list_to = DB::connection("comm" . $year)->table("pb_result_powerball");
      }
      $powerball_list_to = $powerball_list_to->where("day_round","<=",$round);
      $powerball_list_to = $powerball_list_to->where("day_round",">=",$start_round);
      $powerball_list_to = $powerball_list_to->orderBy("day_round", "DESC");
      $powerball_list_to = $powerball_list_to->offset(0)->limit(20)->get()->toArray();
      if(sizeof($powerball_list_to) < 20){
        $temp = 20 - sizeof($powerball_list_to);
        if($year  > 2013){
          $year = $year - 1;
          $powerball_list_to1 = DB::connection("comm" .$year)->table("pb_result_powerball");
          $powerball_list_to1 = $powerball_list_to1->where("day_round",">=",$start_round);
          $powerball_list_to1 = $powerball_list_to1->orderBy("day_round", "DESC");
          $powerball_list_to1 = $powerball_list_to1->offset(0)->limit($temp)->get()->toArray();
        }
      }
      if(!empty($powerball_list_to1)){
        $powerball_list_to = array_merge($powerball_list_to,$powerball_list_to1);
      }
      $powerball_list_to = array_reverse($powerball_list_to);
      $powerball_list_to = json_decode(json_encode($powerball_list_to));
      $list = array_merge($list,$powerball_list_to);
      echo json_encode(array(  "pb_oe"=>$this->getPatternDataFromArray($list,"pb_oe",date('Y')),
                                "pb_uo"=>$this->getPatternDataFromArray($list,"pb_uo",date('Y')),
                                "nb_oe"=>$this->getPatternDataFromArray($list,"nb_oe",date('Y')),
                                "nb_uo"=>$this->getPatternDataFromArray($list,"nb_uo",date('Y'))));
    }

    /* 육매 분석데이터 */
    public function getSixAnalyse(Request $request){
        $from_year = $to_year = 0;
        $from = empty($request->from) ? "" : $request->from;
        $to = empty($request->to) ? "" : $request->to;
        $limit = empty($request->limit) ? "" : $request->limit;
        $type = !empty($request->type) ? $request->type : "pb_oe";
        $step  = !empty($request->step) ? $request->step : 6;
        $result = array();
        $list = array();

        if ($from != "" && $to != "")
        {
            $from_year  = date("Y",strtotime($from));
            $to_year  = date("Y",strtotime($to));
            for($i = $to_year ; $i >=$from_year;$i--) {
                if ($i > date("Y")  || $i < "2013")
                    continue;
                if ($i == date("Y"))
                    $powerball_list_to = new Pb_Result_Powerball;
                if ($i < date("Y"))
                    $powerball_list_to = DB::connection("comm" . $i)->table("pb_result_powerball");
                $powerball_list_to = $powerball_list_to->orderBy("day_round", "ASC")->select(DB::raw("pb_result_powerball.round as `data`"),DB::raw("pb_result_powerball.".$type." as type"));
                if ($i == $to_year || $i == $from_year) {
                    $powerball_list_to = $powerball_list_to->where("created_date", ">=", $from . " 00:00:00");
                    $powerball_list_to = $powerball_list_to->where("created_date", "<=", $to . " 23:59:59");
                }
                $powerball_list_to = json_decode(json_encode($powerball_list_to->get()->toArray()));
                $list = array_merge($list,$powerball_list_to);
            }
        }

        elseif ($limit != "") {
            $powerball_list_to = new Pb_Result_Powerball;
            $powerball_list_to = $powerball_list_to->orderBy("day_round", "DESC")->select(DB::raw("pb_result_powerball.round as `data`"),DB::raw("pb_result_powerball.".$type." as type"));
            $powerball_list_to = array_reverse($powerball_list_to->limit($limit)->get()->toArray());
            $powerball_list_to = json_decode(json_encode($powerball_list_to));
            $list = array_merge($list, $powerball_list_to);
        }

        if(!empty($list)){
            foreach($list as $item){
                $temp = $this->getTypePower($type,$item->type);
                array_push($result,array("round"=>$item->data,"class"=>$temp[0],"alias"=>$temp[1]));
            }
        }

        if(empty($result)){
            echo json_encode(array("status"=>0,"result"=>array()));
            return;
        }

        $result = array_chunk($result,$step);
        echo json_encode(array("status"=>1,"result"=>array("list"=>$result,"step"=>$step)));
    }



    /*검색 기간내 최대/최소 통계 데이터 (무효처리 있는 날짜 제외)*/
    public function analyseMinMax(Request $request){

        $from_year = $to_year = 0;                             //2021,2021 년도
        $from = empty($request->from) ? "" : $request->from;  // 언제부터 2021-02-10
        $to = empty($request->to) ? "" : $request->to;        //언제까지 2021-02-14
        $result = array();  //결과 담을 배렬
        $temp = array();    // 처리부분 담을 배렬
        /* 파워볼 ,숫자합 홀짝  대중소*/
        $po = $pe = $no = $ne = $n3 = $n2 =  $n1 = array(array("date"=>"","counts"=>0),array("date"=>"","counts"=>288));
        if($from !="" && $to !=""){
            $from_year  = date("Y",strtotime($from));
            $to_year  = date("Y",strtotime($to));

            for($i = $to_year ; $i >=$from_year;$i--) {
                if ($i > date("Y") || $i < "2013")
                    continue;

                // 파워볼 홀짝 최대
                /* 해당 년도별로 자료기지 련결시켜준다.현재 년도이면 기종 련결을 리용한다 */
                if ($i == date("Y"))
                    $model1 = new Pb_Result_Powerball;
                else
                    $model1 = DB::connection("comm" . $i)->table("pb_result_powerball");
                if ($i == $to_year || $i == $from_year) {
                    $model1  = $model1->where("created_date", ">=", $from . " 00:00:00");
                    $model1 = $model1->where("created_date", "<=", $to . " 23:59:59");
                }

                $m_1 =  $model1->select(DB::raw('DATE(created_date) as dates'), DB::raw('COUNT(id) as counts'),DB::raw('CONCAT("p",pb_oe) as ptype'))
                    ->groupBy("dates")
                    ->groupBy("pb_oe")
                    ->orderByRaw('counts DESC');
                $m_1 = DB::connection("comm" . $i)->table( DB::raw("({$m_1->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_1->getQuery() : $m_1)
                    ->groupBy(array("sub.ptype"))
                    ->limit(2)
                    ->get()
                    ->toArray(); // 파워볼 홀짝 최대


                // 숫자합 홀짝 최대
                if ($i == date("Y"))
                    $model2 = new Pb_Result_Powerball;
                else
                    $model2 = DB::connection("comm" . $i)->table("pb_result_powerball");
                if ($i == $to_year || $i == $from_year) {
                    $model2  = $model2->where("created_date", ">=", $from . " 00:00:00");
                    $model2 = $model2->where("created_date", "<=", $to . " 23:59:59");
                }

                $m_2 =  $model2->select(DB::raw('DATE(created_date) as dates'), DB::raw('COUNT(id) as counts'),DB::raw('CONCAT("p",nb_oe) as ptype'))
                    ->groupBy("dates")
                    ->groupBy("nb_oe")
                    ->orderByRaw('counts DESC');
                $m_2 = DB::connection("comm" . $i)->table( DB::raw("({$m_2->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_2->getQuery() : $m_2)
                    ->groupBy(array("sub.ptype"))
                    ->limit(2)
                    ->get()
                    ->toArray();  // 숫자합 홀짝 최대


                // 숫자합 대 중 소 최대
                if ($i == date("Y"))
                    $model3 = new Pb_Result_Powerball;
                else
                    $model3 = DB::connection("comm" . $i)->table("pb_result_powerball");

                if ($i == $to_year || $i == $from_year) {
                    $model3  = $model3->where("created_date", ">=", $from . " 00:00:00");
                    $model3 = $model3->where("created_date", "<=", $to . " 23:59:59");
                }

                $m_3 =  $model3->select(DB::raw('DATE(created_date) as dates'), DB::raw('COUNT(id) as counts'),DB::raw('CONCAT("p",nb_size) as ptype'))
                    ->groupBy("dates")
                    ->groupBy("nb_size")
                    ->orderByRaw('counts DESC');

                $m_3 = DB::connection("comm" . $i)->table( DB::raw("({$m_3->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_3->getQuery() : $m_3)
                    ->groupBy(array("sub.ptype"))
                    ->limit(3)
                    ->get()
                    ->toArray();  // 숫자합 대 중 소 최대


                // 파워볼 홀짝 최소
                if ($i == date("Y"))
                    $model4 = new Pb_Result_Powerball;
                else
                    $model4 = DB::connection("comm" . $i)->table("pb_result_powerball");

                if ($i == $to_year || $i == $from_year) {
                    $model4  = $model4->where("created_date", ">=", $from . " 00:00:00");
                    $model4 = $model4->where("created_date", "<=", $to . " 23:59:59");
                }

                $m_4 =  $model4->select(DB::raw('DATE(created_date) as dates'), DB::raw('COUNT(id) as counts'),DB::raw('CONCAT("p",pb_oe) as ptype'))
                    ->groupBy("dates")
                    ->groupBy("pb_oe")
                    ->orderByRaw('counts ASC');

                $m_4 = DB::connection("comm" . $i)->table( DB::raw("({$m_4->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_4->getQuery() : $m_4)
                    ->groupBy(array("sub.ptype"))
                    ->limit(2)
                    ->get()
                    ->toArray(); // 파워볼 홀짝 최소


                // 숫자합 홀짝 최소
                if ($i == date("Y"))
                    $model5 = new Pb_Result_Powerball;
                else
                    $model5 = DB::connection("comm" . $i)->table("pb_result_powerball");
                if ($i == $to_year || $i == $from_year) {
                    $model5  = $model5->where("created_date", ">=", $from . " 00:00:00");
                    $model5 = $model5->where("created_date", "<=", $to . " 23:59:59");
                }
                $m_5 =  $model5->select(DB::raw('DATE(created_date) as dates'), DB::raw('COUNT(id) as counts'),DB::raw('CONCAT("p",nb_oe) as ptype'))
                    ->groupBy("dates")
                    ->groupBy("nb_oe")
                    ->orderByRaw('counts ASC');

                $m_5 = DB::connection("comm" . $i)->table( DB::raw("({$m_5->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_5->getQuery() : $m_5)
                    ->groupBy(array("sub.ptype"))
                    ->limit(2)
                    ->get()
                    ->toArray();  // 숫자합 홀짝 최소


                // 숫자합 대 중 소 최소
                if ($i == date("Y"))
                    $model6 = new Pb_Result_Powerball;
                else
                    $model6 = DB::connection("comm" . $i)->table("pb_result_powerball");

                if ($i == $to_year || $i == $from_year) {
                    $model6  = $model6->where("created_date", ">=", $from . " 00:00:00");
                    $model6 = $model6->where("created_date", "<=", $to . " 23:59:59");
                }
                $m_6 =  $model6->select(DB::raw('DATE(created_date) as dates'), DB::raw('COUNT(id) as counts'),DB::raw('CONCAT("p",nb_size) as ptype'))
                    ->groupBy("dates")
                    ->groupBy("nb_size")
                    ->orderByRaw('counts ASC');

                $m_6 = DB::connection("comm" . $i)->table( DB::raw("({$m_6->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_6->getQuery() : $m_6)
                    ->groupBy(array("sub.ptype"))
                    ->limit(3)
                    ->get()
                    ->toArray();  // 숫자합 대 중 소 최소

                /* 최대값 m_1~ m_3 */
                if(!empty($m_1)) {
                    $temp=array();
                    foreach ($m_1 as $value)
                        $temp[$value->ptype] = $value;

                    if(!empty($temp["p1"]) && $temp["p1"]->counts > $po[0]["counts"] )
                    {
                        $po[0]["counts"] = $temp["p1"]->counts;
                        $po[0]["date"] = $temp["p1"]->dates;
                    }
                    if(!empty($temp["p0"]) && $temp["p0"]->counts > $pe[0]["counts"] )
                    {
                        $pe[0]["counts"] = $temp["p0"]->counts;
                        $pe[0]["date"] = $temp["p0"]->dates;
                    }
                }

                if(!empty($m_2)) {
                    $temp=array();
                    foreach ($m_2 as $value)
                        $temp[$value->ptype] = $value;

                    if(!empty($temp["p1"]) && $temp["p1"]->counts > $no[0]["counts"] )
                    {
                        $no[0]["counts"] = $temp["p1"]->counts;
                        $no[0]["date"] = $temp["p1"]->dates;
                    }
                    if(!empty($temp["p0"]) && $temp["p0"]->counts > $ne[0]["counts"] )
                    {
                        $ne[0]["counts"] = $temp["p0"]->counts;
                        $ne[0]["date"] = $temp["p0"]->dates;
                    }
                }

                if(!empty($m_3)) {
                    $temp=array();
                    foreach ($m_3 as $value)
                        $temp[$value->ptype] = $value;

                    if(!empty($temp["p1"]) && $temp["p1"]->counts > $n1[0]["counts"] )
                    {
                        $n1[0]["counts"] = $temp["p1"]->counts;
                        $n1[0]["date"] = $temp["p1"]->dates;
                    }
                    if(!empty($temp["p2"]) && $temp["p2"]->counts > $n2[0]["counts"] )
                    {
                        $n2[0]["counts"] = $temp["p2"]->counts;
                        $n2[0]["date"] = $temp["p2"]->dates;
                    }

                    if(!empty($temp["p3"]) && $temp["p3"]->counts > $n3[0]["counts"] )
                    {
                        $n3[0]["counts"] = $temp["p3"]->counts;
                        $n3[0]["date"] = $temp["p3"]->dates;
                    }
                }


                /* 최소값 m_4~ m_6 */
                if(!empty($m_4)) {
                    $temp=array();
                    foreach ($m_4 as $value)
                        $temp[$value->ptype] = $value;

                    if(!empty($temp["p1"]) && $temp["p1"]->counts < $po[1]["counts"] )
                    {
                        $po[1]["counts"] = $temp["p1"]->counts;
                        $po[1]["date"] = $temp["p1"]->dates;
                    }
                    if(!empty($temp["p0"]) && $temp["p0"]->counts < $pe[1]["counts"] )
                    {
                        $pe[1]["counts"] = $temp["p0"]->counts;
                        $pe[1]["date"] = $temp["p0"]->dates;
                    }
                }

                if(!empty($m_5)) {
                    $temp=array();
                    foreach ($m_5 as $value)
                        $temp[$value->ptype] = $value;


                    if(!empty($temp["p1"]) && $temp["p1"]->counts < $no[1]["counts"] )
                    {
                        $no[1]["counts"] = $temp["p1"]->counts;
                        $no[1]["date"] = $temp["p1"]->dates;
                    }
                    if(!empty($temp["p0"]) && $temp["p0"]->counts < $ne[1]["counts"] )
                    {
                        $ne[1]["counts"] = $temp["p0"]->counts;
                        $ne[1]["date"] = $temp["p0"]->dates;
                    }

                }

                if(!empty($m_6)) {
                    $temp=array();
                    foreach ($m_6 as $value)
                        $temp[$value->ptype] = $value;

                    if(!empty($temp["p1"]) && $temp["p1"]->counts < $n1[1]["counts"] )
                    {
                        $n1[1]["counts"] = $temp["p1"]->counts;
                        $n1[1]["date"] = $temp["p1"]->dates;
                    }
                    if(!empty($temp["p2"]) && $temp["p2"]->counts < $n2[1]["counts"] )
                    {
                        $n2[1]["counts"] = $temp["p2"]->counts;
                        $n2[1]["date"] = $temp["p2"]->dates;
                    }

                    if(!empty($temp["p3"]) && $temp["p3"]->counts < $n3[1]["counts"] )
                    {
                        $n3[1]["counts"] = $temp["p3"]->counts;
                        $n3[1]["date"] = $temp["p3"]->dates;
                    }
                }
            }

            echo  json_encode(array("status"=>1,"result"=>array(    $po,
                                                                    $pe,
                                                                    $no,
                                                                    $ne,
                                                                    $n3,
                                                                    $n2,
                                                                    $n1
                                                                   )));
            return;
        }

        echo json_encode(array("status"=>0,"result"=>array()));
    }

    /* 검색 기간내 최대/최소 통계 데이터 날자별로 모두 출력 */
    public function anaylseMinMaxByDate(Request  $request){
        $from_year = $to_year = 0;
        $from = empty($request->from) ? "" : $request->from;
        $to = empty($request->to) ? "" : $request->to;
        $result = array();
        if($from !="" && $to !="") {
            $from_year = date("Y", strtotime($from));
            $to_year = date("Y", strtotime($to));
            for($i = $to_year ; $i >=$from_year;$i--) {
                if ($i > date("Y")  || $i < "2013")
                    continue;
                if ($i == date("Y"))
                    $powerball_list_to = new Pb_Result_Powerball;
                if ($i < date("Y"))
                    $powerball_list_to = DB::connection("comm" . $i)->table("pb_result_powerball");
                if ($i == $to_year || $i == $from_year) {
                    $powerball_list_to  = $powerball_list_to->where("created_date", ">=", $from . " 00:00:00");
                    $powerball_list_to = $powerball_list_to->where("created_date", "<=", $to . " 23:59:59");
                }

                $powerball_list_to = $powerball_list_to->select(
                    DB::raw("GROUP_CONCAT(pb_result_powerball.pb_uo ORDER BY day_round DESC  SEPARATOR ',') as `puo`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.pb_oe ORDER BY day_round DESC  SEPARATOR ',') as `poe`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb_oe ORDER BY day_round DESC  SEPARATOR ',') as `noe`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb_uo ORDER BY day_round DESC  SEPARATOR ',') as `nuo`"),
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb_size ORDER BY day_round DESC  SEPARATOR ',') as `nsize`"),
                    DB::raw("DATE(pb_result_powerball.created_date) as `dates`"));
                $powerball_list_to = $powerball_list_to->orderBy("dates","DESC")->groupBy("dates")->get()->toArray();

                if(!empty($powerball_list_to)){
                    foreach($powerball_list_to as $value){
                        $temp = array();
                        $nuo_max=$noe_max=$puo_max=$poe_max = $noe_count = $nuo_count = $poe_count = $puo_count  = array(0,0); // 최대값 담기 첨수 1:홀 0 :짝 , 1 소 2 중 3 대
                        $nsize_max = $nsize_count = array(1=>0,2=>0,3=>0);
                        $puo  = $poe = $noe = $nuo = $nsize = $dates =  "";

                        if($i == date('Y'))
                        {
                            $puo = $value["puo"];
                            $poe = $value["poe"];
                            $noe = $value["noe"];
                            $nuo = $value["nuo"];
                            $nsize = $value["nsize"];
                            $dates = $value["dates"];
                        }

                        else{
                            $puo = $value->puo;
                            $poe = $value->poe;
                            $noe = $value->noe;
                            $nuo = $value->nuo;
                            $nsize = $value->nsize;
                            $dates = $value->dates;
                        }

                        if(!empty($puo))
                        {
                            $power_init = explode(",",$puo);
                            $puo_max = $this->getMax($power_init,1);
                            $puo_count = array_count_values($power_init);
                        }

                        if(!empty($poe))
                        {
                            $power_init = explode(",",$poe);
                            $poe_max = $this->getMax($power_init,1);
                            $poe_count = array_count_values($power_init);
                        }

                        if(!empty($noe))
                        {
                            $power_init = explode(",",$noe);
                            $noe_max = $this->getMax($power_init,1);
                            $noe_count = array_count_values($power_init);
                        }

                        if(!empty($nuo))
                        {
                            $power_init = explode(",",$nuo);
                            $nuo_max = $this->getMax($power_init,1);
                            $nuo_count = array_count_values($power_init);
                        }

                        if(!empty($nsize))
                        {
                            $power_init = explode(",",$nsize);
                            $nsize_max = $this->getMax($power_init,2);
                            $nsize_count = array_count_values($power_init);
                        }

                        array_push($result,array(    "poe" => array("max"=>$poe_max,"count"=>$poe_count),
                                                            "puo" => array("max"=>$puo_max,"count"=>$puo_count),
                                                            "noe" => array("max"=>$noe_max,"count"=>$noe_count),
                                                            "nuo" => array("max"=>$nuo_max,"count"=>$nuo_count),
                                                            "nsize" => array("max"=>$nsize_max,"count"=>$nsize_count),
                                                            "date"=>$dates
                        ));
                    }
                }
            }
        }
        if(empty($result))
            echo json_encode(array("status"=>0,"result"=>array()));
        echo json_encode(array("status"=>1,"result"=>$result));
    }

    /* 패턴별 분석 */
    public function analysePattern(Request $request){
        $type = empty($request->type) ? "pb_oe" :  $request->type;
        $pattern = $request->pattern;
        if(empty($pattern))
        {
            echo json_encode(array("status"=>0,"result"=>array(),"msg"=>"패턴요청이 들어오지 않았습니다."));
            return;
        }
    }

    public function checkedPattern(Request $request){
        $type_list = array("pb_oe","pb_uo","nb_oe","nb_uo","nb_size");
        $result = array();
        $limit = empty($request->limit) ? 10 : $request->limit;
        $types = empty($request->types ) ? "pb_oe": $request->types;

        if($limit < 3 || $limit > 20){
            echo json_encode(array("status"=>0,"msg"=>"설정한 패턴개수가 정확치 않습니다."));
            return;
        }

        if(!in_array($types,$type_list)){
            echo json_encode(array("status"=>0,"msg"=>"패턴이 지정되지 않았습니다."));
            return;
        }
        $model_list = Pb_Result_Powerball::skip(0)->take($limit)->orderBy("day_round","DESC")->get()->toArray();
        $model_list = array_reverse($model_list);

        if(!empty($model_list))
        {
            foreach($model_list as $value){
                $temp = array();
                $arr_len = 3;
                $temp["round"] = $value["round"];
                $temp["day_round"] = $value["round"];
                $temp["code"] = $value[$types];
                if($types=="pb_oe" || $types =="nb_oe"){
                    $temp["class"] = $value[$types] == 1 ? "sp-odd":"sp-even";
                    $temp["alias"] = $value[$types] == 1 ? "홀":"짝";
                }
                if($types =="pb_uo" || $types =="nb_uo"){
                    $temp["alias"] = "";
                    $temp["class"] = $value[$types] == 1 ? "sp-under":"sp-over";
                }
                if($types =="nb_size"){
                    if($value[$types] == 1) {$temp["class"] = "sp-small";$temp["alias"] = "소";}
                    if($value[$types] == 2) {$temp["class"] = "sp-middle";$temp["alias"] = "중";}
                    if($value[$types] == 3) {$temp["class"] = "sp-big";$temp["alias"] = "대";}
                }
                array_push($result,$temp);
            }
            echo json_encode(array("status"=>1,"result"=>$result));
        }
        else
            echo json_encode(array("status"=>0,"result"=>array()));
    }

    public function  patternTotal(Request $request){
        $poe = $puo = $nuo = $noe = $nsize = array();
        $type_list = array("pb_oe","pb_uo","nb_oe","nb_uo","nb_size");
        $type = empty($request->type) ? "pb_oe" : $request->type;
        $pattern = $request->pattern;
        if(empty($pattern) || !in_array($type,$type_list)){
            echo json_encode(array("status"=>0,"msg"=>"패턴이 지정되지 않았습니다."));
            return;
        }

        for($from_year = 2013 ; $from_year <=date("Y");$from_year++){
            echo $from_year;
            if($from_year == date("Y"))
                $pattern_model= $second_model = new Pb_Result_Powerball;
            else
                $pattern_model = $second_model= DB::connection("comm" . $from_year)->table("pb_result_powerball");

            $patternByDate = $pattern_model->select(
                DB::raw("GROUP_CONCAT(pb_result_powerball.".$type." ORDER BY day_round ASC SEPARATOR '') as `plist`"),
                DB::raw("created_date")
            )
                ->groupBy("group")
                ->orderBy("day_round","ASC")
                ->get()
                ->toArray();
            if(!empty($patternByDate))
            {
                $patternByDate = json_decode(json_encode($patternByDate));
                foreach ($patternByDate as $value){
                    $pat = $this->getPatternPosition($value->plist,$pattern);
                    $pat = array_reverse($pat);
                    if(!empty($pat)){
                        foreach ($pat as $indexes){
                            if($from_year !=date("Y"))
                                $second_model= DB::connection("comm" . $from_year)->table("pb_result_powerball");
                            else
                                $second_model = new Pb_Result_Powerball;
                            $matched = $second_model
                                ->skip($indexes)
                                ->take(strlen($pattern)+1)
                                ->orderBy("day_round","ASC")
                                ->get()
                                ->toArray();
                            $matched = json_decode(json_encode($matched));
                            if(!empty($matched)){
                                foreach ($matched as $value){
                                    array_push($poe,$value->pb_oe);
                                    array_push($puo,$value->pb_uo);
                                    array_push($noe,$value->nb_oe);
                                    array_push($nuo,$value->nb_uo);
                                    array_push($nsize,$value->nb_size);
                                }
                            }
                        }
                    }
                }
            }
        }

        $total = array( "poe"=>$poe,
            "puo"=>$puo,
            "noe"=>$noe,
            "nuo"=>$nuo,
            "nsize"=>$nsize);

        $nuo_max=$noe_max=$puo_max=$poe_max = $noe_count = $nuo_count = $poe_count = $puo_count  = array(0,0);
        $nsize_max = $nsize_count = array(1=>0,2=>0,3=>0);


        if(!empty($total["poe"])){
            $poe_array = $total["poe"];
            var_dump($poe_array);
            return;
            $poe_max = $this->getMax($poe_array,1);
            $poe_count = array_count_values($poe_array);
        }

        if(!empty($total["puo"])){
            $puo_array = $total["puo"];
            $puo_max = $this->getMax($puo_array,1);
            $puo_count = array_count_values($puo_array);
        }

        if(!empty($total["noe"])){
            $noe_array= $total["noe"];
            $noe_max = $this->getMax($noe_array,1);
            $noe_count = array_count_values($noe_array);
        }

        if(!empty($total["nuo"])){
            $nuo_array = $total["nuo"];
            $nuo_max = $this->getMax($nuo_array,1);
            $nuo_count = array_count_values($nuo_array);
        }

        if(!empty($total["nsize"])){
            $nsize_array = $total["nsize"];
            $nsize_max = $this->getMax($nsize_array,2);
            $nsize_count = array_count_values($nsize_array);
        }
        echo json_encode(   array(  "status"=>1,
            "result"=>array(    "poe" => array("max"=>$poe_max,"count"=>$poe_count),
                "puo" => array("max"=>$puo_max,"count"=>$puo_count),
                "noe" => array("max"=>$noe_max,"count"=>$noe_count),
                "nuo" => array("max"=>$nuo_max,"count"=>$nuo_count),
                "nsize" => array("max"=>$nsize_max,"count"=>$nsize_count)
            )));
    }

    public function patternLists(Request $request){
        $type_list = array("pb_oe","pb_uo","nb_oe","nb_uo","nb_size");
        $type = empty($request->type) ? "pb_oe" : $request->type;
        $pattern = $request->pattern;
        $round = $request->round;
        $from = empty($request->from) ? date("Y-m-d") : $request->from;
        $from_year = date("Y", strtotime($from));
        $temp_count = 30;
        $result = array();
        $i = 0;

        if(empty($pattern) || !in_array($type,$type_list)){
            echo json_encode(array("status"=>0,"msg"=>"패턴이 지정되지 않았습니다."));
            return;
        }
        if(empty($round))
        {
            echo json_encode(array("status"=>0,"msg"=>"자료가 존재하지 않습니다."));
            return;
        }

        if($from_year == date("Y"))
            $pattern_model= $second_model = new Pb_Result_Powerball;
        else
            $pattern_model = $second_model= DB::connection("comm" . $from_year)->table("pb_result_powerball");

        while(true){
            if($i > 0 && $temp_count !=0 && $from_year >2013){
                $from_year  = $from_year-1;
                $pattern_model = DB::connection("comm" . $from_year)->table("pb_result_powerball");
            }
            if($from_year == 2013)
            {
                if(sizeof($result) ==0){
                    echo json_encode(array("status"=>0,"result"=>array(),"msg"=>"자료가 비였습니다"));
                    return;
                }
                else{
                    echo json_encode(array("status"=>1,"result"=>$result));
                    return;
                }
            }
            $patternByDate = $pattern_model->select(
                DB::raw("GROUP_CONCAT(pb_result_powerball.".$type." ORDER BY day_round ASC SEPARATOR '') as `plist`"),
                DB::raw("created_date")
            )
                ->whereDate("created_date","<=",$from)
                ->where("day_round","<",$round)
                ->groupBy("group")
                ->orderBy("day_round","ASC")
                ->get()
                ->toArray();
            if(!empty($patternByDate))
            {

                $patternByDate = json_decode(json_encode($patternByDate));
                foreach ($patternByDate as $value){
                    $pat = $this->getPatternPosition($value->plist,$pattern);
                    $pat = array_reverse($pat);
                    if(!empty($pat)){
                        foreach ($pat as $indexes){
                            if($temp_count ==0){
                                echo json_encode(array("status"=>1,"result"=>$result));
                                return;
                            }
                           if($from_year !=date("Y"))
                               $second_model= DB::connection("comm" . $from_year)->table("pb_result_powerball");
                           else
                               $second_model = new Pb_Result_Powerball;
                            $matched = $second_model
                                ->whereDate("created_date","<=",$from)
                                ->where("day_round","<",$round)
                                ->skip($indexes)
                                ->take(strlen($pattern)+1)
                                ->orderBy("day_round","ASC")
                                ->get()
                                ->toArray();
                            $matched = json_decode(json_encode($matched));
                            if(sizeof($matched) < strlen($pattern)+1)
                                continue;
                            $temp = array();
                            $temp["date"] = explode(" ",$matched[0]->created_date)[0];
                            $temp["next"] = end($matched);
                            $temp["type"] = $type;
                            array_pop($matched);
                            $temp["current"] = $matched;
                            array_push($result,$temp);
                            $temp_count = $temp_count-1;
                        }
                    }
                }
            }
            $i++;
        }
    }

    public function check(Request  $request){
        $match = $matches3 = $matches2 = $matches1=  array();
        if(!$this->isLogged)
        {
            echo "<script>alert('로그인 후 이용가능합니다.');window.history.go(-1);</script>";
            return;
        }
        $userId = $this->user->userId;
        $ana_title = PbMarket::where("code","PREMIUM_ANALYZER")->first();
        if(empty($ana_title)){
            echo "<script>alert('파워볼 모의배팅 아이템이 존재하지 않습니다.'):window.parent.document.getElementById('mainFrame').height = '500px';</script>";
            return;
        }
        $item_use = PbItemUse::where("userId",$userId)
                    ->where("terms1","<=",date("Y-m-d H:i:s"))
                    ->where("terms2",">=",date("Y-m-d H:i:s"))
                    ->where("market_id","PREMIUM_ANALYZER")
                    ->first();
        if(empty($item_use)){
            echo "<script>alert(\"[{$ana_title['name']}] 아이템 구매 후 이용 가능합니다. 구매하신 분은 [아이템]에서  [사용] 눌러주세요\");
                window.parent.document.getElementById('mainFrame').height = '500px';</script>";
            return;
        }
        $type = empty($request->type) ? "PowOdd" : $request->type;
        switch($type){
            case "PowOdd":
                $type = 1;
                break;
            case "PowUnder":
                $type = 2;
                break;
            case "DefOdd":
                $type =3;
                break;
            case "DefUnder":
                $type = 4;
                break;
            default:
                $type = 1;
                break;
        }

        $auto_info = PbAutoSetting::with("winlose")->where("userId",$userId )->first();
        $auto_matches = PbAutoMatch::where("userId",$userId )->get()->toArray();
        foreach($auto_matches as $autoes){
            if(empty($match[$autoes["auto_type"]]))
                $match[$autoes["auto_type"]] = array();
            if(empty($match[$autoes["auto_type"]][$autoes["auto_kind"]]))
                $match[$autoes["auto_type"]][$autoes["auto_kind"]] = $autoes;
        }
        $remain = array(0,0);
        $autos = -1;
        $current = 0;
        if(!empty($auto_info) && $auto_info["state"] ==1 && $auto_info["betting_type"] == 1){
            $remain = TimeController::getTimerInPast();
            $autos = 1;
        }
        if(!empty($auto_info) && $auto_info["state"] ==1 && $auto_info["betting_type"] == 2)
        {
            $remain = TimeController::getTimer(2);
            $autos = 2;
        }
        if($autos > 0 && $autos ==1){
            $current = empty($auto_info["current_round"]) ? $auto_info["start_round"] : $auto_info["current_round"];
        }
        if($autos > 0 && $autos ==2){
            $current = Pb_Result_Powerball::orderBy("day_round","DESC")->first()["day_round"]+1;
        }
        $history=PbAutoHistory::where("userId",$userId)->get()->toArray();
        return view("pick.simulate", [
                                            "css"=>"simulator.css",
                                            "js"=>"simulator.js",
                                            "auto_info"=>$auto_info,
                                            "type"=>$type,
                                            "matches"=>$match,
                                            "time"=>strtotime("now"),
                                            "remain"=>$remain,
                                            "autos"=>$autos,
                                            "current"=>$current,
                                            "history"=>$history,
                                            "nickname"=>$this->user->nickname
                                            ]);
    }

    public function setAutoConfig(Request  $request){
        $insert = array();
        if(!empty($request->step))
            $insert["step"] = $request->step;

        if(!empty($request->martin))
            $insert["martin"] = $request->martin;

        if(!empty($request->mny))
            $insert["mny"] = $request->mny;

        if(!empty($request->start_round)){
            $insert["start_round"] = $request->start_round;
        }

        if(!empty($request->end_round)){
            $insert["end_round"] = $request->end_round;
        }
        $insert["current_round"] = 0;
        if(!empty($request->start_amount)){
            $insert["start_amount"] = $request->start_amount;
            $insert["user_amount"] = $request->start_amount;
        }

        PbAutoSetting::updateorCreate(
            ["userId"=>$this->user->userId],$insert
        );
        echo json_encode(array("status"=>1,"msg"=>"successful"));
    }

    public function setAutoMatch(Request $request){
        $insert_data = array();
        $second_pat = ["p2_1_0","p2_1_1","p2_1_2","p2_1_3","p2_2_0","p2_2_1","p2_2_2","p2_2_3","p2_3_0","p2_3_1","p2_3_2","p2_3_3","p2_4_0","p2_4_1","p2_4_2","p2_4_3"];
        $userId = $this->user->userId;
        $var_type = $request->var_type; ///////////파워볼 패턴 종류
        $type = $request->type;   //////////파워볼 종류

        $p1 = $request->p1;
        $a1 = $request->amount1;

        foreach($p1 as $key=>$val){
            $round_t = "round1_".($key + 1);
            if(!empty($a1[$key]) && !empty($p1[$key])){
              PbAutoMatch::updateorCreate([
                              "auto_type"=>1,
                              "auto_kind"=>$key+1,
                              "userId"=>$userId,
                          ],[
                              "auto_pattern"=>str_replace('&nbsp;','',str_replace(" ","",trim(str_replace("<br>","",$p1[$key])))),
                              "money"=>trim(str_replace("<br>","",$a1[$key])),
                              "auto_cate"=>$request->$round_t,
                              "game_kind"=>$key+1
                          ]);
            }
            else {
              PbAutoMatch::where("userId",$userId)->where("auto_type",1)->where("auto_kind",$key+1)->delete();
            }
        }

        foreach($second_pat as $key=>$value){
          if(!empty($request->$value)){
            PbAutoMatch::updateorCreate([
                            "auto_type"=>2,
                            "auto_kind"=>$key+1,
                            "userId"=>$userId,
                        ],[
                            "auto_pattern"=>str_replace('&nbsp;','',str_replace(" ","",trim(str_replace("<br>","",$request->$value)))),
                            "game_kind"=>explode("_",$value)[1]
                        ]);
          }
          else {
            PbAutoMatch::where("userId",$userId)->where("auto_type",2)->where("auto_kind",$key+1)->delete();
          }
        }
        echo json_encode(array("status"=>1));
    }

    public function setAutoStart(Request $request){
        $type = $request->type;
        $code = $request->code;
        if($code == -1)
        {
          $state = 1;
          $settings = PbAutoSetting::where("userId",$this->user->userId)->first();
          if(empty($settings) || empty($settings["user_amount"]) || ( (empty($settings["start_round"]) || empty($settings["end_round"])) && $type == 1 )){
            $state = 0;
          }
          $insert = [
              "state"=>$state,
              "betting_type"=>$type,
              "current_round"=>0,
              "bet_amount"=>0,
              "user_amount"=>DB::raw("start_amount"),
              "w1"=>0,
              "w2"=>0,
              "w3"=>0,
              "w4"=>0,
              "rest1"=>0,
              "rest2"=>0,
              "rest3"=>0,
              "rest4"=>0
          ];
          if($type == 2){
            $last_r = Pb_Result_Powerball::orderBy("day_round","DESC")->first();
            $insert["state"] = 0;
            if(!empty($last_r)){
              if(strtotime("now") - strtotime($last_r["created_date"]) < 300){
                $insert["state"] = 1;
                $insert["start_round"] = $last_r["day_round"];
                $insert["end_round"] = $last_r["day_round"] + 10000;
              }
            }
          }
        }
        else
        {
          $state = 0;
          $insert = [
              "state"=>$state,
              "betting_type"=>$type,
              "current_round"=>0,
              "w1"=>0,
              "w2"=>0,
              "w3"=>0,
              "w4"=>0,
              "rest1"=>0,
              "rest2"=>0,
              "rest3"=>0,
              "rest4"=>0
          ];
        }
        PbAutoSetting::where("userId",$this->user->userId)->update($insert);
        PbAutoMatch::where("userId",$this->user->userId)->update([
          "auto_step"=>0,
          "auto_train"=>0,
          "past_step"=>"",
          "past_cruiser"=>"",
          "past_pattern"=>"",
          "amount_step"=>0
        ]);
        echo 1;
    }

    public function winning(){
        if(!$this->isLogged)
        {
            echo "<script>alert('로그인 후 이용가능합니다.');window.history.go(-1);;</script>";
            return;
        }
        $ana_title = PbMarket::where("code","WINNING_MACHINE")->first();
        if(empty($ana_title)){
            echo "<script>alert('연승제조기 아이템이 존재하지 않습니다.');window.parent.document.getElementById('mainFrame').height = '500px';</script>";
            return;
        }
        $userId = $this->user->userId;
        $item_use = PbItemUse::where("userId",$userId)
            ->where("terms1","<=",date("Y-m-d H:i:s"))
            ->where("terms2",">=",date("Y-m-d H:i:s"))
            ->where("market_id","WINNING_MACHINE")
            ->first();
        if(empty($item_use)){
            echo "<script>alert(\"[{$ana_title['name']}] 아이템 구매 후 이용 가능합니다. 구매하신 분은 [아이템]에서  [사용] 눌러주세요\");
                            window.parent.document.getElementById('mainFrame').height = '500px';</script>";
            return;
        }

        return view("pick.winning", [
            "css"=>"winning.css",
            "js"=>"winning.js",
            "p_remain"=>TimeController::getTimer(2),
            "api_token"=>$this->user->api_token,
            "winning"=>1
        ]);
    }

    public function getRoundBox(Request $request){
        $alias = array();
        $alias["nb_oe"][1] = $alias["pb_oe"][1]=array("sp-odd","홀");
        $alias["nb_oe"][0] = $alias["pb_oe"][0]=array("sp-even","짝");

        $alias["nb_uo"][1] = $alias["pb_uo"][1]=array("sp-odd","언");
        $alias["nb_uo"][0] = $alias["nb_uo"][0]=array("sp-even","오");
        $from_round = $request->from_round;
        $to_round = $request->to_round;
        $pb_type = $request->pb_type;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $result = array();
        $roundbox = array();
        if(empty($from_round) || empty($to_round) || empty($pb_type) || empty($from_date) || empty($to_date)){
            echo json_encode(array("status"=>0));
            return;
        }
        $from_year  = date("Y",strtotime($from_date));
        $to_year  = date("Y",strtotime($to_date));
        for($i = $to_year ; $i >=$from_year;$i--) {
            if ($i > date("Y") || $i < "2013")
                continue;
            if ($i == date("Y"))
                $powerball_list_to = new Pb_Result_Powerball;
            if ($i < date("Y"))
                $powerball_list_to = DB::connection("comm" . $i)->table("pb_result_powerball");

            $powerball_list_to = $powerball_list_to->orderBy("day_round", "DESC");
            if ($i == $to_year || $i == $from_year) {
                $powerball_list_to = $powerball_list_to->where("created_date", ">=", $from_date . " 00:00:00");
                $powerball_list_to = $powerball_list_to->where("created_date", "<=", $to_date . " 23:59:59");
            }
            $powerball_list_to = $powerball_list_to->where("round",">=",$from_round)->where("round","<=",$to_round);
            $powerball_list_to = $powerball_list_to->select(DB::raw("pb_result_powerball.".$pb_type." as `res`"),DB::raw("pb_result_powerball.round as round"),DB::raw("DATE(pb_result_powerball.created_date) as date"))->orderBy("date","DESC")->get()->toArray();
            if(!empty($powerball_list_to)) {
                $powerball_list_to = json_decode(json_encode($powerball_list_to));
                foreach ($powerball_list_to as $value) {

                    $result[$value->date][$value->round] = array("pick"=>$value->res,"alias"=>$alias[$pb_type][$value->res][1],"class"=>$alias[$pb_type][$value->res][0]);
                    if(!isset($roundbox[$value->round][$value->res]))
                        $roundbox[$value->round][$value->res] = 0;
                    $roundbox[$value->round][$value->res]++;
                }
            }

        }

        $round_list = array();
        for($i = $from_round;  $i <= $to_round;$i++){
            array_push($round_list,$i);
            if(!isset($roundbox[$i])){
                $roundbox[$i][0]=$roundbox[$i][1] =0;
            }
        }

        if(sizeof($result) > 0){
            echo json_encode(array("status"=>1,"result"=>array("list"=>$result,"max"=>$roundbox,"terms"=>$round_list)));
        }
        else
            echo json_encode(array("status"=>0));
    }

    public function calculateWinning(Request $request){
        $round = Pb_Result_Powerball::orderBy("day_round","DESC")->first();
        if(empty($round)){
            echo json_encode(array("status"=>0));
            return;
        }
        $end_round = $round["day_round"];

        $month = intval(date("m"));
        $year= intval(date("Y"));
        $month = $month - 3;
        if($month <= 0){
            $month  += 12;
            $year -= 1;
        }
        PbBettingCtl::where("pick_date","<=",$year."-".$month)->delete();

        $raw = PbBettingCtl::with(["room","user"])->where("pb_betting_ctl.status",1)->get()->toArray();

        if(empty($raw)){
            echo json_encode(array("status"=>0,"msg"=>"empty picks"));
            return;
        }

        if(!empty($raw)){
            $userpicks = array();
            foreach($raw as $index){
                $insert_array = new \stdClass();
                $pb_oe = $pb_uo = $nb_oe = $nb_uo = $nb_size = $total =  array(0,0);
                $pb_oewin = $pb_uowin=  $nb_oewin = $nb_uowin = $nb_sizewin = array(0,0);
                $current_win = 0;
                $pick_result = (object)json_decode($index["content"],false);
                $lose = false;
                foreach($pick_result as $key=>$pick){
                    if($pick->is_win ==1)
                    {
                        $total[0] += 1;
                        $$key[0] += 1;
                        $current_win += 1;
                        if($key == "pb_oe")
                            $pb_oewin[0] +=1;
                        if($key == "pb_uo")
                            $pb_uowin[0] +=1;
                        if($key == "nb_oe")
                            $nb_oewin[0] +=1;
                        if($key == "nb_uo")
                            $nb_uowin[0] +=1;
                        if($key == "nb_size")
                            $nb_sizewin[0] +=1;
                    }
                    if($pick->is_win ==2)
                    {
                        $lose = true;
                        $total[1] +=1;
                        $$key[1] +=1;
                        $current_win = 0;
                        if($key == "pb_oe")
                        {
                            if($pb_oewin[0] > $pb_oewin[1])
                                $pb_oewin[1] = $pb_oewin[0];
                            $pb_oewin[0] =0;
                        }
                        if($key == "pb_uo")
                        {
                            if($pb_uowin[0] > $pb_uowin[1])
                                $pb_uowin[1] = $pb_uowin[0];
                            $pb_uowin[0] =0;
                        }
                        if($key == "nb_oe")
                        {
                            if($nb_oewin[0] > $nb_oewin[1])
                                $nb_oewin[1] = $nb_oewin[0];
                            $nb_oewin[0] =0;
                        }
                        if($key == "nb_uo")
                        {
                            if($nb_uowin[0] > $nb_uowin[1])
                                $nb_uowin[1] = $nb_uowin[0];
                            $nb_uowin[0] =0;
                        }
                        if($key == "nb_size")
                        {
                            if($nb_sizewin[0] > $nb_sizewin[1])
                                $nb_sizewin[1] = $nb_sizewin[0];
                            $nb_sizewin[0] =0;
                        }
                    }
                }

                if($pb_oewin[0] > $pb_oewin[1])
                    $pb_oewin[1] = $pb_oewin[0];

                if($pb_uowin[0] > $pb_uowin[1])
                    $pb_uowin[1] = $pb_uowin[0];

                if($nb_oewin[0] > $nb_oewin[1])
                    $nb_oewin[1] = $nb_oewin[0];

                if($nb_uowin[0] > $nb_uowin[1])
                    $nb_uowin[1] = $nb_uowin[0];

                if($nb_sizewin[0] > $nb_sizewin[1])
                    $nb_sizewin[1] = $nb_sizewin[0];
                if(!empty($index["room"]) && !empty($index["user"]))
                {
                    $insert = array();
                    $win_h = new \stdClass();
                    if(!empty($index["room"]["winning_history"])){
                        $win_h = (object)json_decode($index["room"]["winning_history"],false);
                        $win_h->pb->win += $pb_oe[0]+$pb_uo[0];
                        $win_h->pb->lose += $pb_oe[1]+$pb_uo[1];
                        $win_h->nb->win += $nb_oe[0]+$nb_uo[0]+$nb_size[0];
                        $win_h->nb->lose += $nb_oe[1]+$nb_uo[1]+$nb_size[1];
                        $win_h->total->win += $pb_oe[0]+$pb_uo[0]+$nb_oe[0]+$nb_uo[0]+$nb_size[0];
                        $win_h->total->lose += $pb_oe[1]+$pb_uo[1]+$nb_oe[1]+$nb_uo[1]+$nb_size[1];
                        if($current_win ==0 || $lose)
                            $win_h->current_win = 0;
                        if($current_win > 0){
                            $win_h->current_win += $current_win;
                            if($win_h->current_win > $index["room"]["max_win"])
                                $insert["max_win"] = $win_h->current_win;
                        }

                        $insert["winning_history"] = json_encode($win_h);
                        $insert["cur_win"] = $win_h->current_win;
                    }
                    else{
                        $win_h->pb  =new \stdClass();
                        $win_h->nb  =new \stdClass();
                        $win_h->total = new \stdClass();
                        $win_h->current_win  =$current_win;
                        $win_h->total->win = $pb_oe[0]+$pb_uo[0]+$nb_oe[0]+$nb_uo[0]+$nb_size[0];
                        $win_h->total->lose= $pb_oe[1]+$pb_uo[1]+$nb_oe[1]+$nb_uo[1]+$nb_size[1];
                        $win_h->pb->win= $pb_oe[0]+$pb_uo[0];
                        $win_h->pb->lose= $pb_oe[1]+$pb_uo[1];
                        $win_h->nb->win= $nb_oe[0]+$nb_uo[0]+$nb_size[0];
                        $win_h->nb->lose= $nb_oe[1]+$nb_uo[1]+$nb_size[1];
                        $insert["winning_history"] = json_encode($win_h);
                        $insert["max_win"] = $current_win;
                        $insert["cur_win"] = $win_h->current_win;
                    }
                    PbRoom::where("id",$index["room"]["id"])->update($insert);
                }

                if(!empty($index["user"])){
                    $insert  = array();
                    $win_h = new \stdClass();
                    if(!empty($index["user"]["winning_history"])){
                        $win_h = (object)json_decode($index["user"]["winning_history"],false);

                        if($current_win ==0 || $lose)
                            $win_h->current_win->p = 0;
                        if($current_win > 0)
                        {
                            $win_h->current_win->p += $current_win;
                            if(( $index["user"]["win_date"] >= $this->getDayBeforeWeek() && $win_h->current_win->p >= 5  && $win_h->current_win->p >=  $index["user"]["badge"]) ||
                                $win_h->current_win->p >= 5 && $index["user"]["win_date"] < $this->getDayBeforeWeek())
                            {
                                $insert["win_date"] = date("Y-m-d");
                                $insert["badge"] = $win_h->current_win->p;
                            }
                            if($win_h->current_win->p < 5 && $index["user"]["win_date"] < $this->getDayBeforeWeek()){
                                $insert["badge"] = 0;
                            }
                            if($win_h->current_win->p > $index["user"]["max_win"])
                                $insert["max_win"] = $win_h->current_win->p;
                        }

                        if($pb_oewin[1] > 0 ){
                            $win_h->pb_oe->current_win += $pb_oewin[1];
                            if($win_h->pb_oe->current_win > $win_h->current_win->pb_oe)
                                $win_h->current_win->pb_oe = $win_h->pb_oe->current_win;
                        }
                        else{
                            $win_h->pb_oe->current_win = 0;
                        }
                        if($pb_uowin[1] > 0 ){
                            $win_h->pb_uo->current_win += $pb_uowin[1];
                            if($win_h->pb_uo->current_win > $win_h->current_win->pb_uo)
                                $win_h->current_win->pb_uo = $win_h->pb_uo->current_win;
                        }
                        else{
                            $win_h->pb_uo->current_win = 0;
                        }
                        if($nb_oewin[1] > 0 ){
                            $win_h->nb_oe->current_win += $nb_oewin[1];
                            if($win_h->nb_oe->current_win > $win_h->current_win->nb_oe)
                                $win_h->current_win->nb_oe = $win_h->nb_oe->current_win;
                        }
                        else{
                            $win_h->nb_oe->current_win = 0;
                        }
                        if($nb_uowin[1] > 0 ){
                            $win_h->nb_uo->current_win += $nb_uowin[1];
                            if($win_h->nb_uo->current_win > $win_h->current_win->nb_uo)
                                $win_h->current_win->nb_uo = $win_h->nb_uo->current_win;
                        }
                        else{
                            $win_h->nb_uo->current_win = 0;
                        }
                        if($nb_sizewin[1] > 0 ){
                            $win_h->nb_size->current_win += $nb_sizewin[1];
                            if($win_h->nb_size->current_win > $win_h->current_win->nb_size)
                                $win_h->current_win->nb_size = $win_h->nb_size->current_win;
                        }
                        else{
                            $win_h->nb_size->current_win = 0;
                        }
                        $win_h->pb_oe->win  += $pb_oe[0];
                        $win_h->pb_oe->lose += $pb_oe[1];

                        $win_h->pb_uo->win  += $pb_uo[0];
                        $win_h->pb_uo->lose += $pb_uo[1];

                        $win_h->nb_oe->win  += $nb_oe[0];
                        $win_h->nb_oe->lose += $nb_oe[1];

                        $win_h->nb_uo->win  += $nb_uo[0];
                        $win_h->nb_uo->lose += $nb_uo[1];

                        $win_h->nb_size->win  += $nb_size[0];
                        $win_h->nb_size->lose += $nb_size[1];
                    }
                    else{
                        $win_h->current_win = new \stdClass();
                        $win_h->pb_oe = new \stdClass();
                        $win_h->pb_uo = new \stdClass();
                        $win_h->nb_oe = new \stdClass();
                        $win_h->nb_uo = new \stdClass();
                        $win_h->nb_size = new \stdClass();

                        $win_h->current_win->p = $current_win;
                        $win_h->current_win->pb_oe = $win_h->pb_oe->win = $win_h->pb_oe->current_win = $pb_oe[0];
                        $win_h->pb_oe->lose = $pb_oe[1];

                        $win_h->current_win->pb_uo = $win_h->pb_uo->win = $win_h->pb_uo->current_win = $pb_uo[0];
                        $win_h->pb_uo->lose = $pb_uo[1];

                        $win_h->current_win->nb_oe = $win_h->nb_oe->win = $win_h->nb_oe->current_win = $nb_oe[0];
                        $win_h->nb_oe->lose = $nb_oe[1];

                        $win_h->current_win->nb_uo = $win_h->nb_uo->current_win = $win_h->nb_uo->win = $nb_uo[0];
                        $win_h->nb_uo->lose = $nb_uo[1];

                        $win_h->current_win->nb_size = $win_h->nb_size->current_win = $win_h->nb_size->win =$nb_size[0];
                        $win_h->nb_size->lose = $nb_size[1];

                        $insert["max_win"] = $current_win;
                    }
                    $insert["winning_history"] = json_encode($win_h);

                    User::where("userId",$index["user"]["userId"])->update($insert);
                }

            }
            PbBettingCtl::where("status",1)->update(["status"=>0]);
        }
        echo json_encode(array("status"=>1));
    }
    public function getChatPicks(Request $request){
        $roomIdx = PbRoom::where("roomIdx",$request->roomIdx)->first();
        if(empty($roomIdx)){
            echo json_encode(array("status"=>0));
            return;
        }
        $round = $roomIdx["round"];
        $result = Pb_Result_Powerball::with("bettingData")->orderBy("pb_result_powerball.day_round","DESC")->skip(0)->limit(288)->get()->toArray();
        echo json_encode(array("status"=>1,"result"=>array("list"=>$result,"round"=>$round)));
    }

    /*  파워볼 연속 데이터 최대값 얻는 모듈  $type=1이면 홀짝,언오버 통계 2이면 대중소 통계*/
    private function getMax($arrayList,$type)
    {
        if($type == 2){
            $max[1] = $max[2] = $max[3] =0;
            $temp[1] = $temp[2] =$temp[3] =0;
        }

        else
        {
            $max[1] = $max[0] = 0;
            $temp[1] = $temp[0] = 0;
        }
        if(empty($arrayList))
            return $max;
        $previous_value=$arrayList[0];

        for ($i =0; $i < sizeof($arrayList); $i++) {
            $arrayList[$i] == intval($arrayList[$i]);
            if ($arrayList[$i] == $previous_value) {
                $temp[$arrayList[$i]]++;
                if($i == sizeof($arrayList)-1)
                    if ($max[$arrayList[$i]] < $temp[$arrayList[$i]])
                        $max[$arrayList[$i]] = $temp[$arrayList[$i]];
            } else {
                $temp[$arrayList[$i]] =1;
                if ($max[$previous_value] < $temp[$previous_value])
                    $max[$previous_value] = $temp[$previous_value];
                $temp[$previous_value] = 0;
                $previous_value = $arrayList[$i];
            }
        }
        return $max;
    }

    private function delIndex($limit,$array){
        return substr($array,0,$limit*2-1);
    }

    private function getPatternDataFromArray($lists,$type){
        $day_round = 0;
        $pick_info = "";
        $max_appear = 0;/* 최대 련속 나타날 개수 */
        /* 비였다면 status값을 0으로 돌려 준다.*/
        if(empty($lists))
            return array("status"=>0,"result"=>array());
        else
        {
            $day_round = $lists[0]->round;
            $pick_info = $lists[0]->$type;
            $previous_list = array($day_round);
            $previous_item = strval($pick_info);
            $pung =0;
            $temp_pung = 1;
            $result = array();
            foreach ($lists as $key => $index){
                $day_round = $index->round;
                $pick_info = $index->$type;
                if(sizeof($lists) == 1){
                  $temp = $this->getTypePower($type,$previous_item);
                  array_push($result,array("alias"=>$temp[1],"type"=>$temp[0],"list"=>$previous_list));
                  return array("status"=>1,"result"=>array("max"=>1,"list"=>$result,"type"=>$type,"pung"=>1));
                }
                if( $key ==0)
                    continue;
                $temp = $this->getTypePower($type,$previous_item);
                if($previous_item ==  $pick_info){
                    if($temp_pung > 1 && $temp_pung > $pung)
                        $pung = $temp_pung;
                    $temp_pung = 0;
                    array_push($previous_list,$day_round);
                    if($key == sizeof($lists)-1)
                    {
                        array_push($result,array("alias"=>$temp[1],"type"=>$temp[0],"list"=>$previous_list));
                        if(sizeof($previous_list) > $max_appear)
                            $max_appear = sizeof($previous_list);
                    }
                }
                if($previous_item !=  $pick_info)
                {
                    $temp_pung++;
                    array_push($result,array("alias"=>$temp[1],"type"=>$temp[0],"list"=>$previous_list));
                    if(sizeof($previous_list) > $max_appear)
                        $max_appear = sizeof($previous_list);
                    $previous_list= array($day_round);
                    $previous_item =  $pick_info;
                    if($key == sizeof($lists)-1)
                    {
                        $temp = $this->getTypePower($type,$previous_item);
                        array_push($result,array("alias"=>$temp[1],"type"=>$temp[0],"list"=>$previous_list));
                    }
                }
            }
            return array("status"=>1,"result"=>array("max"=>$max_appear,"list"=>$result,"type"=>$type,"pung"=>$pung));
        }
    }

    private function getTypePower($type,$pick){
        $temp = array();
        if($type == "pb_oe" || $type == "nb_oe"){
            $temp = $pick == 1 ? array("odd","홀"):array("even","짝");
        }

        if($type == "pb_uo" || $type == "nb_uo"){
            $temp = $pick == 1 ? array("under","언더"):array("over","오버");
        }
        if($type == "nb_size"){
            if($pick ==1)
                $temp = array("under","소");
            if($pick ==2)
                $temp = array("middle","중");
            if($pick ==3)
                $temp = array("over","대");
        }
        return $temp;
    }

    private function getPatternPosition($str,$toFind){
        $start = 0;
        $result = array();
        while(($pos = strpos(($str),$toFind,$start)) !== false) {
            array_push($result,$pos);
            $start = $pos+1; // start searching from next position.
        }
        return $result;
    }

    public function powLive(Request $request){
        $last = Pb_Result_Powerball::orderBy("day_round","DESC")->first();
        $last_round = !empty($last) ? $last["round"] : 0;
        $last_unique_round = !empty($last) ? $last["day_round"] : 0;
        $powerball_result = Pb_Result_Powerball::orderBy("day_round","DESC")->limit(288)->get()->toArray();
        return view('pick.powerball_live', [
                "js" =>"",
                "css" => "",
                "last"=>$last_round,
                "last_unique_round"=>$last_unique_round,
                "powerball_result" =>$powerball_result
            ]
        );
    }



    private function getDayBeforeWeek(){
        return date('Y-m-d', strtotime('-7 days', strtotime("now")));
    }

    public  function liveResult(Request  $request){
        $type = $request->post("type");
        if($type != "ladder"){
            echo json_encode(Pb_Result_Powerball::orderBy("day_round","DESC")->first());
        }
        else{
            $item = Pb_Result_Powerball::orderBy("day_round","DESC")->first();
            $nb1 = $item["nb1"];
            $sadari_result = sadariCheck($nb1);
            echo json_encode(array("created_date"=>$item["created_date"],"type"=>$sadari_result,"list"=>sadariPath($sadari_result)));
        }
    }

    public function setRound(Request $request){
        echo Route::input("name");
    }

    public function setGameSettings(Request $request){
      $power_request = $request->all();
      $profit = array();
      $profit["win_limit"] = trim($power_request["win_limit"]);
      $profit["lost_limit"] = trim($power_request["lost_limit"]);
      if(!empty($profit))
        PbAutoSetting::where("userId",$this->user->userId)->update($profit);

      foreach($power_request["wtimes"] as $key=>$v){
        PbWinLose::updateorCreate(
            ["userId"=>$this->user->userId,
             "win_type"=>1,
             "game_type"=>$key+1],
             [
               "times"=>$v,
               "rest"=>$power_request["wrtimes"][$key]
             ]
        );
      }

      foreach($power_request["ltimes"] as $key=>$v){
        PbWinLose::updateorCreate(
            ["userId"=>$this->user->userId,
             "win_type"=>2,
             "game_type"=>$key+1],
             [
               "times"=>$v,
               "rest"=>$power_request["lrtimes"][$key]
             ]
        );
      }

      echo json_encode(array("status"=>1));

    }

    public function setIndividualGame(Request $request){
      $id = $request->id;
      if($id <= 0)
      {
        echo json_encode(array("status"=>0,"msg"=>"잘못된 파라메터입니다."));
        return;
      }
      else{
          $game = PbAutoMatch::find($id);
          if(empty($game) || $game->userId != $this->user->userId)
          {
            echo json_encode(array("status"=>0,"msg"=>"비여있는 게임입니다."));
            return;
          }
          if($request->type == "rest"){
            $game->state = ($game->state + 1) % 2;
            $game->save();
            echo json_encode(array("status"=>1,"type"=>$game->state));
          }
          else{
            $game->auto_step = 0;
            $game->auto_train = 0;
            $game->past_step = "";
            $game->past_cruiser = "";
            $game->past_pattern = "";
            $game->amount_step  = 0;
            $game->save();
            echo json_encode(array("status"=>1));
          }
          return;
      }
      echo json_encode(array("status"=>0,"msg"=>"잘못된 요청입니다."));
    }

  public function getWinningMachine(Request $request){
      if(!$this->isLogged)
      {
          echo json_encode(array("status"=>0,"msg"=>"로그인 이후 이용가능한 서비스입니다."));
          return;
      }
      $ana_title = PbMarket::where("code","WINNING_MACHINE")->first();
      if(empty($ana_title)){
        echo json_encode(array("status"=>0,"msg"=>"연승제조기 아이템이 존재하지 않습니다."));
        return;
      }
      $userId = $this->user->userId;
      $item_use = PbItemUse::where("userId",$userId)
          ->where("terms1","<=",date("Y-m-d H:i:s"))
          ->where("terms2",">=",date("Y-m-d H:i:s"))
          ->where("market_id","WINNING_MACHINE")
          ->first();
      if(empty($item_use)){
          echo json_encode(array("status"=>0,"code"=>1,"msg"=>"[{$ana_title['name']}] 아이템 구매 후 이용 가능합니다. 구매하신 분은 [아이템]에서  [사용] 눌러주세요"));
          return;
      }
      $pb_oe = $pb_uo = $nb_oe = $nb_uo = array();
      $data = TblWinning::get()->toArray();
      $pb_oe_arr = $pb_uo_arr = $nb_oe_arr = $nb_uo_arr = array(0,0);
      $winning_data = array();
      $winning_data["pb"] = $winning_data["nb"] = array();
      $winning_data["pb"]["oe"] = array();
      $winning_data["pb"]["uo"] = array();
      $winning_data["nb"]["oe"] = array();
      $winning_data["nb"]["uo"] = array();
      if(!empty($data) && sizeof($data) == 400)
      {
        foreach($data as $value){
            if($value["kind"] ==1)
            {
                array_push($pb_oe,$value);
                array_push($winning_data["pb"]["oe"],$value);
                $pb_oe_arr[$value["pick"]]++;
            }
            if($value["kind"] ==2)
            {
              array_push($pb_uo,$value);
              $pb_uo_arr[$value["pick"]]++;
              array_push($winning_data["pb"]["uo"],$value);
            }
            if($value["kind"] ==3)
            {
              array_push($nb_oe,$value);
              array_push($winning_data["nb"]["oe"],$value);
              $nb_oe_arr[$value["pick"]]++;
            }
            if($value["kind"] ==4)
            {
              array_push($nb_uo,$value);
              array_push($winning_data["nb"]["uo"],$value);
              $nb_uo_arr[$value["pick"]]++;
            }
        }

        echo json_encode(array("status"=>1,"result"=>$winning_data,"total"=>array("pb_oe"=>$pb_oe_arr,"pb_uo"=>$pb_uo_arr,"nb_oe"=>$nb_oe_arr,"nb_uo"=>$nb_uo_arr)));
        return;
      }
      echo json_encode(array("status"=>0,"msg"=>"결과가 없습니다."));
      return;
    }
}
