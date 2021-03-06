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

class ChatController extends SecondController
{


    private $profile = array();

    public function __construct(){
        parent::__construct();
        $detail = CodeDetail::where("class","0020")->where("status","Y")->orderBy("code","ASC")->get()->toArray();
        foreach ($detail as $value)
            $this->profile[$value["code"]] = $value["value3"];


    }

    public function index(Request $request)
    {
        if($request->get("state") == "doubled_display"){
            if($request->get("logout") == 1){
              Auth::logout();
              $request->session()->invalidate();
              $request->session()->regenerateToken();
            }
            return view('chat/duplicate',["js"=>"","css"=>"","pick_visible"=>"none","p_remain"=>0]);
        }

        $is_admin = 0;
        $item_count= 0;
        $api_token = "";
        $userIdKey = "";
        $nickname = "";
        $bullet = 0;

        if($this->isLogged)
        {
            $item_count = PbPurItem::where("userId",$this->user->userId)->where("active",1)->sum("count");
            $api_token = $this->user->api_token;
            $userIdKey = $this->user->userIdKey;
            $nickname = $this->user->nickname;
            $bullet = $this->user->bullet;
            $is_admin = $this->user->user_type == '03' ? 1 : 0;
        }
        $prohited = $this->prohited["prohited"];
        return view('chat/home',["node"=>$this->prohited["node_address"],"prohited"=>$prohited,"cur_nickname"=>$nickname,"bullet"=>$bullet,"p_remain"=>TimeController::getTimer(2),"item_count"=>$item_count,"api_token"=>$api_token,"userIdKey"=>$userIdKey,"profile"=>json_encode($this->profile),"is_admin"=>$is_admin]);
    }

    public function roomWait(Request $request){
        $days_ago = date('Y-m-d H:i:s', strtotime('-26  hours', strtotime("now")));
        $is_admin = 0;    
        if(!$this->isLogged){
            $user = User::with("getLevel")->where("userId",3)->first();
        }
        else
        {
            $user = User::with("getLevel")->where("userId",$this->user->userId)->first();
            $is_admin = $this->user->user_type == '03' ? 1 : 0;
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
        $p = $p->with(["roomandpicture.getUserClass"])->where("pb_room.active",1)->where("pb_room.created_at",">",$days_ago);
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

        $favor_count = PbFavorRoom::where("userId",$user["userId"])->get()->count();

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
        $prohited =  $this->prohited["prohited"];

        return view('chat/waiting',[   "js"=>"chat-room.js",
                                            "css"=>"chat-room.css",
                                            "pick_visible"=>"none",
                                            "prohited"=>$prohited,
                                            "node"=>$this->prohited["node_address"],
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
                                            "u_level"=>$user["level"],
                                            "is_admin"=>$is_admin
                                            ]);
    }

    public function viewChat(Request $request){
        if(!$this->isLogged){
            echo "<script>alert('????????? ??? ?????????????????????.');window.history.go(-1);</script>";
            return;
        }
        $user = $this->user;
        $is_admin = $this->user->user_type == '03' ? 1 : 0;
        $win_room = array();
        $pb_room = PbRoom::with("roomandpicture.getUserClass")->where("pb_room.roomIdx",$request->token)->first();
        if(empty($pb_room) || empty($pb_room["roomandpicture"])){
            echo "<script>alert('?????? ???????????? ???????????? ????????????.');window.history.go(-1);</script>";
            return;
        }
        if(in_array($user->userIdKey,explode(",",$pb_room["roomandpicture"]["block_list"]))){
            echo "<script>alert('?????????????????? ?????? ???????????????.');window.history.go(-1);</script>";
            return;
        }
        if(!empty($pb_room["blocked"]) && str_contains($pb_room["blocked"],$user->userIdKey)){
            echo "<script>alert('?????????????????? ?????? ?????????????????????.');window.history.go(-1);</script>";
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
            echo "<script>alert('????????? ???????????????.');window.history.go(-1);</script>";
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
            ->first();

        $cur_bet = empty($cur_bet["content"]) ? "" : $cur_bet["content"];

        $prohited =  $this->prohited["prohited"];
        return view('chat/view',[   "js"=>"chat-view.js",
                                         "css"=>"chat-room.css",
                                         "prohited"=>$prohited,
                                         "node"=>$this->prohited["node_address"],
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
                                         "bullet"=>$user->bullet,
                                         "profile"=>json_encode($this->profile),
                                         "p_remain"=>TimeController::getTimer(2),
                                         "is_admin"=>$is_admin
                                            ]);
    }

    public function createRoom(Request $request){

        if(!$this->isLogged){
            echo json_decode(array("status"=>0,"msg"=>'????????? ??? ?????????????????????..'));
            return;
        }
        $user = $this->user;
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
                echo json_encode(array("status"=>0,"msg"=>"????????? ????????? ????????? ?????????????????? ???????????????."));
                return;
            }
            $password = rand(1000,9999);
        }

        if($type == "normal") {
            $prefix = "?????? ?????????";
            $condition = "CHATROOM";
            $raw = PbPurItem::where("userId",$user->userId)
                                ->where(function($query){
                                    $query->where("market_id","CHATROOM");
                                    $query->orwhere("market_id","CHATROOM_20");
                                })
                                ->where("count",">", 0)
                                ->where("active",1)->first();
            if($user->level < "05"){
                echo json_encode(array("status"=>0,"msg"=>"?????? ????????? ????????? ?????? ???????????? ???????????????."));
                return;
            }
        }
        else {
            $prefix = "???????????? ?????????";
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
            echo json_encode(array("status"=>0,"msg"=>"{$prefix} ????????? ???????????? [{$prefix} ?????????] ???????????? ???????????????."));
            return;
        }
        $days_ago = date('Y-m-d H:i:s', strtotime('-26  hours', strtotime("now")));
        $active_count = PbRoom::where("super",$user->userIdKey)->where("created_at",">",$days_ago)->get()->count();
        if($active_count > 0)
        {
            echo json_encode(array("status"=>0,"msg"=>"????????? ????????? ????????? ???????????????."));
            return;
        }
        $token = Str::random(50);
        $round = 0;
        $powerball_raw = Pb_Result_Powerball::orderBy("day_round","DESC")->first();
        if(empty($powerball_raw))
        {
            echo json_encode(array("status"=>0,"msg"=>"????????? ????????? ???????????? ????????????."));
            return;
        }
        $days_ago = date('Y-m-d H:i:s', strtotime('-26  hours', strtotime("now")));
        PbRoom::where("userId",$user->userId)->where("created_at","<=",$days_ago)->delete();
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

        $msg = "??????????????? ?????????????????????.";

        if($pub !="public" && $password !=""){
            $msg .= "\n????????? ????????? ??????????????? ".$password." ?????????";
        }
        echo json_encode(array("status"=>1,"msg"=>$msg,"list"=>array("roomType"=>$type,"nickname"=>$user->nickname,"roomTitle"=>$title,"roomIdx"=>$token)));
        return;
    }

    public function checkActiveRoom(Request $request){
        $user = $this->user;
        $days_ago = date('Y-m-d H:i:s', strtotime('-26  hours', strtotime("now")));
        $checkd = PbRoom::where("roomIdx",$request->room)->where("created_at","<",$days_ago)->first();
        $is_admin = $request->is_admin;
        if(!empty($checkd)){
            PbRoom::where("created_at","<",$days_ago)->delete();
            PbFavorRoom::where("roomIdx",$checkd["roomIdx"])->delete();
            RoomRecommend::where("roomIdx",$checkd["roomIdx"])->delete();
            echo json_encode(array("status"=>0,"required_id"=>$checkd["roomIdx"],"msg"=>"????????? ???????????? ???????????? ????????????."));
        }
        else{
            $active_room = PbRoom::where("active",1)->where("created_at",">",$days_ago);
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
                        !in_array($user->userIdKey,$fixed_list) && 
                        !$is_admin){
                        echo json_encode(array("status"=>0,"reason"=>"security"));
                        return;
                    }

                    if($user->userIdKey == $active_room["super"])
                        PbRoom::where("id",$active_room["id"])->update(["updated_at"=>date("Y-m-d H:i:s")]);
                    echo  json_encode(array("status"=>1,"token"=>$active_room["roomIdx"]));
                }
            }
            else{
                echo json_encode(array("status"=>0,"reason"=>"not exist","msg"=>"????????? ???????????? ???????????? ????????????."));
            }
        }
        return;
    }

    public function verifyPass(Request $request){
        $user = $this->user;
        $roomIdx = $request->post("roomIdx");
        $roomPasswd = $request->post("roomPasswd");

        $pb_room = PbRoom::where("roomIdx",$roomIdx)->first();
        if(empty($pb_room)){
            echo json_encode(array("status"=>0,"msg"=>"???????????? ???????????? ????????????."));
            return;
        }
        if($roomPasswd != $pb_room["password"] && $pb_room["password"] !=""){
            echo json_encode(array("status"=>0,"msg"=>"??????????????? ???????????? ????????????."));
            return;
        }
        echo json_encode(array("status"=>1,"token"=>$roomIdx));
    }

    public function reChatRoom(Request $request){
        $user = $this->user;
        $roomIdx = $request->roomIdx;
        $room = PbRoom::where("roomIdx",$roomIdx)->where("active",1)->first();
        if(!empty($room)){
            if($room["super"] == $user->userIdKey){
                echo json_encode(array("status"=>0,"msg"=>"??????????????? ???????????? ????????????."));
                return;
            }
            $checked = RoomRecommend::where("userId",$user->userIdKey)->where("roomIdx",$roomIdx)->count();
            if($checked > 0){
                echo json_encode(array("status"=>0,"msg"=>"?????? ?????????????????????."));
                return;
            }
            RoomRecommend::insert(["userId"=>$user->userIdKey,"roomIdx"=>$roomIdx]);
            $updating_recom = PbRoom::find($room["id"]);
            $updating_recom->recommend = $updating_recom->recommend + 1;
            $updating_recom->save();
            echo json_encode(array("status"=>1));
        }
        else{
            echo json_encode(array("status"=>-1,"msg"=>"???????????? ???????????? ????????????."));
            return;
        }
    }

    public function setFavorite(Request  $request){
        $user = $this->user;
        $roomIdx = $request->roomIdx;
        $room = PbRoom::where("roomIdx",$roomIdx)->where("active",1)->first();
        if(!empty($room)){
            if($room["super"] == $user->userIdKey){
                echo json_encode(array("status"=>0,"msg"=>"??????????????? ???????????? ????????????."));
                return;
            }
            $checked = PbFavorRoom::where("userId",$user->userId)->where("roomIdx",$roomIdx)->count();
            if($checked > 0){
                echo json_encode(array("status"=>0,"msg"=>"?????? ??????????????? ????????? ???????????????."));
                return;
            }
            PbFavorRoom::insert(["userId"=>$user->userId,"roomIdx"=>$roomIdx]);
            echo json_encode(array("status"=>1,"msg"=>"??????????????? ??????????????? ?????? ???????????????."));
        }
        else{
            echo json_encode(array("status"=>-1,"msg"=>"???????????? ???????????? ????????????."));
            return;
        }
    }

    public function setFroze(Request $request){
        $user = $this->user;
        $cmd = $request->cmd;
        $roomIdx = $request->roomIdx;
        if($user->user_type == '03'){
            $room = PbRoom::where("roomIdx",$roomIdx)->first();
        }
        else{
            $room = PbRoom::where("roomIdx",$roomIdx)->where("super",$user->userIdKey)->first();
        }
        if(!empty($room)){
             $updating = PbRoom::find($room["id"]);
             if($cmd == "freezeOn")
                 $updating->frozen = "on";
             else $updating->frozen = "off";
             $updating->save();
             echo json_encode(array("status"=>1));
        }
        else
            echo json_encode(array("status"=>0,"msg"=>"?????? ???????????? ????????????."));
    }

    public function modifyRoom(Request $request){
        $user = $this->user;
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
            echo json_encode(array("status"=>0,"msg"=>"?????? ???????????? ????????????."));
    }

    public function deleteChatRoom(Request $request){
        $user = $this->user;
        $roomIdx = $request->roomIdx;
        if($user->user_type == '03'){
            $room = PbRoom::where("roomIdx",$roomIdx)->first();
        }else{
            $room = PbRoom::where("roomIdx",$roomIdx)->where("super",$user->userIdKey)->first();
        }
        if(!empty($room)){
            $updating = PbRoom::find($room["id"]);
            $updating->delete();
            echo json_encode(array("status"=>1));
        }
        else
            echo json_encode(array("status"=>0,"msg"=>"?????? ???????????? ????????????."));
    }

    public function getBullet(Request $request){
        $user = $this->user;
        echo json_encode(array("status"=>1,"bullet"=>$user->bullet));
    }

    public function giveBullet(Request $request){
        $user = $this->user;
        $roomIdx  = $request->roomIdx;
        $gift  = $request->gift;
        $tuseridKey = $request->tuseridKey;
        $room = PbRoom::where("roomIdx",$roomIdx)->where("super",$tuseridKey)->first();

        if(!is_numeric($gift) || $gift < 0 ){
            echo json_encode(array("status"=>0,"msg"=>"????????? ???????????? ????????????."));
            return;
        }
        if($user->userIdKey == $tuseridKey){
            echo json_encode(array("status"=>0,"msg"=>"????????? ???????????? ????????????."));
            return;
        }

        $other = User::where("userIdKey",$tuseridKey)->first();
        if(empty($other)){
            echo json_encode(array("status"=>0,"msg"=>"???????????? ?????? ???????????????."));
            return;
        }

        if(empty($room)){
            echo json_encode(array("status"=>0,"msg"=>"???????????? ???????????? ????????????."));
            return;
        }
        else{
            $rest = $user->bullet - $gift;

            if($rest < 0 ){
                echo json_encode(array("status"=>0,"msg"=>"????????? ????????? ???????????????."));
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
                "content"=>json_encode(array("type"=>"??????","count"=>$gift)),
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
