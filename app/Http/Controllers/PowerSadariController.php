<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pb_Result_Powerball;
use DB;

class PowerSadariController extends SecondController
{
    //
    public function view(Request $request)
    {
        if (!$request->has("terms"))
            $key = "date";
        else
            $key = $request->terms;

        switch ($key) {
            case "date":
                $from = !empty($request->from) ? $request->from : date("Y-m-d");
                return view('psadari/powerball_date', [    "js" =>"psadari/powerball_date.js",
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
                return view('psadari/powerball_lates', [   "js" => "psadari/powerball_lates.js",
                                                        "css" => "powerball_date.css",
                                                        "pick_visible" => "none",
                                                        "p_remain"=>TimeController::getTimer(2),
                                                        "from"=>"",
                                                        "next"=>$next,
                                                        "prev"=>$prev,
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
                    $from = !empty($request->from) ? $request->from : date('Y-m-d', strtotime('-6 days', strtotime($to)));
                }
                $date1 =  new \DateTime($from);
                $date2 =  new \DateTime($to);
                $interval = $date1->diff($date2);
                $dif = $interval->days;
                $dif++;
                return view('psadari/powerball_period', [  "js" => "psadari/powerball_period.js",
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
                return view('psadari/powerball_pattern', [     "js" => "psadari/powerball_pattern.js",
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
                    $from = !empty($request->from) ? $request->from : date('Y-m-d', strtotime('-7 days', strtotime($to)));
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
                return view('psadari/powerball_round', [     "js" => "psadari/powerball_round.js",
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
                $mode = empty($request->mode) ? "odd_even":$request->mode;
                if(!empty($request->dateType)){
                    $request->dateType = $request->dateType-1;
                    $to = date("Y-m-d");
                    $from = date('Y-m-d', strtotime('-'.$request->dateType.' days', strtotime($to)));
                }
                else{
                    $to = !empty($request->to) ? $request->to : date("Y-m-d");
                    $from = !empty($request->from) ? $request->from : date('Y-m-d', strtotime('-6 days', strtotime($to)));
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
                return view('psadari/powerball_roundbox', [     "js" => "psadari/powerball_roundbox.js",
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

    public function patternAnalyse(Request $request){
    	$from_year = $to_year = 0;
        $from = empty($request->from) ? "" : $request->from;
        $to = empty($request->to) ? "" : $request->to;
        $limit = empty($request->limit) ? 288 : $request->limit;
        $type = !empty($request->type) ? $request->type : "left_right";
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

    /*검색 기간내 최대/최소 통계 데이터 (무효처리 있는 날짜 제외)*/
    public function analyseMinMax(Request $request){

        $from_year = $to_year = 0;                             //2021,2021 년도
        $from = empty($request->from) ? "" : $request->from;  // 언제부터 2021-02-10
        $to = empty($request->to) ? "" : $request->to;        //언제까지 2021-02-14
        $result = array();  //결과 담을 배렬
        $temp = array();    // 처리부분 담을 배렬
        /* 파워볼 ,숫자합 홀짝  대중소*/
        $po = $pe = $no = $ne = $n3 = $n4 = $n5= $n6 = $n2 =  $n1 = array(array("date"=>"","counts"=>0),array("date"=>"","counts"=>288));
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

                $m_1 =  $model1->select(
                    DB::raw('DATE(created_date) as dates'),
                    DB::raw('COUNT(id) as counts'),
                    DB::raw('CONCAT (
                        "p",
                          CASE
                            WHEN
                            nb1 = 1
                            OR nb1 = 3
                            OR nb1 = 5
                            OR nb1 = 7
                            OR nb1 = 9
                            OR nb1 = 11
                            OR nb1 = 13
                            OR nb1 = 15
                            OR nb1 = 17
                            OR nb1 = 19
                            OR nb1 = 21
                            OR nb1 = 23
                            OR nb1 = 25
                            OR nb1 = 27
                            THEN 1
                            ELSE 0
                          END
                      ) AS ptype'))
                    ->groupBy("dates")
                    ->groupBy("ptype")
                    ->orderByRaw('counts DESC');
                $m_1 = DB::connection("comm" . $i)->table( DB::raw("({$m_1->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_1->getQuery() : $m_1)
                    ->groupBy(array("sub.ptype"))
                    ->limit(2)
                    ->get()
                    ->toArray(); // 좌우 홀짝 최대


                // 숫자합 홀짝 최대
                if ($i == date("Y"))
                    $model2 = new Pb_Result_Powerball;
                else
                    $model2 = DB::connection("comm" . $i)->table("pb_result_powerball");
                if ($i == $to_year || $i == $from_year) {
                    $model2  = $model2->where("created_date", ">=", $from . " 00:00:00");
                    $model2 = $model2->where("created_date", "<=", $to . " 23:59:59");
                }

                $m_2 =  $model2->select(
                    DB::raw('DATE(created_date) as dates'),
                    DB::raw('COUNT(id) as counts'),
                    DB::raw('CONCAT (
                            "p",
                              CASE
                                WHEN nb1 > 0
                                AND nb1 < 15
                                THEN 1
                                ELSE 0
                              END
                          ) AS ptype'))
                    ->groupBy("dates")
                    ->groupBy("ptype")
                    ->orderByRaw('counts DESC');
                $m_2 = DB::connection("comm" . $i)->table( DB::raw("({$m_2->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_2->getQuery() : $m_2)
                    ->groupBy(array("sub.ptype"))
                    ->limit(2)
                    ->get()
                    ->toArray();  // 34 홀짝 최대

                // 숫자합 대 중 소 최대
                if ($i == date("Y"))
                    $model3 = new Pb_Result_Powerball;
                else
                    $model3 = DB::connection("comm" . $i)->table("pb_result_powerball");

                if ($i == $to_year || $i == $from_year) {
                    $model3  = $model3->where("created_date", ">=", $from . " 00:00:00");
                    $model3 = $model3->where("created_date", "<=", $to . " 23:59:59");
                }

                $m_3 =  $model3->select(
                    DB::raw('DATE(created_date) as dates'),
                    DB::raw('COUNT(id) as counts'),
                    DB::raw('CONCAT (
                                "p",
                                  CASE
                                    WHEN nb1 = 2
                                    OR nb1 = 4
                                    OR nb1 = 6
                                    OR nb1 = 8
                                    OR nb1 = 10
                                    OR nb1 = 12
                                    OR nb1 = 14
                                    OR nb1 = 15
                                    OR nb1 = 17
                                    OR nb1 = 19
                                    OR nb1 = 21
                                    OR nb1 = 23
                                    OR nb1 = 25
                                    OR nb1 = 27
                                    THEN 1
                                    ELSE 0
                                  END
                              ) AS ptype'))
                    ->groupBy("dates")
                    ->groupBy("ptype")
                    ->orderByRaw('counts DESC');

                $m_3 = DB::connection("comm" . $i)->table( DB::raw("({$m_3->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_3->getQuery() : $m_3)
                    ->groupBy(array("sub.ptype"))
                    ->limit(2)
                    ->get()
                    ->toArray();  // 홀짝 최대

                // 숫자합 대 중 소 최대
                if ($i == date("Y"))
                    $model7 = new Pb_Result_Powerball;
                else
                    $model7 = DB::connection("comm" . $i)->table("pb_result_powerball");

                if ($i == $to_year || $i == $from_year) {
                    $model7  = $model7->where("created_date", ">=", $from . " 00:00:00");
                    $model7 = $model7->where("created_date", "<=", $to . " 23:59:59");
                }

                $m_7 =  $model7->select(
                    DB::raw('DATE(created_date) as dates'),
                    DB::raw('COUNT(id) as counts'),
                    DB::raw('CONCAT (
                            "p",
                              CASE
                                WHEN nb1 = 15
                                OR nb1 = 17
                                OR nb1 = 19
                                OR nb1 = 21
                                OR nb1 = 23
                                OR nb1 = 25
                                OR nb1 = 27
                                THEN 1

                            WHEN nb1 = 2
                                OR nb1 = 4
                                OR nb1 = 6
                                OR nb1 = 8
                                OR nb1 = 10
                                OR nb1 = 12
                                OR nb1 = 14
                                THEN 2

                                WHEN nb1 = 1
                                OR nb1 = 3
                                OR nb1 = 5
                                OR nb1 = 7
                                OR nb1 = 9
                                OR nb1 = 11
                                OR nb1 = 13
                                THEN 3

                                ELSE 4
                              END
                          ) AS ptype'))
                    ->groupBy("dates")
                    ->groupBy("ptype")
                    ->orderByRaw('counts DESC');

                $m_7 = DB::connection("comm" . $i)->table( DB::raw("({$m_7->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_7->getQuery() : $m_7)
                    ->groupBy(array("sub.ptype"))
                    ->limit(4)
                    ->get()
                    ->toArray();  // 전체 최대


                // 파워볼 홀짝 최소
                if ($i == date("Y"))
                    $model4 = new Pb_Result_Powerball;
                else
                    $model4 = DB::connection("comm" . $i)->table("pb_result_powerball");

                if ($i == $to_year || $i == $from_year) {
                    $model4  = $model4->where("created_date", ">=", $from . " 00:00:00");
                    $model4 = $model4->where("created_date", "<=", $to . " 23:59:59");
                }

                $m_4 =  $model4->select(
                    DB::raw('DATE(created_date) as dates'),
                    DB::raw('COUNT(id) as counts'),
                    DB::raw('CONCAT (
                        "p",
                          CASE
                            WHEN nb1 = 1
                            OR nb1 = 3
                            OR nb1 = 5
                            OR nb1 = 7
                            OR nb1 = 9
                            OR nb1 = 11
                            OR nb1 = 13
                            OR nb1 = 15
                            OR nb1 = 17
                            OR nb1 = 19
                            OR nb1 = 21
                            OR nb1 = 23
                            OR nb1 = 25
                            OR nb1 = 27
                            THEN 1
                            ELSE 0
                          END
                      ) AS ptype'))
                    ->groupBy("dates")
                    ->groupBy("ptype")
                    ->orderByRaw('counts ASC');

                $m_4 = DB::connection("comm" . $i)->table( DB::raw("({$m_4->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_4->getQuery() : $m_4)
                    ->groupBy(array("sub.ptype"))
                    ->limit(2)
                    ->get()
                    ->toArray(); // 좌우 최소


                // 숫자합 홀짝 최소
                if ($i == date("Y"))
                    $model5 = new Pb_Result_Powerball;
                else
                    $model5 = DB::connection("comm" . $i)->table("pb_result_powerball");
                if ($i == $to_year || $i == $from_year) {
                    $model5  = $model5->where("created_date", ">=", $from . " 00:00:00");
                    $model5 = $model5->where("created_date", "<=", $to . " 23:59:59");
                }
                $m_5 =  $model5->select(
                    DB::raw('DATE(created_date) as dates'),
                    DB::raw('COUNT(id) as counts'),
                    DB::raw('CONCAT (
                            "p",
                              CASE
                                WHEN nb1 > 0
                                AND nb1 < 15
                                THEN 1
                                ELSE 0
                              END
                          ) AS ptype'))
                    ->groupBy("dates")
                    ->groupBy("ptype")
                    ->orderByRaw('counts ASC');

                $m_5 = DB::connection("comm" . $i)->table( DB::raw("({$m_5->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_5->getQuery() : $m_5)
                    ->groupBy(array("sub.ptype"))
                    ->limit(2)
                    ->get()
                    ->toArray();  // 34 최소


                // 숫자합 대 중 소 최소
                if ($i == date("Y"))
                    $model6 = new Pb_Result_Powerball;
                else
                    $model6 = DB::connection("comm" . $i)->table("pb_result_powerball");

                if ($i == $to_year || $i == $from_year) {
                    $model6  = $model6->where("created_date", ">=", $from . " 00:00:00");
                    $model6 = $model6->where("created_date", "<=", $to . " 23:59:59");
                }
                $m_6 =  $model6->select(
                    DB::raw('DATE(created_date) as dates'),
                    DB::raw('COUNT(id) as counts'),
                    DB::raw('CONCAT (
                                "p",
                                  CASE
                                    WHEN nb1 = 2
                                    OR nb1 = 4
                                    OR nb1 = 6
                                    OR nb1 = 8
                                    OR nb1 = 10
                                    OR nb1 = 12
                                    OR nb1 = 14
                                    OR nb1 = 15
                                    OR nb1 = 17
                                    OR nb1 = 19
                                    OR nb1 = 21
                                    OR nb1 = 23
                                    OR nb1 = 25
                                    OR nb1 = 27
                                    THEN 1
                                    ELSE 0
                                  END
                              ) AS ptype'))
                    ->groupBy("dates")
                    ->groupBy("ptype")
                    ->orderByRaw('counts ASC');

                $m_6 = DB::connection("comm" . $i)->table( DB::raw("({$m_6->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_6->getQuery() : $m_6)
                    ->groupBy(array("sub.ptype"))
                    ->limit(3)
                    ->get()
                    ->toArray();  // 홀짝 최소


                // 숫자합 대 중 소 최대
                if ($i == date("Y"))
                    $model8 = new Pb_Result_Powerball;
                else
                    $model8 = DB::connection("comm" . $i)->table("pb_result_powerball");

                if ($i == $to_year || $i == $from_year) {
                    $model8  = $model8->where("created_date", ">=", $from . " 00:00:00");
                    $model8 = $model8->where("created_date", "<=", $to . " 23:59:59");
                }

                $m_8 =  $model8->select(
                    DB::raw('DATE(created_date) as dates'),
                    DB::raw('COUNT(id) as counts'),
                    DB::raw('CONCAT (
                            "p",
                              CASE
                                WHEN nb1 = 15
                                OR nb1 = 17
                                OR nb1 = 19
                                OR nb1 = 21
                                OR nb1 = 23
                                OR nb1 = 25
                                OR nb1 = 27
                                THEN 1

                            WHEN nb1 = 2
                                OR nb1 = 4
                                OR nb1 = 6
                                OR nb1 = 8
                                OR nb1 = 10
                                OR nb1 = 12
                                OR nb1 = 14
                                THEN 2

                                WHEN nb1 = 1
                                OR nb1 = 3
                                OR nb1 = 5
                                OR nb1 = 7
                                OR nb1 = 9
                                OR nb1 = 11
                                OR nb1 = 13
                                THEN 3
                                ELSE 4
                              END
                          ) AS ptype'))
                    ->groupBy("dates")
                    ->groupBy("ptype")
                    ->orderByRaw('counts ASC');

                $m_8 = DB::connection("comm" . $i)->table( DB::raw("({$m_8->toSql()}) as sub") )
                    ->selectRaw("sub.*")
                    ->mergeBindings($i == date('Y') ? $m_8->getQuery() : $m_8)
                    ->groupBy(array("sub.ptype"))
                    ->limit(4)
                    ->get()
                    ->toArray();  // 전체 최소

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
                    if(!empty($temp["p0"]) && $temp["p0"]->counts > $n2[0]["counts"] )
                    {
                        $n2[0]["counts"] = $temp["p0"]->counts;
                        $n2[0]["date"] = $temp["p0"]->dates;
                    }
                }

                if(!empty($m_7)) {
                    $temp=array();
                    foreach ($m_7 as $value)
                        $temp[$value->ptype] = $value;

                    if(!empty($temp["p1"]) && $temp["p1"]->counts > $n3[0]["counts"] )
                    {
                        $n3[0]["counts"] = $temp["p1"]->counts;
                        $n3[0]["date"] = $temp["p1"]->dates;
                    }
                    if(!empty($temp["p2"]) && $temp["p2"]->counts > $n4[0]["counts"] )
                    {
                        $n4[0]["counts"] = $temp["p2"]->counts;
                        $n4[0]["date"] = $temp["p2"]->dates;
                    }
                    if(!empty($temp["p3"]) && $temp["p3"]->counts > $n5[0]["counts"] )
                    {
                        $n5[0]["counts"] = $temp["p3"]->counts;
                        $n5[0]["date"] = $temp["p3"]->dates;
                    }
                    if(!empty($temp["p4"]) && $temp["p4"]->counts > $n6[0]["counts"] )
                    {
                        $n6[0]["counts"] = $temp["p4"]->counts;
                        $n6[0]["date"] = $temp["p4"]->dates;
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
                    if(!empty($temp["p0"]) && $temp["p0"]->counts < $n2[1]["counts"] )
                    {
                        $n2[1]["counts"] = $temp["p0"]->counts;
                        $n2[1]["date"] = $temp["p0"]->dates;
                    }
                }

                if(!empty($m_8)) {
                    $temp=array();
                    foreach ($m_8 as $value)
                        $temp[$value->ptype] = $value;

                    if(!empty($temp["p1"]) && $temp["p1"]->counts < $n3[1]["counts"] )
                    {
                        $n3[1]["counts"] = $temp["p1"]->counts;
                        $n3[1]["date"] = $temp["p1"]->dates;
                    }
                    if(!empty($temp["p2"]) && $temp["p2"]->counts < $n4[1]["counts"] )
                    {
                        $n4[1]["counts"] = $temp["p2"]->counts;
                        $n4[1]["date"] = $temp["p2"]->dates;
                    }
                    if(!empty($temp["p3"]) && $temp["p3"]->counts < $n5[1]["counts"] )
                    {
                        $n5[1]["counts"] = $temp["p3"]->counts;
                        $n5[1]["date"] = $temp["p3"]->dates;
                    }
                    if(!empty($temp["p4"]) && $temp["p4"]->counts < $n6[1]["counts"] )
                    {
                        $n6[1]["counts"] = $temp["p4"]->counts;
                        $n6[1]["date"] = $temp["p4"]->dates;
                    }
                }

            }

            echo  json_encode(array("status"=>1,"result"=>array(    $po,
                $pe,
                $no,
                $ne,
                $n3,
                $n2,
                $n1,
                $n4,
                $n5,
                $n6
            )));
            return;
        }

        echo json_encode(array("status"=>0,"result"=>array()));
    }

    public function getRoundBox(Request $request){
        $alias = array();
        $alias["left_right"]["LEFT"]=array("sp-odd","좌");
        $alias["left_right"]["RIGHT"]=array("sp-even","우");

        $alias["three_four"]["_3"]=array("sp-odd","3");
        $alias["three_four"]["_4"]=array("sp-even","4");

        $alias["odd_even"]["odd"]=array("sp-odd","홀");
        $alias["odd_even"]["even"]=array("sp-even","짝");

        $alias["total"]["LEFT3EVEN"]=array("sp-odd1","좌3");
        $alias["total"]["LEFT4ODD"]=array("sp-odd2","좌4");
        $alias["total"]["RIGHT3ODD"]=array("sp-odd3","우3");
        $alias["total"]["RIGHT4EVEN"]=array("sp-odd4","우4");

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
            $powerball_list_to = $powerball_list_to->select(DB::raw("pb_result_powerball.nb1 as `res`"),DB::raw("pb_result_powerball.round as round"),DB::raw("DATE(pb_result_powerball.created_date) as date"))->orderBy("date","DESC")->get()->toArray();
            if(!empty($powerball_list_to)) {
                $powerball_list_to = json_decode(json_encode($powerball_list_to));
                foreach ($powerball_list_to as $value) {
                    $value->res = $this->getTypePower($pb_type,$value->res)[0];
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
            echo json_encode(array("status"=>1,"result"=>array("type"=>$pb_type,"list"=>$result,"max"=>$roundbox,"terms"=>$round_list)));
        }
        else
            echo json_encode(array("status"=>0));
    }

    /* 육매 분석데이터 */
    public function getSixAnalyse(Request $request){
        $from_year = $to_year = 0;
        $from = empty($request->from) ? "" : $request->from;
        $to = empty($request->to) ? "" : $request->to;
        $limit = empty($request->limit) ? "" : $request->limit;
        $type = !empty($request->type) ? $request->type : "left_right";
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
                $powerball_list_to = $powerball_list_to->orderBy("day_round", "ASC")->select(DB::raw("SUBSTR(pb_result_powerball.day_round,5) as `data`"),DB::raw("pb_result_powerball.nb1 as type"));
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
            $powerball_list_to = $powerball_list_to->orderBy("day_round", "DESC")->select(DB::raw("SUBSTR(pb_result_powerball.day_round,5) as `data`"),DB::raw("pb_result_powerball.nb1 as type"));
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

    private function getPatternDataFromArray($lists,$type){
        $day_round = 0;
        $pick_info = "";
        $max_appear = 0;/* 최대 련속 나타날 개수 */
        /* 비였다면 status값을 0으로 돌려 준다.*/
        if(empty($lists))
            return array("status"=>0,"result"=>array());
        else
        {
            $day_round = $lists[0]->day_round;
            $pick_info = $this->getTypePower($type,$lists[0]->nb1);
            $arr_len = strlen($day_round) - 3;
            $previous_list = array(substr($day_round,$arr_len));
            $previous_item = strval($pick_info[0]);
            $previous_alias = $pick_info[1];
            $pung =0;
            $temp_pung = 1;
            $result = array();
            foreach ($lists as $key => $index){
                $day_round = $index->day_round;
                $pick_info = $this->getTypePower($type,$index->nb1);
                if( $key ==0 )
                    continue;
                if($previous_item ==  $pick_info[0]){
                    if($temp_pung > 1 && $temp_pung > $pung)
                        $pung = $temp_pung;
                    $temp_pung = 0;
                    array_push($previous_list,substr($day_round,$arr_len));
                    if($key == sizeof($lists)-1)
                    {
                        array_push($result,array("alias"=>$pick_info[1],"type"=>$pick_info[0],"list"=>$previous_list));
                        if(sizeof($previous_list) > $max_appear)
                            $max_appear = sizeof($previous_list);
                    }
                }
                if($previous_item !=  $pick_info[0])
                {
                    $temp_pung++;
                    array_push($result,array("alias"=>$previous_alias,"type"=>$previous_item,"list"=>$previous_list));
                    if(sizeof($previous_list) > $max_appear)
                        $max_appear = sizeof($previous_list);
                    $previous_list= array(substr($day_round,$arr_len));
                    $previous_item =  $pick_info[0];
                    $previous_alias =  $pick_info[1];
                    if($key == sizeof($lists)-1)
                    {
                        array_push($result,array("alias"=>$pick_info[1],"type"=>$pick_info[0],"list"=>$previous_list));
                    }
                }
            }
            return array("status"=>1,"result"=>array("max"=>$max_appear,"list"=>$result,"type"=>$type,"pung"=>$pung));
        }
    }

    /*  파워볼 전체 분석 데이터  */
    public function analyseDate(Request $request)
    {
        $pick = "";
        $total = array();
        $left_right = $three_four = $odd_even = $total_lines = "";
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
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb1 ORDER BY day_round DESC  SEPARATOR ',') as `list`"));
                $powerball_list_to = $powerball_list_to->groupBy("group")->get()->toArray();

                if (!empty($powerball_list_to[0])) {
                    if(!empty($pick))
                        $pick .=",";
                    if($i != date('Y'))
                        $pick .=  $powerball_list_to[0]->list;
                    else
                        $pick .= $powerball_list_to[0]["list"];
                }
            }
            $total = array( "list"=>$pick);
        }
        elseif ($limit !=""){
            $powerball_list_to = new Pb_Result_Powerball;
            if(!empty($round))
                $powerball_list_to = $powerball_list_to->where("round", $round);
            $powerball_list_to = $powerball_list_to->orderBy("day_round", "DESC");
            $powerball_list_to = $powerball_list_to->select(
                DB::raw("GROUP_CONCAT(pb_result_powerball.nb1 ORDER BY day_round DESC SEPARATOR ',' ) as `list`"));

            $powerball_list_to = $powerball_list_to->limit($limit)->groupBy("group")->get()->toArray();
            $total["list"] = !empty($powerball_list_to[0]) ? $powerball_list_to[0]["list"] : array();
        }

        if(empty($total))
        {
            echo json_encode(array("status"=>0,"result"=>array()));
            return;
        }

        if(!empty($total["list"])){
            $a1 = $a2 = $a3 = $a4 = array();
            $split = explode(",",$total["list"]);
            foreach($split as $value){
                if(!empty($value)){
                    array_push($a1,$this->getTypePower("left_right",$value)[0]);
                    array_push($a2,$this->getTypePower("three_four",$value)[0]);
                    array_push($a3,$this->getTypePower("odd_even",$value)[0]);
                    array_push($a4,$this->getTypePower("total",$value)[0]);
                }
            }

            $total["left_right"] = $limit !="" ? array_chunk($a1,$limit)[0] : $a1;
            $total["three_four"] = $limit !="" ? array_chunk($a2,$limit)[0] : $a2;
            $total["odd_even"] = $limit !="" ? array_chunk($a3,$limit)[0] : $a3;
            $total["total_lines"] = $limit !="" ? array_chunk($a4,$limit)[0] : $a4;
        }

        $left_right_max=$odd_even_max=$three_four_max=$total_lines_max = $left_right_count = $three_four_count = $odd_even_count = $total_lines_count  = array(0,0);
        if(!empty($total["left_right"])){
            $left_right_max = $this->getMax($total["left_right"],"left_right");
            $left_right_count = array_count_values($total["left_right"]);
        }

        if(!empty($total["three_four"])){
            $three_four_max = $this->getMax($total["three_four"],"three_four");
            $three_four_count = array_count_values($total["three_four"]);
        }

        if(!empty($total["odd_even"])){
            $odd_even_max = $this->getMax($total["odd_even"],"odd_even");
            $odd_even_count = array_count_values($total["odd_even"]);
        }


        if(!empty($total["total_lines"])){
            $total_lines_max = $this->getMax($total["total_lines"],"total_lines");
            $total_lines_count = array_count_values($total["total_lines"]);
        }

        echo json_encode(   array(  "status"=>1,
            "result"=>array(    "left_right" => array("max"=>$left_right_max,"count"=>$left_right_count),
                "three_four" => array("max"=>$three_four_max,"count"=>$three_four_count),
                "odd_even" => array("max"=>$odd_even_max,"count"=>$odd_even_count),
                "total_lines" => array("max"=>$total_lines_max,"count"=>$total_lines_count)
            )));

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
                    DB::raw("GROUP_CONCAT(pb_result_powerball.nb1 ORDER BY day_round DESC  SEPARATOR ',') as `list`"),
                    DB::raw("DATE(pb_result_powerball.created_date) as `dates`"));
                $powerball_list_to = $powerball_list_to->orderBy("dates","DESC")->groupBy("dates")->get()->toArray();

                if(!empty($powerball_list_to)){
                    foreach($powerball_list_to as $value){
                        $temp = array();
                        $lr_count=$lr_max= array("LEFT"=>0,"RIGHT"=>0);
                        $tf_count=$tf_max= array("_3"=>0,"_4"=>0);
                        $oe_count=$oe_max= array("odd"=>0,"even"=>0);
                        $total_count=$total_max = array("LEFT3EVEN"=>0,"LEFT4ODD"=>0,"RIGHT3ODD"=>0,"RIGHT4EVEN"=>0);
                        $dates =  "";
                        $lr  = $tf = $oe = $totals = array();
                        $tem = "";
                        if($i == date('Y'))
                        {
                            $tem = $value["list"];
                            $dates = $value["dates"];
                        }

                        else{
                            $tem = $value->list;
                            $dates = $value->dates;
                        }

                        if(!empty($tem)){
                            $tem = explode(",",$tem);
                            foreach($tem as $value){
                                array_push($lr,$this->getTypePower("left_right",$value)[0]);
                                array_push($tf,$this->getTypePower("three_four",$value)[0]);
                                array_push($oe,$this->getTypePower("odd_even",$value)[0]);
                                array_push($totals,$this->getTypePower("total",$value)[0]);
                            }
                        }

                        if(!empty($lr))
                        {
                            $lr_max = $this->getMax($lr,"left_right");
                            $lr_count = array_count_values($lr);
                        }

                        if(!empty($tf))
                        {
                            $tf_max = $this->getMax($tf,"three_four");
                            $tf_count = array_count_values($tf);
                        }
                        if(!empty($oe))
                        {
                            $oe_max = $this->getMax($oe,"odd_even");
                            $oe_count = array_count_values($oe);
                        }
                        if(!empty($totals))
                        {
                            $total_max = $this->getMax($totals,"total_lines");
                            $total_count = array_count_values($totals);
                        }

                        array_push($result,array(
                            "lr" => array("max"=>$lr_max,"count"=>$lr_count),
                            "tf" => array("max"=>$tf_max,"count"=>$tf_count),
                            "oe" => array("max"=>$oe_max,"count"=>$oe_count),
                            "total" => array("max"=>$total_max,"count"=>$total_count),
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

    public function checkedPattern(Request $request){
        $type_list = array("left_right","three_four","odd_even","total");
        $result = array();
        $limit = empty($request->limit) ? 10 : $request->limit;
        $types = empty($request->types ) ? "odd_even": $request->types;
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
                $search_item = array();
                $arr_len = strlen($value["day_round"]) - 3;
                $search_item["round"] = substr($value["day_round"],$arr_len);
                $search_item["day_round"] = $value["day_round"];
                $temp = $this->getTypePower($types,$value["nb1"]);
                if($temp[0] == "LEFT" || $temp[0] == "odd" || $temp[0] == "_3")
                    $search_item["class"] = "sp-odd";
                else if($temp[0] == "RIGHT" || $temp[0] == "even" || $temp[0] == "_4")
                    $search_item["class"] = "sp-even";
                else {
                    $search_item["class"] = $temp[0];
                    if($temp[0] == "LEFT3EVEN")
                        $temp[1] = "짝";
                    if($temp[0] == "LEFT4ODD")
                        $temp[1] = "홀";
                    if($temp[0] == "RIGHT3ODD")
                        $temp[1] = "홀";
                    if($temp[0] == "RIGHT4EVEN")
                        $temp[1] = "짝";
                }
                if($temp[0] == "_3" || $temp[0] == "LEFT" || $temp[0] == "odd" || $temp[0] == "LEFT4ODD")
                    $temp[0] = 1;
                if($temp[0] == "_4" || $temp[0] == "RIGHT" || $temp[0] == "even")
                    $temp[0] = 0;
                if($temp[0] == "RIGHT3ODD")
                    $temp[0] = 2;
                if($temp[0] == "LEFT3EVEN")
                    $temp[0] = 3;
                if($temp[0] == "RIGHT4EVEN")
                    $temp[0] = 4;
                $search_item["code"] = $temp[0];
                $search_item["alias"] = $temp[1];
                array_push($result,$search_item);
            }
            echo json_encode(array("status"=>1,"result"=>$result));
        }
        else
            echo json_encode(array("status"=>0,"result"=>array()));
    }

    public function patternLists(Request $request){
        $type_list = array("left_right","three_four","odd_even","total");
        $type = empty($request->type) ? "odd_even" : $request->type;
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



            if($type == "left_right"){
                $patternByDate = $pattern_model->select(
                    DB::raw("GROUP_CONCAT(CASE
                            WHEN
                            nb1 = 1
                            OR nb1 = 3
                            OR nb1 = 5
                            OR nb1 = 7
                            OR nb1 = 9
                            OR nb1 = 11
                            OR nb1 = 13
                            OR nb1 = 15
                            OR nb1 = 17
                            OR nb1 = 19
                            OR nb1 = 21
                            OR nb1 = 23
                            OR nb1 = 25
                            OR nb1 = 27
                            THEN 1
                            ELSE 0
                          END ORDER BY day_round ASC SEPARATOR '') as plist"),
                    DB::raw("created_date")
                );
            }
            else if($type == "three_four"){
                $patternByDate = $pattern_model->select(
                    DB::raw("GROUP_CONCAT(
                        CASE
                            WHEN nb1 > 0
                            AND nb1 < 15
                                THEN 1
                                ELSE 0
                        END ORDER BY day_round ASC SEPARATOR '') as plist"),
                    DB::raw("created_date")
                );
            }
            else if($type == "odd_even"){
                $patternByDate = $pattern_model->select(
                    DB::raw("GROUP_CONCAT(CASE
                                    WHEN nb1 = 2
                                    OR nb1 = 4
                                    OR nb1 = 6
                                    OR nb1 = 8
                                    OR nb1 = 10
                                    OR nb1 = 12
                                    OR nb1 = 14
                                    OR nb1 = 15
                                    OR nb1 = 17
                                    OR nb1 = 19
                                    OR nb1 = 21
                                    OR nb1 = 23
                                    OR nb1 = 25
                                    OR nb1 = 27
                                    THEN 1
                                    ELSE 0
                                  END ORDER BY day_round ASC SEPARATOR '') as plist"),
                    DB::raw("created_date")
                );
            }
            else{
                $patternByDate = $pattern_model->select(
                    DB::raw("GROUP_CONCAT(
                                CASE
                                WHEN nb1 = 15
                                OR nb1 = 17
                                OR nb1 = 19
                                OR nb1 = 21
                                OR nb1 = 23
                                OR nb1 = 25
                                OR nb1 = 27
                                THEN 1

                            WHEN nb1 = 2
                                OR nb1 = 4
                                OR nb1 = 6
                                OR nb1 = 8
                                OR nb1 = 10
                                OR nb1 = 12
                                OR nb1 = 14
                                THEN 2

                                WHEN nb1 = 1
                                OR nb1 = 3
                                OR nb1 = 5
                                OR nb1 = 7
                                OR nb1 = 9
                                OR nb1 = 11
                                OR nb1 = 13
                                THEN 3
                                ELSE 4
                              END ORDER BY day_round ASC SEPARATOR '') as plist"),
                    DB::raw("created_date")
                );
            }

                $patternByDate = $patternByDate->whereDate("created_date","<=",$from)
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

     private function getTypePower($type,$num){
         if(!is_numeric($num))
             $num = intval($num);
         $num = intval($num);
         switch ($type){
             case "left_right":
                 if(in_array($num,array(1,3,5,7,9,11,13,15,17,19,21,23,25,27)))
                     return array("LEFT","좌");
                 else
                     return array("RIGHT","우");
                 break;
             case "three_four":
                 if(in_array($num,array(1,2,3,4,5,6,7,8,9,10,11,12,13,14)))
                     return array("_3","3");
                 else
                     return array("_4","4");
                 break;
             case "odd_even":
                 if(in_array($num,array(15,17,19,21,23,25,27,2,4,6,8,10,12,14)))
                     return array("odd","홀");
                 else
                     return array("even","짝");
                 break;
             case "total":
                 if(in_array($num,array(1,3,5,7,9,11,13)))
                     return array("LEFT3EVEN","좌3짝");
                 else if(in_array($num,array(15,17,19,21,23,25,27))){
                     return array("LEFT4ODD","좌4홀");
                 }
                 else if(in_array($num,array(2,4,6,8,10,12,14))){
                     return array("RIGHT3ODD","우3홀");
                 }
                 else{
                     return array("RIGHT4EVEN","우4짝");
                 }
                 break;
             default:
                 if(in_array($num,array(1,3,5,7,9,11,13,15,17,19,21,23,25,27)))
                     return array("LEFT","좌");
                 else
                     return array("RIGHT","우");
                 break;
         }
    }

    /*  파워볼 연속 데이터 최대값 얻는 모듈  $type=1이면 홀짝,언오버 통계 2이면 대중소 통계*/
    private function getMax($arrayList,$type)
    {
        if($type == "total_lines"){
            $max["LEFT3EVEN"] = $max["LEFT4ODD"] = $max["RIGHT3ODD"] = $max["RIGHT4EVEN"] = 0;
            $temp["LEFT3EVEN"] = $temp["LEFT4ODD"] =$temp["RIGHT3ODD"] = $temp["RIGHT4EVEN"] = 0;
        }

        if($type  == "left_right")
        {
            $max["LEFT"] = $max["RIGHT"] = 0;
            $temp["LEFT"] = $temp["RIGHT"] = 0;
        }

        if($type == "three_four"){
            $max["_3"] = $max["_4"] = 0;
            $temp["_3"] = $temp["_4"] = 0;
        }

        if($type == "odd_even"){
            $max["odd"] = $max["even"] = 0;
            $temp["odd"] = $temp["even"] = 0;
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
            foreach ($powerball_list as $key => $value){
                 $temp = (object)array();
                 $temp->start = $this->getTypePower("left_right",$value->nb1)[0];
                 $temp->startlines = $this->getTypePower("three_four",$value->nb1)[0];
                 $temp->startoe = $this->getTypePower("odd_even",$value->nb1)[0];
                 $powerball_list[$key]->sadari = $temp;
            }
            echo json_encode(array("status" => 1, "result" => $powerball_list));
        }
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

    public function psadariLive(Request  $request){
        $last_round = Pb_Result_Powerball::orderBy("day_round","DESC")->first();
        $last_round = !empty($last_round) ? $last_round["round"] : 0;
        $powerball_result = Pb_Result_Powerball::orderBy("day_round","DESC")->limit(288)->get()->toArray();
        return view('pick.psadari_live', [
                "js" =>"",
                "css" => "",
                "last"=>$last_round,
                "psadari_result" =>$powerball_result
            ]
        );
    }
}
