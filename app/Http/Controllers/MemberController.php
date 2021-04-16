<?php

namespace App\Http\Controllers;

use App\Models\CodeDetail;
use App\Models\PbItemUse;
use App\Models\PbPurItem;
use App\Models\PbRoom;
use App\Models\PbLog;
use App\Models\PbMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;
use Image; 

class MemberController extends Controller
{
    //
    public function index(Request $request){

        if(!Auth::check()){
            echo "<script>alert('잘못된 접속입니다.')</script>";
            return;
        }
        $userId= Auth::id();
        $user = User::find($userId)->with(["item"])->first();
        $avata = CodeDetail::where("class","0020")->where("code",$user->level)->first();
        $avata = empty($avata["value3"]) ? "": $avata["value3"];
        $type = empty($request->type) ? "mine" : $request->type;
        $item_count = array();
        foreach($user->item->toArray() as $index){
            $item_count[$index["market_id"]] = $index["count"];
        }
        switch ($type){
            case "mine";
                return view('member/powerball-mypage', [   "js" => "",
                                                                "css" => "member.css",
                                                                "user" => $user,
                                                                "avata"=>$avata,
                                                                "item_count" => $item_count
                    ]
                );
                break;
            case "item";
                $item = new PbPurItem();
                $pur_item = $item->with('items')->where("pb_pur_item.userId",$user->userId)->where("pb_pur_item.count" , ">",0)->get();
                return view('member/powerball-item', [     "js" => "market.js",
                                                                "css" => "member.css",
                                                                "pur_item"=>$pur_item,
                                                                "api_token"=>$user->api_token
                    ]
                );
                break;
            case "itemLog";
                return view('member/powerball-itemLog', [      "js" => "",
                                                                    "css" => "member.css"
                    ]
                );
                break;
            case "itemTerm";
                return view('member/powerball-itemTerm', [      "js" => "",
                                                                    "css" => "member.css"
                    ]
                );
                break;
            case "nicknameLog";
                return view('member/powerball-nicknameLog', [      "js" => "",
                        "css" => "member.css"
                    ]
                );
                break;
            case "giftLog";
                return view('member/powerball-giftLog', [      "js" => "",
                        "css" => "member.css"
                    ]
                );
                break;
            case "chargeLog";
                return view('member/powerball-chargeLog', [      "js" => "",
                        "css" => "member.css"
                    ]
                );
                break;
            case "exchange";
                echo "<script>alert('총알 환전은 실명인증이 완료된 계정에 한해서 신청 가능합니다.')</script>";
                return;
                break;
            case "level";
                $user_exp = $user->exp;
                $user_level = $user->level;
                $level_list = CodeDetail::where("class","0020")->where("usetype","Y")->where("status","Y")->orderBy("code","ASC")->get()->toArray();

                return view('member/powerball-level', [    "js" => "member.js",
                                                                "css" => "member.css",
                                                                "user_exp"=>$user_exp,
                                                                "user_level" =>$user_level,
                                                                "level_list" =>$level_list
                    ]
                );
                break;
            case "loginLog";
                return view('member/powerball-accesslog', [    "js" => "",
                                                                    "css" => "member.css"
                    ]
                );
                break;
            case "withdraw";
                break;
            default:
                echo "<script>alert('잘못된 접속입니다.')</script>";
                return;
        }
    }

    public function setMute(Request $request){
        $roomIdx = $request->roomIdx;
        $tuseridKey = $request->tuseridKey;
        $user = Auth::user();
        $cmd = $request->cmd;
        $pb_room = PbRoom::where("roomIdx",$roomIdx)->first();
        if(empty($pb_room)){
            echo json_decode(array("status"=>0,"msg"=>"방이 비었습니다."));
            return;
        }
        $mute =$pb_room["mute"];
        $manager  = $pb_room["manager"];

        if($user->userIdKey != $pb_room["super"] && str_contains($manager,$user->userIdKey)){
            echo json_decode(array("status"=>0,"msg"=>"권한이 없습니다."));
            return;
        }

        if(!empty($mute) && str_contains($mute,$tuseridKey) && $cmd == "muteOn"){
            echo json_decode(array("status"=>0,"msg"=>"이미 벙어리상태입니다."));
            return;
        }

        if(!empty($mute) && !str_contains($mute,$tuseridKey) && $cmd == "muteOff"){
            echo json_decode(array("status"=>0,"msg"=>"벙어리상태의 회원이 아닙니다."));
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
        $user = Auth::user();
        $cmd = $request->cmd;
        $pb_room = PbRoom::where("roomIdx",$roomIdx)->first();
        if(empty($pb_room)){
            echo json_decode(array("status"=>0,"msg"=>"방이 비었습니다."));
            return;
        }
        $blocked =$pb_room["blocked"];
        $manager  = $pb_room["manager"];

        if($user->userIdKey != $pb_room["super"] && str_contains($manager,$user->userIdKey)){
            echo json_decode(array("status"=>0,"msg"=>"권한이 없습니다."));
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
        $user = Auth::user();
        $cmd = $request->cmd;
        $pb_room = PbRoom::where("roomIdx",$roomIdx)->first();
        if(empty($pb_room)){
            echo json_decode(array("status"=>0,"msg"=>"방이 비었습니다."));
            return;
        }
        $manager  = $pb_room["manager"];
        if($user->userIdKey != $pb_room["super"]){
            echo json_decode(array("status"=>0,"msg"=>"권한이 없습니다."));
            return;
        }
        if(!empty($manager) && str_contains($manager,$tuseridKey) && $cmd == "managerOn"){
            echo json_decode(array("status"=>0,"msg"=>"이미 매니저입니다."));
            return;
        }
        if(!empty($manager) && !str_contains($manager,$tuseridKey) && $cmd == "managerOff"){
            echo json_decode(array("status"=>0,"msg"=>"이 회원은 매니저가 아닙니다."));
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

        if(!Auth::check()){
            echo "<script>alert('잘못된 접속입니다.')</script>";
            return;
        }
        $user = Auth::user();
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
        $userId= Auth::id();
        $user = User::find($userId)->with(["item"])->first();
        $item_count = array();
        foreach($user->item->toArray() as $index){
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

    public function imgCheck(){
        $userId= Auth::id();
        $user = User::find($userId)->with(["item"])->first();
        $item_count = array();
        foreach($user->item->toArray() as $index){
            $item_count[$index["market_id"]] = $index["count"];
        }
        $pur_item = PbMarket::where("code","PROFILE_IMAGE_RIGHT")->first();
        if(empty($item_count["PROFILE_IMAGE_RIGHT"]) || empty($pur_item)){
            echo json_encode(array("status"=>0,"msg"=>"프로필이미지를 사용 또는 변경하려면 [프로필이미지 이용권] 아이템이 필요합니다."));
        }
        else
            echo json_encode(array("status"=>1));

    }

    public function uploadImage(Request $request){
        if(!Auth::check()){
            echo "<script>alert('잘못된 접속입니다.')</script>";
            return;
        }
        $user = Auth::user();
        $item_count = array();
        foreach($user->item->toArray() as $index){
            $item_count[$index["market_id"]] = $index["count"];
        }
        $pur_item = PbMarket::where("code","PROFILE_IMAGE_RIGHT")->first();
        $this->validate($request, [
            'profileImg' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
        ]);
        if(empty($item_count["PROFILE_IMAGE_RIGHT"]) || empty($pur_item)){
            echo "<script>alert('프로필 이미지 변경 아이템이 없습니다.');window.close()</script>";
        }
        $input = array();
        $image = $request->file('profileImg');
        $input['imagename'] = $user->userIdKey.'.'.$image->extension();
        $filePath = public_path('/assets/images/mine/profile');
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
}
