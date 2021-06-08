<?php

namespace App\Http\Controllers;

use App\Models\CodeDetail;
use App\Models\LoginLog;
use App\Models\PbAuth;
use App\Models\PbBank;
use App\Models\PbBettingCtl;
use App\Models\PbDeposit;
use App\Models\PbInbox;
use App\Models\PbItemUse;
use App\Models\PbMoneyReturn;
use App\Models\PbPresent;
use App\Models\PbPurItem;
use App\Models\PbRoom;
use App\Models\PbLog;
use App\Models\PbMarket;
use App\Models\PbWinGift;
use App\Models\PbWinner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Hash;
use Image;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MemberController extends SecondController
{
    //
    public function index(Request $request){

        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.')</script>";
            return;
        }
        $userId= $this->user->userId;
        $user = User::with(["item"])->where("pb_users.userId",$userId)->first();
        $avata = CodeDetail::where("class","0020")->where("code",$user->level)->first();
        $avata = empty($avata["value3"]) ? "": $avata["value3"];
        $type = empty($request->type) ? "mine" : $request->type;
        $item_count = array();
        foreach($user->item->toArray() as $index){
            $item_count[$index["market_id"]] = $index["count"];
        }
        switch ($type){
            case "mine";
                return view('member/powerball-mypage', [   "js" => "mine.js",
                                                                "css" => "member.css",
                                                                "user" => $user,
                                                                "avata"=>$avata,
                                                                "item_count" => $item_count,
                                                                "api_token"=>$user["api_token"]
                    ]
                );
                break;
            case "item";
                $item = new PbPurItem();
                $pur_item = $item->with('items')
                    ->where("pb_pur_item.userId",$user->userId)
                    ->where("pb_pur_item.count" , ">",0)->get();
                return view('member/powerball-item', [     "js" => "market.js",
                                                                "css" => "member.css",
                                                                "pur_item"=>$pur_item,
                                                                "api_token"=>$user->api_token
                    ]
                );
                break;
            case "itemLog";
                $item = PbLog::where("userId",$userId)->where("type",2)->orderBy("created_at","DESC")->paginate(10)->appends(request()->query());
                $count = PbLog::where("userId",$userId)->where("type",2)->get()->count();
                return view('member/powerball-itemLog', [      "js" => "",
                                                                    "css" => "member.css",
                                                                    "item"=>$item,
                                                                    "count"=>$count
                    ]
                );
                break;
            case "itemTerm";
                $item = PbItemUse::where("terms2",">",date("Y-m-d H;i:s"))->where("userId",$userId)->orderBy("created_date","DESC")->paginate(10)->appends(request()->query());
                $count = PbItemUse::where("terms2",">",date("Y-m-d H;i:s"))->where("userId",$userId)->get()->count();
                return view('member/powerball-itemTerm', [     "js" => "",
                                                                    "css" => "member.css",
                                                                    "item"=>$item,
                                                                    "count"=>$count
                    ]
                );
                break;
            case "nicknameLog";
                $item = PbLog::where("userId",$userId)->where("type",3)->orderBy("created_at","DESC")->paginate(10)->appends(request()->query());
                $count = PbLog::where("userId",$userId)->where("type",3)->get()->count();
                return view('member/powerball-nicknameLog', [
                        "js" => "",
                        "css" => "member.css",
                        "item"=>$item,
                        "count"=>$count
                    ]
                );
                break;
            case "giftLog";
                $giftType = $request->get("giftType") ?? "give";
                $self = "received_usr";
                $alias = "선물 받은 회원";
                if($giftType == "give"){
                    $item = PbLog
                        ::with(["received_usr","send_usr"])
                        ->where("type",4)
                        ->where("fromId",$userId)
                        ->orderBy("created_at","DESC")->paginate(10)->appends(request()->query());
                    $count = PbLog
                        ::where("type",4)
                        ->where("fromId",$userId)->get()->count();
                }
                else{
                    $item = PbLog
                        ::with(["received_usr","send_usr"])
                        ->where("type",4)
                        ->where("toId",$userId)
                        ->orderBy("created_at","DESC")->paginate(10)->appends(request()->query());
                    $count = PbLog
                        ::where("type",4)
                        ->where("toId",$userId)->get()->count();
                    $self = "send_usr";
                    $alias = "선물한 회원";
                }

                return view('member/powerball-giftLog', [
                        "js" => "",
                        "css" => "member.css",
                        "item"=>$item,
                        "count"=>$count,
                        "self"=>$self,
                        "alias"=>$alias
                    ]
                );
                break;
            case "chargeLog";
                $item = PbDeposit::where("userId",$userId)->where("type",1)->orderBy("created_at","DESC")->paginate(10)->appends(request()->query());
                $count = PbDeposit::where("userId",$userId)->where("type",1)->get()->count();
                return view('member/powerball-chargeLog', [
                        "js" => "",
                        "css" => "member.css",
                        "item"=>$item,
                        "count"=>$count
                    ]
                );
                break;
            case "exchange";
                $pb_bank = PbBank::where("status",1)->get()->toArray();
                $exchs = PbMoneyReturn::with("user")->where("userId",$this->user->userId)->orderBy("created_at","DESC")->paginate(10)->appends(request()->query());
                return view('member/powerball-exchange', [
                        "js" => "member.js",
                        "css" => "member.css",
                        "bank"=>$pb_bank,
                        "exchs"=>$exchs
                    ]
                );
                break;
            case "level";
                $user_exp = $user->exp;
                $user_level = $user->level;
                $level_list = CodeDetail::where("class","0020")->where("usetype","Y")->where("status","Y")->orderBy("code","ASC")->get()->toArray();
                $items = PbLog::where("userId",$userId)->where("type",1)->orderBy("created_at","DESC")->paginate(10)->appends(request()->query());
                $count = PbLog::where("userId",$userId)->where("type",1)->get()->count();
                return view('member/powerball-level', [    "js" => "member.js",
                                                                "css" => "member.css",
                                                                "user_exp"=>$user_exp,
                                                                "user_level" =>$user_level,
                                                                "level_list" =>$level_list,
                                                                "items"=>$items,
                                                                "count"=>$count
                    ]
                );
                break;
            case "loginLog";
                $loginlog = LoginLog::where("userId",$this->user->userId)->orderBy("created_at","DESC")->paginate(10)->appends(request()->query());
                return view('member/powerball-accesslog', [    "js" => "",
                                                                    "css" => "member.css",
                                                                    "loginlog"=>$loginlog
                    ]
                );
                break;
            case "charge";
                return view('member/powerball-charge', [    "js" => "coin.js",
                        "css" => "market.css"
                    ]
                );
                break;
            case "withdraw";
                return view('member/powerball-withdraw', [
                        "js" => "",
                        "css" => "member.css",
                        "nickname"=>$this->user->nickname,
                        "api_token"=>$this->user->api_token
                    ]
                );
                break;
            default:
                echo "<script>alert('잘못된 접속입니다.')</script>";
                return;
        }
    }

    public function setMute(Request $request){
        $roomIdx = $request->roomIdx;
        $tuseridKey = $request->tuseridKey;
        $user = $this->user;
        $cmd = $request->cmd;
        $pb_room = PbRoom::where("roomIdx",$roomIdx)->first();
        if(empty($pb_room)){
            echo json_encode(array("status"=>0,"msg"=>"방이 비었습니다."));
            return;
        }
        $mute =$pb_room["mute"];
        $mute_split = explode(",",$pb_room["mute"]);
        $manager  = $pb_room["manager"];
        $manager_split = explode(",",$manager);
        if($user->userIdKey != $pb_room["super"] && !in_array($user->userIdKey,$manager_split)){
            echo json_encode(array("status"=>0,"msg"=>"권한이 없습니다."));
            return;
        }

        if(!empty($mute) && in_array($tuseridKey,$mute_split) && $cmd == "muteOn"){
            echo json_encode(array("status"=>0,"msg"=>"이미 벙어리상태입니다."));
            return;
        }

        if(!empty($mute) && !in_array($tuseridKey,$mute_split) && $cmd == "muteOff"){
            echo json_encode(array("status"=>0,"msg"=>"벙어리상태의 회원이 아닙니다."));
            return;
        }

        if(empty($mute))
            $mute = array();
        else
            $mute = explode(",",$mute);

        if($cmd == "muteOn")
            array_push($mute,$tuseridKey);
        else
            if (($key = array_search($tuseridKey,$mute)) !== false) {
                unset($mute[$key]);
            }

        PbRoom::where("id",$pb_room["id"])->update(["mute"=>implode(",",$mute)]);

        echo json_encode(array("status"=>1));
    }

    public function kickUser(Request $request){
        $roomIdx = $request->roomIdx;
        $tuseridKey = $request->tuseridKey;
        $user = $this->user;
        $cmd = $request->cmd;
        $pb_room = PbRoom::where("roomIdx",$roomIdx)->first();
        if(empty($pb_room)){
            echo json_encode(array("status"=>0,"msg"=>"방이 비었습니다."));
            return;
        }
        $blocked =$pb_room["blocked"];
        $manager  = $pb_room["manager"];
        $manager_split  = explode(",",$manager);
        if($user->userIdKey != $pb_room["super"] && !in_array($user->userIdKey,$manager_split)){
            echo json_encode(array("status"=>0,"msg"=>"권한이 없습니다."));
            return;
        }

        if(empty($mute))
            $blocked = array();
        else
            $blocked = explode(",",$blocked);

        array_push($blocked,$tuseridKey);

        PbRoom::where("id",$pb_room["id"])->update(["blocked"=>implode(",",$blocked)]);

        echo json_encode(array("status"=>1));
    }

    public function updateManage(Request $request){
        $roomIdx = $request->roomIdx;
        $tuseridKey = $request->tuseridKey;
        $user = $this->user;
        $cmd = $request->cmd;
        $pb_room = PbRoom::where("roomIdx",$roomIdx)->first();
        if(empty($pb_room)){
            echo json_encode(array("status"=>0,"msg"=>"방이 비었습니다."));
            return;
        }
        $manager  = $pb_room["manager"];
        $manager_split = explode(",",$manager);
        if($user->userIdKey != $pb_room["super"]){
            echo json_encode(array("status"=>0,"msg"=>"권한이 없습니다."));
            return;
        }
        if(!empty($manager) && in_array($tuseridKey,$manager_split) && $cmd == "managerOn"){
            echo json_encode(array("status"=>0,"msg"=>"이미 매니저입니다."));
            return;
        }
        if(!in_array($tuseridKey,$manager_split) && $cmd == "managerOff"){
            echo json_encode(array("status"=>0,"msg"=>"이 회원은 매니저가 아닙니다."));
            return;
        }
        if(empty($manager))
            $manager = array();
        else
            $manager = explode(",",$manager);
        if($cmd == "managerOn")
            array_push($manager,$tuseridKey);
        else
            if (($key = array_search($tuseridKey,$manager)) !== false)
                unset($manager[$key]);
        PbRoom::where("id",$pb_room["id"])->update(["manager"=>implode(",",$manager)]);
        echo json_encode(array("status"=>1));
    }

    public function updateFixManage(Request $request){
        $roomIdx = $request->roomIdx;
        $tuseridKey = $request->tuseridKey;
        $user = $this->user;
        $cmd = $request->cmd;
        $pb_room = PbRoom::with("roomandpicture")->where("roomIdx",$roomIdx)->first();
        if(empty($pb_room)){
            echo json_encode(array("status"=>0,"msg"=>"방이 비었습니다."));
            return;
        }

        if($user->userIdKey != $pb_room["super"]){
            echo json_encode(array("status"=>0,"msg"=>"권한이 없습니다."));
            return;
        }

        $item_use = PbItemUse::where("userId",$user->userId)
            ->where("terms1","<=",date("Y-m-d H:i:s"))
            ->where("terms2",">=",date("Y-m-d H:i:s"))
            ->where("market_id","FIXED_MEMBERSHIP_TICKET")
            ->first();

        if(empty($item_use)){
            echo json_encode(array("status"=>0,"msg"=>"고정멤버를 관리하려면 [고정멤버이용권] 아이템이 필요합니다."));
            return;
        }
        if(!empty($pb_room["roomandpicture"]) && !empty($pb_room["roomandpicture"]["fixed"]))
            $fixed_list = explode(",",$pb_room["roomandpicture"]["fixed"]);
        else
            $fixed_list = array();

        if(in_array($tuseridKey,$fixed_list) && $cmd == "fixMemberOn"){
            echo json_encode(array("status"=>0,"msg"=>"이미 고정멤버회원입니다."));
            return;
        }
        if(!in_array($tuseridKey,$fixed_list) && $cmd == "fixMemberOff"){
            echo json_encode(array("status"=>0,"msg"=>"이미 고정멤버회원이 아닙니다."));
            return;
        }

        if($cmd == "fixMemberOn")
            array_push($fixed_list,$tuseridKey);
        else
            if (($key = array_search($tuseridKey, $fixed_list)) !== false)
                unset($fixed_list[$key]);
        User::find($pb_room["userId"])->update(["fixed"=>implode(",",$fixed_list)]);
        echo json_encode(array("status"=>1));
    }

    public function bettingResultLayer(Request $request){
        $history = array();
        $history["totalWinClass"] = "";
        $history["totalWinFix"] = 0;
        $history["powerballOddEvenWinClass"] = "";
        $history["powerballOddEvenWinFix"] = 0;
        $history["powerballOddEvenWin"] = 0;
        $history["powerballOddEvenLose"] = 0;
        $history["powerballOddEvenRate"] = 0;

        $history["powerballUnderOverWinClass"] = "";
        $history["powerballUnderOverWinFix"] = 0;
        $history["powerballUnderOverWin"] = 0;
        $history["powerballUnderOverLose"] = 0;
        $history["powerballUnderOverRate"] = 0;

        $history["numberOddEvenWinClass"] = "";
        $history["numberOddEvenWinFix"] = 0;
        $history["numberOddEvenWin"] = 0;
        $history["numberOddEvenLose"] = 0;
        $history["numberOddEvenRate"] = 0;

        $history["numberUnderOverWinClass"] = "";
        $history["numberUnderOverWinFix"] = 0;
        $history["numberUnderOverWin"] = 0;
        $history["numberUnderOverLose"] = 0;
        $history["numberUnderOverRate"] = 0;

        $history["numberPeriodWinClass"] = "";
        $history["numberPeriodWinFix"] = 0;
        $history["numberPeriodWin"] = 0;
        $history["numberPeriodLose"] = 0;
        $history["numberPeriodRate"] = 0;

        $user = User::where("userIdKey",$request->useridKey)->first();
        if(empty($user)){
            echo json_encode(array("status"=>0));
            return;
        }
        if(!empty($user["winning_history"])){
            $data = json_decode($user["winning_history"]);
            $history["totalWinFix"] = $data->current_win->p;
            $history["powerballOddEvenWinFix"] = $data->pb_oe->current_win;
            $history["powerballOddEvenWin"] = $data->pb_oe->win;
            $history["powerballOddEvenLose"] = $data->pb_oe->lose;

            if($data->pb_oe->win ==0 && $data->pb_oe->lose ==0){
                $history["powerballOddEvenRate"] = 0;
            }
            else{
                $history["powerballOddEvenRate"] = number_format(100* ($data->pb_oe->win / ($data->pb_oe->win + $data->pb_oe->lose)))."%";
            }

            $history["powerballUnderOverWinFix"] = $data->pb_uo->current_win;
            $history["powerballUnderOverWin"] = $data->pb_uo->win;
            $history["powerballUnderOverLose"] = $data->pb_uo->lose;

            if($data->pb_uo->win ==0 && $data->pb_uo->lose ==0){
                $history["powerballUnderOverRate"] = 0;
            }
            else{
                $history["powerballUnderOverRate"] = number_format(100* ($data->pb_uo->win / ($data->pb_uo->win + $data->pb_uo->lose)))."%";
            }

            $history["numberOddEvenWinFix"] = $data->nb_oe->current_win;
            $history["numberOddEvenWin"] = $data->nb_oe->win;
            $history["numberOddEvenLose"] = $data->nb_oe->lose;

            if($data->nb_oe->win ==0 && $data->nb_oe->lose ==0){
                $history["numberOddEvenRate"] = 0;
            }
            else{
                $history["numberOddEvenRate"] = number_format(100* ($data->nb_oe->win / ($data->nb_oe->win + $data->nb_oe->lose)))."%";
            }

            $history["numberUnderOverWinFix"] = $data->nb_uo->current_win;
            $history["numberUnderOverWin"] = $data->nb_uo->win;
            $history["numberUnderOverLose"] = $data->nb_uo->lose;

            if($data->nb_uo->win ==0 && $data->nb_uo->lose ==0){
                $history["numberUnderOverRate"] = 0;
            }
            else{
                $history["numberUnderOverRate"] = number_format(100* ($data->nb_uo->win / ($data->nb_uo->win + $data->nb_uo->lose)))."%";
            }

            $history["numberPeriodWinFix"] = $data->nb_size->current_win;
            $history["numberPeriodWin"] = $data->nb_size->win;
            $history["numberPeriodLose"] = $data->nb_size->lose;

            if($data->nb_size->win ==0 && $data->nb_size->lose ==0){
                $history["numberPeriodRate"] = 0;
            }
            else{
                $history["numberPeriodRate"] = number_format(100* ($data->nb_size->win / ($data->nb_size->win + $data->nb_size->lose)))."%";
            }
        }
        echo json_encode(array("status"=>1,"result"=>$history));
    }

    public function modify(Request $request){

        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.')</script>";
            return;
        }
        $user = $this->user;
        $type = $request->type ?? "nickname";
        switch ($type) {
            case 'nickname':
                return view('member/nickname-changes', [    "js" => "modify.js",
                                                            "css" => "modify.css",
                                                            "user"=>$user]);
                break;
            case 'family':
                return view('member/family-change', [    "js" => "modify.js",
                                                            "css" => "modify.css",
                                                            "user"=>$user]);
                break;
            case 'today':
                return view('member/today-change', [    "js" => "modify.js",
                                                            "css" => "modify.css",
                                                            "user"=>$user]);
                break;
            case 'profile-img':
                return view('member/profile-change', [    "js" => "modify.js",
                                                            "css" => "modify.css",
                                                            "user"=>$user]);
                break;

            default:
                # code...
                break;
        }
    }

    public function umodify(Request $request){
        $type = $request->type ?? "";
        $userId= $this->user->userId;

        $user = User::with(["item"])->where("userId",$userId)->first();
        echo json_encode($user);
        return;
        $item_count = array();
        foreach($user->item as $index){
            $item_count[$index["market_id"]] = $index["count"];
        }
        switch ($type) {
            case 'nickname':
                $nickname = $request->nickname;
                $pur_item = PbMarket::where("code","NICKNAME_RIGHT")->first();
                if(empty($item_count["NICKNAME_RIGHT"]) || empty($pur_item)){
                    echo json_encode(array("status"=>0,"msg"=>"닉네임을 변경하려면 [닉네임 변경권] 아이템이 필요합니다."));
                }
                else if($nickname == $user["nickname"]){
                    echo json_encode(array("status"=>0,"msg"=>"현재 사용중인 닉네임입니다."));
                }

                else{
                    $exist = User::where("nickname",$nickname)->first();
                    if(!empty($exist)){
                        echo json_encode(array("status"=>0,"msg"=>"현재 사용중인 닉네임입니다."));
                    }
                    else{
                        User::where("userId",$userId)->update(["nickname"=>$nickname]);
                        PbPurItem::where("userId",$userId)->where("market_id","NICKNAME_RIGHT")->update(["count"=>$item_count["NICKNAME_RIGHT"]-1]);
                        PbLog::create([
                            "type"=>2,
                            "content"=>json_encode(array("class"=>"use","use"=>"사용","name"=>$pur_item["name"],"count"=>1,"price"=>$pur_item["price"])),
                            "userId"=>$user->userId,
                            "ip"=>$request->ip()
                        ]);
                        PbLog::create([
                            "type"=>3,
                            "content"=>json_encode(array("old"=>$user["nickname"],"new"=>$nickname,"date"=>date("Y-m-d"))),
                            "userId"=>$user->userId,
                            "ip"=>$request->ip()
                        ]);
                        echo json_encode(array("status"=>1));
                    }
                }
                break;

                case "family":
                    $family = $request->family;
                    $pur_item = PbMarket::where("code","FAMILY_NICKNAME_LICENSE_BREAD")->first();
                    if(empty($item_count["FAMILY_NICKNAME_LICENSE_BREAD"]) || empty($pur_item)){
                        echo json_encode(array("status"=>0,"msg"=>"패밀리닉네임을 사용 또는 변경하려면 [패밀리닉네임 이용권] 아이템이 필요합니다."));
                    }
                    else{
                        $count_limit = strlen(utf8_decode($family));
                        if($count_limit > 4)
                        {
                            echo json_encode(array("status"=>0,"msg"=>"패밀리 닉네임은 4자이하로 가능합니다."));
                        }
                        else{
                            User::where("userId",$userId)->update(["familynickname"=>$family]);
                            PbPurItem::where("userId",$userId)->where("market_id","FAMILY_NICKNAME_LICENSE_BREAD")->update(["count"=>$item_count["FAMILY_NICKNAME_LICENSE_BREAD"]-1]);
                            if($pur_item["period"] != 0){
                                $terms1 = date("Y-m-d H:i:s");
                                $terms2 = date("Y-m-d H:i:s", strtotime($pur_item["period"], strtotime($terms1)));
                                $terms_type = 2;
                                PbItemUse::updateorCreate([
                                    "userId"=>$userId,
                                    "market_id"=>"FAMILY_NICKNAME_LICENSE_BREAD"
                                ],[
                                    "terms2"=>$terms2,
                                    "terms1"=>$terms1,
                                    "terms_type"=>$terms_type
                                ]);
                            }
                            PbLog::create([
                                "type"=>2,
                                "content"=>json_encode(array("class"=>"use","use"=>"사용","name"=>$pur_item["name"],"count"=>1,"price"=>$pur_item["price"])),
                                "userId"=>$user->userId,
                                "ip"=>$request->ip()
                            ]);
                            echo json_encode(array("status"=>1));
                        }
                    }
                    break;
                case "todayMsg":
                    $todayMsg = $request->todayMsg;
                    $pur_item = PbMarket::where("code","WORD_TODAY")->first();
                    if(empty($item_count["WORD_TODAY"]) || empty($pur_item)){
                        echo json_encode(array("status"=>0,"msg"=>"오늘의한마디를 사용 또는 변경하려면 [오늘의한마디 이용권] 아이템이 필요합니다."));
                    }
                    else{
                        User::where("userId",$userId)->update(["today_word"=>$todayMsg]);
                        PbPurItem::where("userId",$userId)->where("market_id","WORD_TODAY")->update(["count"=>$item_count["WORD_TODAY"]-1]);
                        if($pur_item["period"] != 0){
                            $terms1 = date("Y-m-d H:i:s");
                            $terms2 = date("Y-m-d H:i:s", strtotime($pur_item["period"], strtotime($terms1)));
                            $terms_type = 2;
                            PbItemUse::updateorCreate([
                                "userId"=>$userId,
                                "market_id"=>"WORD_TODAY"
                            ],[
                                "terms2"=>$terms2,
                                "terms1"=>$terms1,
                                "terms_type"=>$terms_type
                            ]);
                        }
                        PbLog::create([
                            "type"=>2,
                            "content"=>json_encode(array("class"=>"use","use"=>"사용","name"=>$pur_item["name"],"count"=>1,"price"=>$pur_item["price"])),
                            "userId"=>$user->userId,
                            "ip"=>$request->ip()
                        ]);
                        echo json_encode(array("status"=>1));
                    }
                    break;
                case "family-init":
                    if(empty($user["familynickname"])){
                        echo json_encode(array("status"=>0,"msg"=>"패밀리 닉네임이 존재하지 않습니다."));
                    }
                    else{
                        User::where("userId",$userId)->update(["familynickname"=>""]);
                        echo json_encode(array("status"=>1));
                    }
                    break;

            default:
                echo json_encode(array("status"=>0,"msg"=>"잘못된 요청입니다"));
                break;
        }
    }

    public function imgCheck(Request $request){
        $userId= $this->user->userId;
        $user = User::with(["item"])->where("pb_users.userId",$userId)->first();
        $item_count = array();
        foreach($user->item->toArray() as $index){
            if($index["count"] <=0 ) continue;
            $item_count[$index["market_id"]] = $index["count"];
        }
        $pur_item = PbMarket::where("code","PROFILE_IMAGE_RIGHT")->first();
        if(empty($item_count["PROFILE_IMAGE_RIGHT"]) || empty($pur_item)){
            echo json_encode(array("status"=>0,"msg"=>"프로필이미지를 사용 또는 변경하려면 [프로필이미지 이용권] 아이템이 필요합니다."));
        }
        else
        {
            if($request->post("type") == "delete"){
                $user = User::find($userId);
                $user->image = "/assets/images/mine/profile.png";
                $user->save();
                PbPurItem::where("userId",$user->userId)->where("market_id","PROFILE_IMAGE_RIGHT")->update(["count"=>$item_count["PROFILE_IMAGE_RIGHT"]-1]);
                echo json_encode(array("status"=>2,"msg"=>"초기화되였습니다."));
            }
            else
                echo json_encode(array("status"=>1));
        }

    }

    public function uploadImage(Request $request){
        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.')</script>";
            return;
        }
        $user = $this->user->userId;
        $item_count = array();
        foreach($user->item->toArray() as $index){
            if($index["count"] <=0) continue;
            $item_count[$index["market_id"]] = $index["count"];
        }
        $pur_item = PbMarket::where("code","PROFILE_IMAGE_RIGHT")->first();
        $this->validate($request, [
            'profileImg' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
        ]);

        if(empty($item_count["PROFILE_IMAGE_RIGHT"]) || empty($pur_item) || $item_count["PROFILE_IMAGE_RIGHT"] <=0){
            echo "<script>alert('프로필 이미지 변경 아이템이 없습니다.');window.close()</script>";
            return;
        }

        $input = array();
        $image = $request->file('profileImg');
        $input['imagename'] = $user->userIdKey.'.'.$image->extension();
        $filePath  = public_path('/assets/images/mine/profile');
        $img = Image::make($image->path());
        $img->resize(150, 150, function ($const) {
            $const->aspectRatio();
        })->save($filePath.'/'.$input['imagename']);

        User::where("userId",$user->userId)->update(["image"=>'/assets/images/mine/profile/'.$input['imagename']]);
        PbPurItem::where("userId",$user->userId)->where("market_id","PROFILE_IMAGE_RIGHT")->update(["count"=>$item_count["PROFILE_IMAGE_RIGHT"]-1]);
        PbLog::create([
            "type"=>2,
            "content"=>json_encode(array("class"=>"use","use"=>"사용","name"=>$pur_item["name"],"count"=>1,"price"=>$pur_item["price"])),
            "userId"=>$user->userId,
            "ip"=>$request->ip()
        ]);
        echo "<script>alert('성공적으로 변경하였습니다.');window.close()</script>";

    }

    public function setCharge(Request $request){

        if(!$this->isLogged){
            echo "<script>alert('로그인후 이용가능한 서비스입니다.')</script>";
            return;
        }
        $user = $this->user;
        if($request->chargeType == "deposit"){
            $chargeCoin = $request->chargeCoin ?? 0;
            $chargePrice = $request->chargePrice ?? 0;
            $mobileNum = $request->mobileNum;
            $accountName = $request->accountName;
            $userId = $user->userId;
            $smsYN = $request->smsYN;

            PbDeposit::insert([ "type"=>1,
                                "coin"=>$chargeCoin,
                                "money"=>$chargePrice,
                                "userId"=>$user->userId,
                                "bank_number"=>$accountName,
                                "mobile_number"=>$mobileNum,
                                "accept"=>0,
                                "rec"=>$smsYN

                ]);

            echo "<script>alert('입금요청이 완료되었습니다.');location.href='/member?type=charge'</script>";
            return;
        }
    }

    public function goMemo(Request $request){
        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.close()</script>";
            return;
        }
        $user = $this->user;
        $type = $request->get("type");
        $type = $type ?? "receive";
        $result  = array();
        $result["type"] = $type;
        $result["api_token"] = $user->api_token;
        $result["cur"] = $user->userId;
        switch ($type){
            case "receive":
                $result["list"] = PbInbox::with("send_usr.getLevel")
                    ->where("toId",$user->userId)
                    ->orderBy("created_at","DESC")
                    ->paginate(10);
                $result["menu"] = array("보낸 사람","내용","보낸시간");
                $result["not_read"]=  PbInbox::where("toId",$user->userId)->where("view_date",NULL)->get()->count();
                return view('member/memo',['css'=>"mail.css","js"=>"mail.js","result"=>$result]);
                break;
            case "send":
                $result["list"] = PbInbox::with("received_usr")
                    ->where("fromId",$user->userId)
                    ->orderBy("created_at","DESC")
                    ->paginate(10);
                $result["not_read"]=  PbInbox::where("fromId",$user->userId)->where("view_date",NULL)->get()->count();
                $result["menu"] = array("받은 사람","내용","보낸시간","읽은 시간");
                return view('member/memo1',['css'=>"mail.css","js"=>"mail.js","result"=>$result]);
                break;
            case "write":
                $mail_send_item = PbPurItem::where("market_id","NOTE_ITEM_100")->where("userId",$user->userId)->first();
                $mail_random_send_item = PbPurItem::where("market_id","RANDOM_NOTE")->where("userId",$user->userId)->first();
                $result["send"] = !empty($mail_send_item) ? $mail_send_item["count"] : 0;
                $result["random_send"] = !empty($mail_random_send_item) ? $mail_random_send_item["count"] : 0;
                $result["nickname"] = $request->get("nickname") ?? "";
                return view('member/write',['css'=>"mail.css","js"=>"mail.js","result"=>$result]);
                break;
            case "save":
                $result["list"] = PbInbox::
                    where(function($query) use ($user){
                        $query->where('fromId',$user->userId)
                            ->orWhere('toId',$user->userId);
                    })
                    ->where("state",1)
                    ->orderBy("created_at","DESC")
                    ->paginate(10);
                $result["not_read"]=  PbInbox::where("fromId",$user->userId)
                    ->where(function($query) use ($user){
                        $query->where('fromId',$user->userId)
                            ->orWhere('toId',$user->userId);
                    })
                    ->where("state",1)
                    ->where("view_date",NULL)->get()->count();
                $result["menu"] = array("보낸 사람 / 받는 사람","내용","보낸시간");
                return view('member/memo2',['css'=>"mail.css","js"=>"mail.js","result"=>$result]);
                break;
            case "friendList":
                if(!empty($request->post("nickname"))){
                    $result["list"] = User::where("nickname","like","%".$request->get("nickname")."%")
                        ->where("user_type","01")
                        ->where("isDeleted","0")
                        ->whereIn("userIdKey",explode(",",$user->frd_list))
                        ->paginate(10);
                }
                else if($request->get("searchVal") == "B"){
                    $result["list"] = User::whereIn("userIdKey",explode(",",$user->block_list))
                        ->where("user_type","01")
                        ->where("isDeleted","0")
                        ->paginate(10);
                }
                else if($request->get("searchVal") == "N"){
                    $result["list"] = User::
                        where(DB::raw('SUBSTRING(nickname,1,1)'),">=",'0')
                        ->where(DB::raw('SUBSTRING(nickname,1,1)'),"<=",'9')
                        ->whereIn("userIdKey",explode(",",$user->frd_list))
                        ->where("user_type","01")
                        ->where("isDeleted","0")
                        ->paginate(10);
                }

                else if($request->get("searchVal") == "A"){
                    $result["list"] = User::
                       where(function($query){
                        $query->where(function($query1){
                            $query1->where(DB::raw('SUBSTRING(nickname,1,1)'),">=",'a');
                            $query1->where(DB::raw('SUBSTRING(nickname,1,1)'),"<=",'z');
                        });
                        $query->orwhere(function($query2){
                            $query2->where(DB::raw('SUBSTRING(nickname,1,1)'),">=",'A');
                            $query2->where(DB::raw('SUBSTRING(nickname,1,1)'),"<=",'Z');
                        });
                    })
                        ->where("user_type","01")
                        ->where("isDeleted","0")
                        ->whereIn("userIdKey",explode(",",$user->frd_list))
                        ->paginate(10);
                }

                else if($request->get("searchVal") == "all"){
                    $result["list"] = User::
                        where("user_type","01")
                        ->where("isDeleted","0")
                        ->whereIn("userIdKey",explode(",",$user->frd_list))
                        ->paginate(10);
                }
                else{
                    $init_const = initConst($request->get("searchVal"));
                    $result["list"] = User::
                          where(DB::raw('SUBSTRING(nickname,1,1)'),">=",$init_const[0])
                        ->where(DB::raw('SUBSTRING(nickname,1,1)'),"<=",$init_const[1])
                        ->where("user_type","01")
                        ->where("isDeleted","0")
                        ->whereIn("userIdKey",explode(",",$user->frd_list))
                        ->paginate(10);
                }

                return view('member/friendList',['css'=>"mail.css","js"=>"mail.js","result"=>$result]);
                break;
            case "fixMember":
                if(!empty($request->post("nickname"))){
                    $result["list"] = User::where("nickname","like","%".$request->get("nickname")."%")
                        ->where("user_type","01")
                        ->where("isDeleted","0")
                        ->whereIn("userIdKey",explode(",",$user->fixed))
                        ->paginate(10);
                }
                else if($request->get("searchVal") == "B"){
                    $result["list"] = User::whereIn("userIdKey",explode(",",$user->block_list))
                        ->where("user_type","01")
                        ->where("isDeleted","0")
                        ->paginate(10);
                }
                else if($request->get("searchVal") == "N"){
                    $result["list"] = User::
                    where(DB::raw('SUBSTRING(nickname,1,1)'),">=",'0')
                        ->where(DB::raw('SUBSTRING(nickname,1,1)'),"<=",'9')
                        ->whereIn("userIdKey",explode(",",$user->fixed))
                        ->where("user_type","01")
                        ->where("isDeleted","0")
                        ->paginate(10);
                }

                else if($request->get("searchVal") == "A"){
                    $result["list"] = User::
                    where(function($query){
                        $query->where(function($query1){
                            $query1->where(DB::raw('SUBSTRING(nickname,1,1)'),">=",'a');
                            $query1->where(DB::raw('SUBSTRING(nickname,1,1)'),"<=",'z');
                        });
                        $query->orwhere(function($query2){
                            $query2->where(DB::raw('SUBSTRING(nickname,1,1)'),">=",'A');
                            $query2->where(DB::raw('SUBSTRING(nickname,1,1)'),"<=",'Z');
                        });
                    })
                        ->where("user_type","01")
                        ->where("isDeleted","0")
                        ->whereIn("userIdKey",explode(",",$user->fixed))
                        ->paginate(10);
                }

                else if($request->get("searchVal") == "all"){
                    $result["list"] = User::
                    where("user_type","01")
                        ->where("isDeleted","0")
                        ->whereIn("userIdKey",explode(",",$user->fixed))
                        ->paginate(10);
                }
                else{
                    $init_const = initConst($request->get("searchVal"));
                    $result["list"] = User::
                    where(DB::raw('SUBSTRING(nickname,1,1)'),">=",$init_const[0])
                        ->where(DB::raw('SUBSTRING(nickname,1,1)'),"<=",$init_const[1])
                        ->where("user_type","01")
                        ->where("isDeleted","0")
                        ->whereIn("userIdKey",explode(",",$user->fixed))
                        ->paginate(10);
                }
                return view('member/fixMember',['css'=>"mail.css","js"=>"mail.js","result"=>$result]);
                break;
            case "memoView":
                $mid = $request->post("mid");
                $memo = PbInbox::with(["received_usr.getLevel","send_usr.getLevel"])->where("id",$mid)->first();
                if(empty($memo)){
                    echo "쪽지가 없습니다.";
                }
                $result["memo"] = $memo;
                $result["mtype"] = $request->get("mtype");
                if($request["mtype"] == "receive" && $user->userId == $memo["toId"]){
                    PbInbox::where("id",$memo["id"])->update(["view_date"=>date("Y-m-d H:i:s")]);
                }
                if($result["mtype"] == "receive")
                {
                    $previous = PbInbox::where('id', '<', $mid)->where("toId",$user->userId)->max('id');
                    $next = PbInbox::where('id', '>', $mid)->where("toId",$user->userId)->min('id');
                }
                if($result["mtype"] == "send")
                {
                    $previous = PbInbox::where('id', '<', $mid)->where("fromId",$user->userId)->max('id');
                    $next = PbInbox::where('id', '>', $mid)->where("fromId",$user->userId)->min('id');
                }
                return view('member/memoView',['css'=>"mail.css","js"=>"mail.js","result"=>$result,"previous"=>$previous,"next"=>$next]);
                break;
            default:
                break;
        }
    }

    public function checkNickName(Request  $request){
        $user = $this->user;
        $nickname = $request->post("nickname");
        if($nickname == $user->nickname){
            echo "myself";
            return;
        }
        $isExist = User::where("nickname",$nickname)->first();
        if(empty($isExist)){
            echo "noexist";
            return;
        }
        else{
            if($user->user_type == "01"){
                echo "success";
                return;
            }
            if($user->user_type == "00"){
                echo "intercept";
                return;
            }
            if($user->isDeleted == 1){
                echo "leave";
                return;
            }
        }
        echo "error";
    }

    public function sendMail(Request  $request){
        $insert_id = array();
        $user = $this->user;
        $content  = $request->post("content");
        $randomMemo = $request->post("randomMemo");
        $item = array();
        if($randomMemo == "Y"){
            $inserts = array();
            $item =  PbPurItem::where("userId",$user->userId)->where("market_id","RANDOM_NOTE")->where("count",">",0)->first();
            if(empty($item)){
                echo json_encode(array("status"=>0,"msg"=>"랜덤 아이템이 필요합니다."));
                return;
            }
            PbPurItem::find($item["id"])->update(["count"=>$item["count"]-1]);
            $insert_users = User::where("user_type","01")->where("isDeleted",0)->where("userId","!=",$user->userId)->limit(100)->get()->toArray();
            if(empty($insert_users)){
                echo json_encode(array("status"=>0,"msg"=>"유저가 비였습니다."));
                return;
            }
            foreach($insert_users as $ulist){
                array_push($inserts,array("fromId"=>$user->userId,'toId'=>$ulist["userId"],"content"=>$content));
                array_push($insert_id,$ulist["userIdKey"]);
            }
            PbInbox::insert($inserts);
        }
        else{
            $receiveNick  = $request->post("receiveNick");
            if($user->nickname == $receiveNick){
                echo json_encode(array("status"=>0,"msg"=>"유저가 비였습니다."));
                return;
            }
            $received_userId = User::where("nickname",$receiveNick)->where("isDeleted",0)->first();
            if(empty($received_userId)){
                echo json_encode(array("status"=>0,"msg"=>"유저가 비였습니다."));
                return;
            }
            $item =  PbPurItem::where("userId",$user->userId)->where("market_id","NOTE_ITEM_100")->where("count",">",0)->first();
            if(empty($item)){
                echo json_encode(array("status"=>0,"msg"=>"쪽지 아이템이 필요합니다."));
                return;
            }
            PbPurItem::find($item["id"])->update(["count"=>$item["count"]-1]);
            PbInbox::insert(["fromId"=>$user->userId,"toId"=>$received_userId["userId"],"content"=>$content,"mail_type"=>2]);
            $insert_id[0] = $received_userId["userIdKey"];
        }
        if(sizeof($insert_id) > 0)
            echo json_encode(array("status"=>1,"tuseridKey"=>$insert_id));
        else
            echo json_encode(array("status"=>1,"msg"=>"잘못된 접근입니다."));
    }

    public function deleteMemo(Request $request){
        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.close()</script>";
        }
        $mtype = $request->post("mtype");
        $userId = $this->user->userId;
        $list_memo  = $request->post("check");
        PbInbox::whereIn("id",$list_memo)
            ->where(function($query) use ($userId){
            $query->where("fromId",$userId);
            $query->orwhere("toId",$userId);
        })->delete();
        echo "<script>location.href='/memo?type={$mtype}';</script>";
    }
    public function memoSave(Request $request){
        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.close()</script>";
        }

        $userId = $this->user->userId;
        $list_memo  = $request->post("check");
        PbInbox::whereIn("id",$list_memo)
            ->where(function($query) use ($userId){
                $query->where("fromId",$userId);
                $query->orwhere("toId",$userId);
            })->update(["state"=>1]);
        echo "<script>location.href='/memo?type=save';</script>";
    }
    public function memoReport(Request $request){
        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.close()</script>";
        }

        $userId = $this->user->userId;
        $list_memo  = $request->post("check");
        PbInbox::whereIn("id",$list_memo)
            ->where(function($query) use ($userId){
                $query->where("fromId",$userId);
                $query->orwhere("toId",$userId);
            })->update(["report"=>2]);
        echo "<script>alert('정확히 신고되었습니다.');window.history.back(1);</script>";
    }

    public function processFrd(Request  $request){
        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.close()</script>";
        }
        $user = $this->user;
        $checked_usr = $request->post("check");
        if($request->post("friendType") == "friend"){
            $frd_list = explode(",",$user->frd_list);
            foreach($checked_usr as $usr_item){
                if (($key = array_search($usr_item,$frd_list)) !== false) {
                    unset($frd_list[$key]);
                }
            }
            User::where('userId',$user->userId)->update(["frd_list"=>implode(",",$frd_list)]);
        }
        if($request->post("friendType") == "fixed"){
            $fixed_list = explode(",",$user->fixed);
            foreach($checked_usr as $usr_item){
                if (($key = array_search($usr_item,$fixed_list)) !== false) {
                    unset($fixed_list[$key]);
                }
            }
            User::where('userId',$user->userId)->update(["fixed"=>implode(",",$fixed_list)]);
        }
        if($request->post("friendType") == "block"){
            $block_list = explode(",",$user->block_list);
            foreach($checked_usr as $usr_item){
                if (($key = array_search($usr_item,$block_list)) !== false) {
                    unset($block_list[$key]);
                }
            }
            User::where('userId',$user->userId)->update(["block_list"=>implode(",",$block_list)]);
        }
        echo "<script>location.href='{$request->post("rtnUrl")}';</script>";
    }

    public function addFriend(Request $request){
        $user = $this->user;
        $nickname = $request->post("nickname");
        $other = User::where("nickname",$nickname)->first();
        $type = $request->post("type");
        if(empty($other)){
            echo json_encode(array("status"=>0,"msg"=>"존재하지 않는 유저입니다."));
            return;
        }

        if($type == "friend"){
            $frd_list = explode(",",$user->frd_list);
            if(in_array($other["userIdKey"],$frd_list)){
                echo json_encode(array("status"=>0,"msg"=>"친구리스트에 있는 회원입니다."));
                return;
            }
            array_push($frd_list,$other["userIdKey"]);
            User::where("userId",$user->userId)->update(["frd_list"=>implode(",",$frd_list)]);
            echo json_encode(array("status"=>1,"msg"=>"추가하었습니다.","friendNickname"=>$nickname));
        }
        else{
            $block_list = explode(",",$user->block_list);
            if(in_array($other["userIdKey"],$block_list)){
                echo json_encode(array("status"=>0,"msg"=>"블랙리스트에 있는 회원입니다."));
                return;
            }
            array_push($block_list,$other["userIdKey"]);
            User::where("userId",$user->userId)->update(["block_list"=>implode(",",$block_list)]);
            echo json_encode(array("status"=>1,"msg"=>"추가하었습니다.","blackUseridKey"=>$other["userIdKey"],"blackNickname"=>$nickname));
        }
    }

    public function giftBox(Request $request){
        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.close()</script>";
            return;
        }
        $user = $this->user;
        $other = User::where("userIdKey",$request->get("useridKey"))->where("isDeleted",0)->where("user_type","01")->first();
        if(empty($other)){
            echo "<script>alert('존재하지 않는 회원입니다.');window.close()</script>";
            return;
        }
        if($user->userIdKey == $request->get("useridKey")){
            echo "<script>alert('자신에게는 선물할수 없습니다.');window.close()</script>";
            return;
        }
        return view('member/giftBox', [    "js" => "gift.js",
            "css" => "gift.css",
            "user"=>$user,
            "other_nick"=>$other["nickname"]
            ]);
    }

    public function sendGift(Request $request){
        if(!$this->isLogged){
            echo json_encode(array("status"=>0,"msg"=>"로그아웃상태이므로 요청을 수락할수 없습니다."));
            return;
        }
        $type = $request->post("type");
        $tuseridKey = $request->post("tuseridKey");
        $cnt = $request->post("cnt");
        $roomIdx = $request->post("roomIdx");
        $cmd = $request->post("cmd");

        $user = $this->user;
        $user->bullet = $user->bullet - $cnt;
        $user->save();
        $other = User::where("userIdKey",$tuseridKey)->first();
        if(empty($other)){
            echo json_encode(array("status"=>0,"msg"=>"잘못된 접근입니다."));
            return;
        }
        User::where("userIdKey",$tuseridKey)->update(["bullet"=>DB::raw("bullet+".$cnt)]);

        PbLog::create([
            "type"=>4,
            "content"=>json_encode(array("type"=>"당근","count"=>$cnt)),
            "userId"=>$user->userId,
            "ip"=>$request->ip(),
            "fromId"=>$user->userId,
            "toId"=>$other["userId"],
        ]);
        echo json_encode(array("status"=>1,"msg"=>"총알 선물이 완료되었습니다.","list"=>array("cmd"=>$cmd,"cnt"=>$cnt,"tuseridKey"=>$tuseridKey,"roomIdx"=>$roomIdx,"type"=>$type)));
        return;
    }

    public function giftPop(Request  $request){
        if(!$this->isLogged){
            echo json_encode(array("status"=>0,"msg"=>"로그아웃상태이므로 요청을 수락할수 없습니다."));
            return;
        }
        $user = $this->user;
        $itemCode = $request->get("itemCode");
        $itemCnt = $request->get("itemCnt") ?? 1;
        $item = PbMarket::where("code",$itemCode)->where("state",1)->first();
        if(empty($item)){
            echo "<script>alert('해당 아이템이 존재하지 않습니다.');self.close();</script>";
            return;
        }
        return view('member/giftPop', [
            "js" => "gift.js",
            "css" => "gift.css",
            "item"=>$item,
            "nickname"=>$user->nickname,
            "itemCode"=>$itemCode,
            "api_token"=>$user->api_token
        ]);
    }

    public function sendItem(Request  $request){
        if(!$this->isLogged){
            echo json_encode(array("status"=>0,"code"=>"NOTLOGIN","msg"=>"로그아웃상태이므로 요청을 수락할수 없습니다."));
            return;
        }
        $user = $this->user;
        $itemCode =  $request->post("itemCode");
        $itemCnt =  $request->post("itemCnt");
        $targetNick =  $request->post("targetNick");

        $item = PbMarket::where("code",$itemCode)->where("state",1)->first();

        if(empty($item)){
            echo json_encode(array("status"=>0,"code"=>"DEFAULT","msg"=>"아이템이 존재하지 않습니다."));
            return;
        }
        if($item["gift_used"] == 0){
            echo json_encode(array("status"=>0,"code"=>"PERMISSION","msg"=>"선물할수 없는 아이템입니다."));
            return;
        }

        $other = User::where("nickname",$targetNick)->where("isDeleted",0)->where("user_type","01")->first();

        if(empty($other)){
            echo json_encode(array("status"=>0,"code"=>"DEFAULT","msg"=>"존재하지 않는 회원입니다."));
            return;
        }

        if($item["price_type"] == 1){
            if($user->coin < $item["price"]){
                echo json_encode(array("status"=>0,"code"=>"CHARGE"));
                return;
            }
            $user->coin -= $item["price"];
            $user->save();
        }

        if($item["price_type"] == 2){
            if($user->bread < $item["price"]){
                echo json_encode(array("status"=>0,"code"=>"NEEDBISCUIT"));
                return;
            }
            $user->bread -= $item["price"];
            $user->save();
        }

        $pur_item = PbPurItem::where("userId",$other["userId"])->where("market_id",$itemCode)->first();
        if(!empty($pur_item)){
            PbPurItem::where("id",$pur_item["id"])->update(["count"=>DB::raw("count+".$itemCnt)]);
        }
        else
            PbPurItem::insert(["userId"=>$other["userId"],"market_id"=>$itemCode,"count"=>$itemCnt]);

        PbLog::create([
            "type"=>4,
            "content"=>json_encode(array("type"=>$item["name"],"count"=>$itemCnt)),
            "userId"=>$user->userId,
            "ip"=>$request->ip(),
            "fromId"=>$user->userId,
            "toId"=>$other["userId"],
        ]);
        echo json_encode(array("status"=>1,"msg"=>"아이템 선물이 완료되었습니다."));
    }

    public function ranking(Request $request){
        $type = $request->get("type") ?? "powerballOddEven";
        $users = array();

        switch ($type){
            case "powerballOddEven":
                $users  = User::with("getLevel")->where("bet_number",">=",5000)->where("bet_date",">=",date('Y-m-d', strtotime('-7 days', strtotime("now"))))->where("winning_history","!=",null)->orderBy("bet_number","DESC")->limit(30)->get()->toArray();
                break;
            case "powerballUnderOver":
                $users  = User::with("getLevel")->where("bet_number1",">=",5000)->where("bet_date1",">=",date('Y-m-d', strtotime('-7 days', strtotime("now"))))->where("winning_history","!=",null)->orderBy("bet_number1","DESC")->limit(30)->get()->toArray();
                break;
            case "numberOddEven":
                $users  = User::with("getLevel")->where("bet_number2",">=",5000)->where("bet_date2",">=",date('Y-m-d', strtotime('-7 days', strtotime("now"))))->where("winning_history","!=",null)->orderBy("bet_number2","DESC")->limit(30)->get()->toArray();
                break;
            case "numberUnderOver":
                $users  = User::with("getLevel")->where("bet_number3",">=",5000)->where("bet_date3",">=",date('Y-m-d', strtotime('-7 days', strtotime("now"))))->where("winning_history","!=",null)->orderBy("bet_number3","DESC")->limit(30)->get()->toArray();
                break;
            case "numberSize":
                $users  = User::with("getLevel")->where("bet_number4",">=",5000)->where("bet_date4",">=",date('Y-m-d', strtotime('-7 days', strtotime("now"))))->where("winning_history","!=",null)->orderBy("bet_number4","DESC")->limit(30)->get()->toArray();
                break;
        }
        return view('member/ranking', [
            "js" => "",
            "css" => "ranking.css",
            "users"=>$users

        ]);
    }

    public  function present(Request $request){
        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.history.back(1)</script>";
        }
        $type = $request->get("type") ?? date("Y-m-d");
        $presents = array();
        $user = $this->user;
        $size = rand(0,sizeof(randomItemMessage())-1);
        $win_number = CodeDetail::where("codestname","RandomNumber")->first();
        $presents = PbPresent::with("user.getLevel")->where("created_at","LIKE",date("Y-m",strtotime($type))."%")->orderBy("created_at","DESC")->paginate(20);
        $month_days = array();

        $users_days = PbPresent::where("userId",$user->userId)->where("created_at","LIKE",date("Y-m",strtotime($type))."%")->get()->toArray();
        if(!empty($users_days)){
            foreach($users_days as $udays){
                array_push($month_days,$udays["created_at"]);
            }
        }

        return view('member/present', [
            "js" => "present.js",
            "css" => "present.css",
            "presents"=>$presents,
            "size"=>$size,
            "api_token"=>$user["api_token"],
            "win_number"=>$win_number["value1"],
            "presents"=>$presents,
            "month_days"=>implode(",",$month_days)
        ]);
    }

    public function setPresent(Request $request){
        $user = $this->user;

        $current_present = PbPresent::where("userId",$user->userId)->whereDate("created_at","=",date("Y-m-d"))->first();
        if(!empty($current_present)){
            echo json_encode(array("status"=>0,"msg"=>"출석체크는 하루에 한번만 가능합니다."));
            return;
        }
        $randoms = array(1,2,3);
        $winNumber = $request->post("winNumber");
        $comment = $request->post("comment");
        $selectNumber = $request->post("selectNumber");
        $ladderResult = "lose";
        $userNumber = rand(0,5);
        if($userNumber == $winNumber){
            $ladderResult = "win";
            $number = $winNumber;
            $pur_item = PbPurItem::where("userId",$user->userId)->where("market_id","RANDOM_ITEM")->first();
            if(empty($pur_item))
                PbPurItem::insert([
                    "userId"=>$user->userId,
                    "market_id"=>"RANDOM_ITEM",
                    "count"=>1,
                ]);
            else
                PbPurItem::where("userId",$user->userId)->where("market_id","RANDOM_ITEM")->update(["count"=>DB::raw("count+1")]);
        }
        else{
            unset($randoms[$winNumber-1]);
            $randoms = array_values($randoms);
            $ran_index = rand(0,1);
            $number =  $randoms[$ran_index];
        }
        $seq_present = 0;
        $previous_present = PbPresent::where("userId",$user->userId)->whereDate("created_at","=",date('Y-m-d',strtotime("-1 days")))->first();
        if(!empty($previous_present)){
            $seq_present = $previous_present["perfectatt"];
        }
        $seq_present +=1;
        PbPresent::insert([
            "userId"=>$user->userId,
            "result"=>$ladderResult,
            "perfectatt"=>$seq_present++,
            "comment"=>$comment,
        ]);

        echo json_encode(array("ran"=>$randoms,"status"=>1,"selectNumber"=>$selectNumber,"number"=>$number,"ladderResult"=>$ladderResult));
    }

    public function rankingWinner(Request $request){
        $rooms = array();
        $win_users = array();
        $winnered_users = array();
        $winner = PbWinner::get()->toArray();
        $days_ago = date('Y-m-d H:i:s', strtotime('-26  hours', strtotime("now")));
        foreach($winner as $wins){
            $winnered_users[$wins["userId"]] = $wins["order"];
        }
        $rooms = PbRoom::where("created_at",">",$days_ago)->get()->toArray();
        foreach($rooms as $room){
            if(!isset($win_users[$room["userId"]]))
                $win_users[$room["userId"]] = 0;
            $accerate = 0;
            $total_pick = 0;
            $win = 0;
            $total_pick_div = 0;
            if(!empty($room["winning_history"])){
                $parsed = json_decode($room["winning_history"]);
                $total_pick += $parsed->total->win + $parsed->total->lose;
                $win = $parsed->total->win;
            }
            $total_pick_div = $total_pick ==0 ? 1 : $total_pick;
            $win_users[$room["userId"]] +=$room["recommend"] + $total_pick + (int)(100*$win)/$total_pick_div;
        }
        $moneyReturn = PbMoneyReturn::whereDate("updated_at","=",date("Y-m-d"))->where("status",1)->get()->toArray();
        if(!empty($moneyReturn)){
            foreach ($moneyReturn as $m){
                if(!isset($win_users[$m["userId"]])){
                    $win_users[$m["userId"]] = 0;
                }
                $win_users[$m["userId"]] +=$m["bullet"];
            }
        }
        arsort($win_users);
        $index = 0;
        foreach($win_users  as $key=>$u){
            if($index == 10) break;
            $index++;
            if(isset($winnered_users[$key])){
                $old_order = $index - $winnered_users[$key];
            }
            else{
                $old_order = 0;
            }
            PbWinner::updateOrCreate([
                                        "id"=>$index
                                        ],
                                        ["userId"=>$key,
                                        "order"=>$index,
                                        "old_order"=>$old_order]);
        }
        echo 1;
    }

    public function getWinners(Request $request){
        echo json_encode(PbWinner::with("user.getLevel")->orderBy("order","ASC")->get()->toArray());
    }

    public function winnerGift(Request $request){
        $gift = PbWinGift::get()->toArray();
        $gift_item = array();
        $winners = PbWinner::where(function($query){
            $query->where("order",1);
            $query->orwhere("order",2);
            $query->orwhere("order",3);
        })->get()->toArray();
        if(!empty($gift)){
            foreach($gift as $g){
                if(empty($gift_item[$g["order"]]))
                    $gift_item[$g["order"]] = array();
                array_push($gift_item[$g["order"]],array("market_id"=>$g["market_id"],"count"=>$g["count"]));
            }
        }

        foreach($winners as $w){
            if(!empty($gift_item[$w["order"]])){
                foreach($gift_item[$w["order"]] as $gifted){
                    $pur_item = PbPurItem::where("userId",$w["userId"])->where("market_id",$gifted["market_id"])->first();
                    if(empty($pur_item))
                        PbPurItem::insert(["userId"=>$w['userId'],"count"=>$gifted["count"],"market_id"=>$gifted["market_id"]]);
                    else
                        PbPurItem::where("id",$pur_item["id"])->update(["count"=>$pur_item["count"]+$gifted["count"]]);
                }
            }
        }
        echo 1;
    }

    public function memberSecurity(Request $request0){
        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.history.back(1)</script>";
        }
        $user = $this->user;
        return view('member/security', [
            "js" => "security.js",
            "css" => "modify.css",
            "api_token"=>$user->api_token
        ]);
    }

    public function setSecondPassword(Request $request){
        $user = $this->user;
        $securityPasswd = $request->post("securityPasswd");
        $securityPasswdUseYN = $request->post("securityPasswdUseYN");

        if($securityPasswdUseYN == "true"){
            $user->second_active = 1;
            $user->second_password = $securityPasswd;
        }
        else{
            $user->second_active = 0;
            $user->second_use = 0;
        }
        $user->save();

        echo json_encode(array("status"=>1,"msg"=>"2차비밀번호가 설정되었습니다...[{$securityPasswd}]"));
    }

    public function setoutIP(Request $request){
        $user = $this->user;
        $outip = $request->post("outip");
        if($outip == "true"){
            $user->except_ip = 1;
        }
        else
            $user->except_ip = 0;
        $user->save();
        echo 1;
    }

    public function sendSmsPhoneNum(Request $request){
        $phone = $request->post("phone");
        $checked_phone = User::where("phoneNumber",$phone)->first();
        if(!empty($checked_phone)){
            echo json_encode(array("status"=>0,"msg"=>"이미 사용중인 번호입니다."));
            return;
        }
        $two_min = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -2 minutes"));
        $phoneNumber_time = PbAuth::where("phoneNumber",$phone)->where("updated_at",">=",$two_min)->first();
        if(!empty($phoneNumber_time)){
            echo json_encode(array("status"=>0,"msg"=>"이미 발송되었습니다.2분후 다시 시도해주세요."));
            return;
        }
        $rand = rand(1000,9999);
        $data = [
                "body"=>"{$rand}",
                "sendNo"=> "01027674657",
                "recipientList"=> [
                        ["recipientNo"=> "{$phone}"]
                    ],
                "userId"=> ""
                ];
        $response = Http::post("https://api-sms.cloud.toast.com/sms/v2.0/appKeys/etohAKxWO6sxr0aB/sender/sms",$data);
        if($response->successful()){
            $json_response = $response->json();
            if(!empty($json_response["header"]["isSuccessful"])){
                PbAuth::updateorCreate(
                    ["phoneNumber"=>$phone],["auth_num"=>$rand]
                );
                echo json_encode(array("status"=>1,"msg"=>"성공적으로 발송되었습니다.인증번호를 입력해주세요."));
            }
        }
        else{
            echo json_encode(array("status"=>0,"msg"=>"인증발송에 실패되었습니다.2분후에 다시 시도해주세요"));
        }
    }

    public function checkAuth(Request $request){
        $two_min = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -2 minutes"));
        $auth = $request->post("auth");
        $phone = $request->post("phone");
        $auth_checked = PbAuth::where("auth_num",$auth)->where("phoneNumber",$phone)->where("updated_at",">",$two_min)->first();
        if(!empty($auth_checked)){
            echo json_encode(array("status"=>1,"msg"=>"인증 통과"));
        }
        else{
            echo json_encode(array("status"=>0,"msg"=>"잘못된 인증번호이거나 시간이 초과되었습니다."));
        }
    }

    public function findIdPw(Request $request){
        return view('member/findIdPw', [
            "js" => "join.js",
            "css" => "join.css"
        ]);
    }

    public function checkID(Request $request){
        $actionType = $request->post("actionType");
        if($actionType == "findId"){
            $user = User::with("errorUser")->where("name",$request->post("name"))->where("phoneNumber",$request->post("mobile"))->where("isDeleted",0)->first();
            if(!empty($user["errorUser"])){
                echo json_encode(array("status"=>0,"msg"=>"운영정책 위반으로 인해 차단된 회원입니다."));
                return;
            }
            else if(empty($user)){
                echo json_encode(array("status"=>1,"msg"=>"아이디가 존재하지 않습니다."));
                return;
            }
            else{
                echo json_encode(array("status"=>1,"msg"=>"회원님의 아이디는 <span style='color:#4B8EFA;font-weight:bold;'>{$user["loginId"]}</span> 입니다."));
                return;
            }
        }
        else{
            $user = User::with("errorUser")->where("loginId",$request->post("userid"))->where("phoneNumber",$request->post("mobile"))->where("isDeleted",0)->first();
            if(!empty($user["errorUser"])){
                echo json_encode(array("status"=>0,"msg"=>"운영정책 위반으로 인해 차단된 회원입니다."));
                return;
            }
            else if(empty($user)){
                echo json_encode(array("status"=>1,"msg"=>"아이디가 존재하지 않습니다."));
                return;
            }
            else{
                $password = Str::random(8);
                $new_password = Hash::make($password);
                User::where("userId",$user["userId"])->update(["password"=>$new_password]);
                echo json_encode(array("status"=>1,"msg"=>"회원님의 비밀번호는 <span style='color:#4B8EFA;font-weight:bold;'>{$password}</span> 입니다."));
                return;
            }
        }
    }

    public function requestExchange(Request $request){
        if(!$this->isLogged){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.history.back(1)</script>";
            return;
        }

        $idcard = $bankbook = "";
        $this->validate($request, [
            'idcard' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
            'bankbook' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048'
        ]);

        if ($request->hasFile('idcard')) {
            $filenameWithExt = $request->file('idcard')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('idcard')->getClientOriginalExtension();
            $idcard = $filename .'_'.time(). '.' . $extension;
            $request->file('idcard')->storeAs('public/assets/images/exch', $idcard);
        }
        else {

        }
        if ($request->hasFile('bankbook')) {
            $filenameWithExt = $request->file('bankbook')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('bankbook')->getClientOriginalExtension();
            $bankbook = $filename .'_'.time().'.' . $extension;
            $request->file('bankbook')->storeAs('public/assets/images/exch', $bankbook);
        }
        else {

        }


        if(!Hash::check($request->post("passwd"),$this->user->password)){
            echo "<script>alert('암호가 맞지 않습니다.');window.history.go(-1)</script>";
            return;
        }
        $request_ex = $request->all();
        $request_ex["userId"] = $this->user->userId;
        $request_ex["idcard"] = $idcard;
        $request_ex["bankbook"] = $bankbook;
        unset($request_ex["_token"]);
        unset($request_ex["rtnUrl"]);
        unset($request_ex["oknameYN"]);
        unset($request_ex["agree"]);
        unset($request_ex["privacyAgree1"]);
        unset($request_ex["privacyAgree2"]);


        PbMoneyReturn::insert($request_ex);
        echo "<script>alert('신청되었습니다.');location.href='/member?type=exchange';</script>";
    }

    public function exitMember(Request $request){
        if(!$this->isLogged){
            echo json_encode(array("status"=>0,"msg"=>"로그아웃상태이므로 요청을 수락할수 없습니다."));
            return;
        }
        if(!Hash::check($request->post("passwd"),$this->user->password)){
            echo json_encode(array("status"=>0,"msg"=>"암호가 옳바르지 않습니다."));
            return;
        }

        $this->user->isDeleted = 1;
        $this->user->save();
        PbLog::where("userId",$this->user->userId)->delete();
        LoginLog::where("userId",$this->user->userId)->delete();
        PbRoom::where("userId",$this->user->userId)->delete();
        PbBettingCtl::where("userId",$this->user->userId)->delete();
        echo json_encode(array("status"=>1,"msg"=>"탈퇴되었습니다."));
    }

    public function prison(Request $request){
      if(!$this->isLogged){
          echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.history.back(1)</script>";
          return;
      }
      return view('member/prison', [
          "js" => "",
          "css" => "board.css",
      ]);
    }
}
