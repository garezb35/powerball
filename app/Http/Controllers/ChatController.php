<?php

namespace App\Http\Controllers;

use App\Models\CodeDetail;
use App\Models\Pb_Result_Powerball;
use App\Models\PbBetting;
use App\Models\PbFavorRoom;
use App\Models\PbLog;
use App\Models\PbPurItem;
use App\Models\PbRoom;
use App\Models\RoomRecommend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use DB;

class ChatController extends Controller
{
    private $profile = array();

    public function __construct(){
        $detail = CodeDetail::where("class","0020")->where("status","Y")->orderBy("code","ASC")->get()->toArray();
        foreach ($detail as $value)
            $this->profile[$value["code"]] = $value["value3"];
    }

    public function index(Request $request)
    {
        if($request->get("state") == "doubled_display"){
            return view('chat/duplicate',["js"=>"","css"=>"","pick_visible"=>"none","p_remain"=>0]);
            return;
        }

        $item_count= 0;
        $api_token = "";
        $userIdKey = "";
        if(Auth::check())
        {
            $item_count = PbPurItem::where("userId",Auth::id())->where("active",1)->sum("count");
            $api_token = AUth::user()->api_token;
            $userIdKey = AUth::user()->userIdKey;
        }
        return view('chat/home',["p_remain"=>TimeController::getTimer(2),"item_count"=>$item_count,"api_token"=>$api_token,"userIdKey"=>$userIdKey,"profile"=>json_encode($this->profile)]);
    }

    public function roomWait(Request $request){
        if(!Auth::check()){
            $user = User::with("getLevel")->where("userId",1000000)->first();
        }
        else
        {
            $user = User::with("getLevel")->where("userId",Auth::id())->first();
        }
        $count = $favor_count = 0;
        $rtype = empty($request->rtype) ? "winRate" : $request->rtype;

        $premium_count = PbPurItem::select(DB::raw("SUM(count) as counts"))
                                    ->where("market_id","LIKE","%PREMIUM_CHATROOM%")
                                    ->where("userId",$user["userId"])
                                    ->get()->toArray();
        $normal_count = PbPurItem::select(DB::raw("SUM(count) as counts"))
                                    ->where(function($query)
                                    {
                                        $query->where("market_id","CHATROOM")
                                            ->orWhere("market_id","CHATROOM_20");
                                    })
                                    ->where("userId",$user["userId"])->get()->toArray();
        $premium_count = empty($premium_count) ? 0 : $premium_count[0]["counts"];
        $normal_count = empty($normal_count) ? 0 : $normal_count[0]["counts"];

        $best = $list= $pb_rooms =   array();
        $p = new PbRoom();
        $p = $p->with(["roomandpicture.getUserClass"])->where("pb_room.active",1);
        if($rtype == "winRate"){
            $pb_rooms = $p->get()->toArray();
        }
        if($rtype == "userCnt"){
            $pb_rooms = $p->orderBy("members","DESC")->get()->toArray();
        }
        if($rtype == "recommend"){
            $pb_rooms = $p->orderBy("recommend","DESC")->get()->toArray();
        }
        if($rtype == "latest"){
            $pb_rooms = $p->orderBy("created_at","DESC")->get()->toArray();
        }

        if($rtype == "favor"){
            $favor_list = PbFavorRoom::select(DB::raw("GROUP_CONCAT(pb_favor_room.roomIdx  SEPARATOR ',') as flist"))->where("userId",$user["userId"])->first();
            if(empty($favor_list["flist"]))
                $pb_rooms = array();
            else
                $pb_rooms = $p->whereIn("pb_room.roomIdx",explode(",",$favor_list["flist"]))
                                ->orderBy("updated_at","DESC")->get()->toArray();
        }

        $favor_count = PbFavorRoom::where("userId",$user->userId)->get()->count();

        $win = array();
        if(!empty($pb_rooms)){
            foreach($pb_rooms as $value){
                if(!empty($value->winning_history))
                {
                    $value["curent_win"] = json_decode($value->winning_history)["current_win"];
                    $value["win"] = json_decode($value->winning_history)["total"]["win"];
                    $value["lose"] = json_decode($value->winning_history)["total"]["lose"];
                }
                else {
                    $value["win"] = 0;
                    $value["lose"] = 0;
                    $value['current_win'] = 0;
                }
                array_push($win,$value);
            }
            usort($win, function ($item1, $item2) {
                return $item2['current_win'] <=> $item1['current_win'];
            });
            $pb_rooms = $win;
            $count = sizeof($pb_rooms);
            if(!empty($pb_rooms)){
                $best = $pb_rooms[0];
            }
            array_shift($pb_rooms);
        }
        return view('chat/waiting',[   "js"=>"chat-room.js",
                                            "css"=>"chat-room.css",
                                            "pick_visible"=>"none",
                                            "p_remain"=>TimeController::getTimer(0),
                                            "premium_count"=>$premium_count,
                                            "normal_count"=>$normal_count,
                                            "best"=>$best,
                                            "list"=>$pb_rooms,
                                            "user"=>$user,
                                            "room_count"=>$count,
                                            "favor_count"=>$favor_count,
                                            "api_token"=>$user["api_token"],
                                            "userIdKey"=>$user["userIdKey"],
                                            "profile"=>json_encode($this->profile),
                                            "level"=>$user["getLevel"],
                                            "u_level"=>$user["level"]
                                            ]);
    }

    public function viewChat(Request $request){
        if(!Auth::check()){
            echo "<script>alert('로그인 후 이용가능합니다.');window.history.go(-1);</script>";
            return;
        }
        $user = Auth::user();
        $win_room = array();
        $pb_room = PbRoom::with("roomandpicture.getUserClass")->where("pb_room.roomIdx",$request->token)->first();
        if(empty($pb_room) || empty($pb_room["roomandpicture"])){
            echo "<script>alert('해당 채팅방은 존재하지 않습니다.');window.history.go(-1);</script>";
            return;
        }
        if(in_array($user->userIdKey,explode(",",$pb_room["roomandpicture"]["block_list"]))){
            echo "<script>alert('블록리스트에 있는 회원입니다.');window.history.go(-1);</script>";
            return;
        }
        if(!empty($pb_room["blocked"]) && str_contains($pb_room["blocked"],$user->userIdKey)){
            echo "<script>alert('방장으로부처 강제 퇴장되었습니다.');window.history.go(-1);</script>";
            return;
        }
        if(!empty($pb_room["winning_history"]))
            $win_room = json_decode($pb_room["winning_history"]);

        if($user->userIdKey == $pb_room["super"])
            $manager = 1;
        else
            $manager = 0;

        $result = Pb_Result_Powerball::orderBy("day_round","DESC")->first();
        if(empty($result)){
            echo "<script>alert('결과가 비었습니다.');window.history.go(-1);</script>";
            return;
        }
        $next_round = $result["day_round"] + 1;
        $cur_bet = PbBetting::select(
            DB::raw("CONCAT('{',GROUP_CONCAT(CONCAT('\"',game_code,'\"',':','{','\"pick\":',pick,',','\"is_win\":',is_win,'}') SEPARATOR ','),'}') as content")
            )
            ->where("userId",$pb_room["roomandpicture"]["userId"])
            ->where("roomIdx",$request->token)
            ->where("round",$next_round)
            ->groupBy("round")
            ->groupBy("userId")
            ->first();
        $cur_bet = empty($cur_bet["content"]) ? "" : $cur_bet["content"];
        return view('chat/view',[   "js"=>"chat-view.js",
                                         "css"=>"chat-room.css",
                                         "pick_visible"=>"none",
                                         "token"=>$user->api_token,
                                         "win_room"=>$win_room,
                                         "room"=>$pb_room,
                                         "manager"=>$manager,
                                         "admin"=>0,
                                         "in_room"=>2,
                                         "next_round"=>$next_round,
                                         "cur_bet"=>$cur_bet,
                                         "api_token"=>$user->api_token,
                                         "userIdKey"=>$user->userIdKey,
                                         "profile"=>json_encode($this->profile),
                                         "p_remain"=>TimeController::getTimer(2),
                                            ]);
    }

    public function createRoom(Request $request){

        if(!Auth::check()){
            echo json_decode(array("status"=>0,"msg"=>'로그인 후 이용가능합니다..'));
            return;
        }
        $user = Auth::user();
        $title = $request->roomTitle;
        $description = $request->roomDesc;
        $type = $request->roomType;
        $pub = $request->roomPublic;
        $max = $request->maxUser;
        $password = "";
        $prefix = "";
        $msg = "";
        if($pub == "private"){
            if($user->level < "09"){
                echo json_encode(array("status"=>0,"msg"=>"비공개 채팅방 개설은 소위계급부터 가능합니다."));
                return;
            }
            $password = rand(1000,9999);
        }

        if($type == "normal") {
            $prefix = "일반 채팅방";
            $condition = "CHATROOM";
            $raw = PbPurItem::where("userId",$user->userId)
                                ->where(function($query){
                                    $query->where("market_id","CHATROOM");
                                    $query->orwhere("market_id","CHATROOM_20");
                                })
                                ->where("count",">", 0)
                                ->where("active",1)->first();
            if($user->level < "05"){
                echo json_encode(array("status"=>0,"msg"=>"일반 채팅방 개설은 하사 계급부터 가능합니다."));
                return;
            }
        }
        else {
            $prefix = "프리미엄 채팅방";
            $condition = "PREMIUM_CHATROOM";
            $raw = PbPurItem::where("userId",$user->userId)
                ->where(function($query){
                    $query->where("market_id","PREMIUM_CHATROOM");
                    $query->orwhere("market_id","PREMIUM_CHATROOM_20");
                })
                ->where("count",">", 0)
                ->where("active",1)->first();
        }

        $count = empty($raw) ? 0 : $raw["count"];
        if($count <= 0)
        {
            echo json_encode(array("status"=>0,"msg"=>"{$prefix} 개설을 위해서는 [{$prefix} 개설권] 아이템이 필요합니다."));
            return;
        }
        $days_ago = date('Y-m-d H:i:s', strtotime('-26  hours', strtotime("now")));
        $active_count = PbRoom::where("super",$user->userIdKey)->where("created_at",">",$days_ago)->get()->count();
        if($active_count > 0)
        {
            echo json_encode(array("status"=>0,"msg"=>"채팅방 개설은 한개만 가능합니다."));
            return;
        }
        $token = Str::random(50);
        $round = 0;
        $powerball_raw = Pb_Result_Powerball::orderBy("day_round","DESC")->first();
        if(empty($powerball_raw))
        {
            echo json_encode(array("status"=>0,"msg"=>"파워볼 결과가 존재하지 않습니다."));
            return;
        }
        $round = $powerball_raw["day_round"] + 1;
        PbRoom::create([
           "room_connect"=>$title,
            "max_connect"=>$max,
            "type"=>$type == "normal" ? 1 : 2,
            "active"=>0,
            "super"=>$user->userIdKey,
            "roomIdx"=>$token,
            "description"=>$description,
            "public"=>$pub == "public" ? 1 : 2,
            "round"=>$round,
            "password"=>$password,
            "userId"=>$user->userId
        ]);
        PbPurItem::where("id",$raw["id"])->update([
            "count"=>$count - 1
        ]);

        $msg = "성공적으로 개설하였습니다.";

        if($pub !="public" && $password !=""){
            $msg .= "\n당신의 채팅방 비밀암호는 ".$password." 입니다";
        }
        echo json_encode(array("status"=>1,"msg"=>$msg,"list"=>array("roomType"=>$type,"nickname"=>$user->nickname,"roomTitle"=>$title,"roomIdx"=>$token)));
        return;
    }

    public function checkActiveRoom(Request $request){
        $user = Auth::user();

        $days_ago = date('Y-m-d H:i:s', strtotime('-26  hours', strtotime("now")));
        $checkd = PbRoom::where("roomIdx",$request->room)->where("created_at","<=",$days_ago)->first();
        if(!empty($checkd)){
            PbRoom::find($checkd["id"])->delete();
            PbFavorRoom::where("roomIdx",$checkd["roomIdx"])->delete();
            RoomRecommend::where("roomIdx",$checkd["roomIdx"])->delete();
            echo json_encode(array("status"=>0,"required_id"=>$checkd["roomIdx"],"msg"=>"개설한 채팅방이 존재하지 않습니다."));
        }
        else{
            $active_room = PbRoom::where("active",1);
            if(empty($request->room))
                $active_room = $active_room->where("super",$user->userIdKey)->first();
            else
                $active_room = $active_room->where("roomIdx",$request->room)->first();
            if(!empty($active_room)){
                $super_user = User::find($active_room["userId"]);
                $fixed_list  = explode(",",$super_user->fixed);
                {
                    if( $active_room["pub"] != 1 &&
                        $active_room["password"] !="" &&
                        $active_room["super"] != $user->userIdKey &&
                        !in_array($user->userIdKey,$fixed_list)){
                        echo json_encode(array("status"=>0,"reason"=>"security"));
                        return;
                    }

                    if($user->userIdKey == $active_room["super"])
                        PbRoom::where("id",$active_room["id"])->update(["updated_at"=>date("Y-m-d H:i:s")]);
                    echo  json_encode(array("status"=>1,"token"=>$active_room["roomIdx"]));
                }
            }
            else{
                echo json_encode(array("status"=>0,"reason"=>"not exist","msg"=>"개설한 채팅방이 존재하지 않습니다."));
            }
        }
        return;
    }

    public function verifyPass(Request $request){
        $user = Auth::user();
        $roomIdx = $request->post("roomIdx");
        $roomPasswd = $request->post("roomPasswd");

        $pb_room = PbRoom::where("roomIdx",$roomIdx)->first();
        if(empty($pb_room)){
            echo json_encode(array("status"=>0,"msg"=>"채팅방이 존재하지 않습니다."));
            return;
        }
        if($roomPasswd != $pb_room["password"] && $pb_room["password"] !=""){
            echo json_encode(array("status"=>0,"msg"=>"비밀번호가 일치하지 않습니다."));
            return;
        }
        echo json_encode(array("status"=>1,"token"=>$roomIdx));
    }

    public function reChatRoom(Request $request){
        $user = Auth::user();
        $roomIdx = $request->roomIdx;
        $room = PbRoom::where("roomIdx",$roomIdx)->where("active",1)->first();
        if(!empty($room)){
            if($room["super"] == $user->userIdKey){
                echo json_encode(array("status"=>0,"msg"=>"방장이므로 추천할수 없습니다."));
                return;
            }
            $checked = RoomRecommend::where("userId",$user->userIdKey)->where("roomIdx",$roomIdx)->count();
            if($checked > 0){
                echo json_encode(array("status"=>0,"msg"=>"이미 추천되였습니다."));
                return;
            }
            RoomRecommend::insert(["userId"=>$user->userIdKey,"roomIdx"=>$roomIdx]);
            $updating_recom = PbRoom::find($room["id"]);
            $updating_recom->recommend = $updating_recom->recommend + 1;
            $updating_recom->save();
            echo json_encode(array("status"=>1));
        }
        else{
            echo json_encode(array("status"=>-1,"msg"=>"채팅방이 존재하지 않습니다."));
            return;
        }
    }

    public function setFavorite(Request  $request){
        $user = Auth::user();
        $roomIdx = $request->roomIdx;
        $room = PbRoom::where("roomIdx",$roomIdx)->where("active",1)->first();
        if(!empty($room)){
            if($room["super"] == $user->userIdKey){
                echo json_encode(array("status"=>0,"msg"=>"방장이므로 추가할수 없습니다."));
                return;
            }
            $checked = PbFavorRoom::where("userId",$user->userId)->where("roomIdx",$roomIdx)->count();
            if($checked > 0){
                echo json_encode(array("status"=>0,"msg"=>"이미 즐겨찾기에 등록된 회원입니다."));
                return;
            }
            PbFavorRoom::insert(["userId"=>$user->userId,"roomIdx"=>$roomIdx]);
            echo json_encode(array("status"=>1,"msg"=>"정상적으로 즐겨찾기가 등록 되었습니다."));
        }
        else{
            echo json_encode(array("status"=>-1,"msg"=>"채팅방이 존재하지 않습니다."));
            return;
        }
    }

    public function setFroze(Request $request){
        $user = Auth::user();
        $cmd = $request->cmd;
        $roomIdx = $request->roomIdx;
        $room = PbRoom::where("roomIdx",$roomIdx)->where("super",$user->userIdKey)->first();
        if(!empty($room)){
             $updating = PbRoom::find($room["id"]);
             if($cmd == "freezeOn")
                 $updating->frozen = "on";
             else $updating->frozen = "off";
             $updating->save();
             echo json_encode(array("status"=>1));
        }
        else
            echo json_encode(array("status"=>0,"msg"=>"방이 존재하지 않습니다."));
    }

    public function modifyRoom(Request $request){
        $user = Auth::user();
        $roomIdx = $request->roomIdx;
        $room = PbRoom::where("roomIdx",$roomIdx)->where("super",$user->userIdKey)->first();
        if(!empty($room)){
            $updating = PbRoom::find($room["id"]);
            $updating->room_connect = $request->roomTitle;
            $updating->description = $request->roomDesc;
            $updating->public = $request->roomPublic;
            $updating->save();
            echo json_encode(array("status"=>1));
        }
        else
            echo json_encode(array("status"=>0,"msg"=>"방이 존재하지 않습니다."));
    }

    public function deleteChatRoom(Request $request){
        $user = Auth::user();
        $roomIdx = $request->roomIdx;
        $room = PbRoom::where("roomIdx",$roomIdx)->where("super",$user->userIdKey)->first();
        if(!empty($room)){
            $updating = PbRoom::find($room["id"]);
            $updating->delete();
            echo json_encode(array("status"=>1));
        }
        else
            echo json_encode(array("status"=>0,"msg"=>"방이 존재하지 않습니다."));
    }

    public function getBullet(Request $request){
        $user = Auth::user();
        echo json_encode(array("status"=>1,"bullet"=>$user->bullet));
    }

    public function giveBullet(Request $request){
        $user = Auth::user();
        $roomIdx  = $request->roomIdx;
        $gift  = $request->gift;
        $tuseridKey = $request->tuseridKey;
        $room = PbRoom::where("roomIdx",$roomIdx)->where("super",$tuseridKey)->first();

        if(!is_numeric($gift) || $gift < 0 ){
            echo json_encode(array("status"=>0,"msg"=>"형식이 옳바르지 않스니다."));
            return;
        }
        if($user->userIdKey == $tuseridKey){
            echo json_encode(array("status"=>0,"msg"=>"방장은 선물할수 없습니다."));
            return;
        }

        $other = User::where("userIdKey",$tuseridKey)->first();
        if(empty($other)){
            echo json_encode(array("status"=>0,"msg"=>"존재하지 않는 회원입니다."));
            return;
        }

        if(empty($room)){
            echo json_encode(array("status"=>0,"msg"=>"채팅방이 존재하지 않습니다."));
            return;
        }
        else{
            $rest = $user->bullet - $gift;

            if($rest < 0 ){
                echo json_encode(array("status"=>0,"msg"=>"보유한 총알이 부족합니다."));
                return;
            }

            $user->bullet = $rest;
            $user->save();

            User::where("userIdKey",$tuseridKey)->increment("bullet",$gift);

            $updating = PbRoom::find($room["id"]);
            $updating->bullet = $updating->bullet + $gift;
            $updating->save();

            PbLog::create([
                "type"=>4,
                "content"=>json_encode(array("type"=>"당근","count"=>$gift)),
                "userId"=>$user->userId,
                "ip"=>$request->ip(),
                "fromId"=>$user->userId,
                "toId"=>$other["userId"],
            ]);
            echo json_encode(array("status"=>1,"bullet"=>$rest));
        }
    }

    public function getChatRooms(Request $request){
        $days_ago = date('Y-m-d H:i:s', strtotime('-26  hours', strtotime("now")));
        $rooms = PbRoom::with(["roomandpicture.getLevel","roomandpicture.item_use"])->where("created_at",">",$days_ago)->orderBy("cur_win","DESC")->orderBy("created_at","DESC")->get()->toArray();
        echo json_encode(array("status"=>1,"list"=>$rooms));
    }
}
