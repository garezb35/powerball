<?php

namespace App\Http\Controllers;

use App\Models\PbBoard;
use App\Models\PbComment;
use App\Models\PbMessage;
use App\Models\PbRecommend;
use App\Models\PbView;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    //
    public function view(Request $request){

        $result["api_token"] = "";
        if(!Auth::check()){
            $userId = 0;
        }
        else {
            $userId = Auth::user()->userId;
            $result["api_token"] = Auth::user()->api_token;
        }

        $result["type"] = $request->get("board_type") ?? "community";

        $board_category = $request->get("board_category");

        $board = PbBoard::where("name",$board_category)->first();

        if($request->get("sfl") == "mb_id" && $request->get("stx") != ""){
            $board_mails = PbMessage::with(["comments","views","recommend","send_usr"])
                ->whereHas('send_usr', function($query) use ($request) {
                    $query->where("pb_users.loginId","like","%".$request->get("stx")."%");
                })
                ->where("type",$board_category)
                ->orderBy("keys","DESC")
                ->orderBy('reply', 'ASC');
        }
        if($request->get("sfl") == "wr_name" && $request->get("stx") != ""){
            $board_mails = PbMessage::with(["comments","views","recommend","send_usr"])
                ->whereHas('send_usr', function($query) use ($request) {
                    $query->where("pb_users.nickname","like","%".$request->get("stx")."%");
                })
                ->where("type",$board_category)
                ->orderBy("keys","DESC")
                ->orderBy('reply', 'ASC');
        }

        else
            $board_mails = PbMessage::with(["comments","views","recommend","send_usr"])
                ->where("type",$board_category)
                ->orderBy("notice","DESC")
                ->orderBy("keys","DESC")
                ->orderBy('reply', 'ASC');

        if($request->get("sfl") == "wr_subject" && $request->get("stx") != ""){
            $board_mails = $board_mails->where("pb_message.title","like","%".$request->get("stx")."%");
        }
        if($request->get("sfl") == "wr_content" && $request->get("stx") != ""){
            $board_mails = $board_mails->where("pb_message.content","like","%".$request->get("stx")."%");
        }
        if($request->get("sfl") == "wr_subject||wr_content" && $request->get("stx") != ""){
            $board_mails = $board_mails->where(function($query) use($request){
                $query->where("pb_message.title","like","%".$request->get("stx")."%");
                $query->orwhere("pb_message.content","like","%".$request->get("stx")."%");
            });
        }

        $board_mails = $board_mails->paginate(20);
        $board_count = PbMessage::where("type",$board_category)->orderBy("keys","DESC")->orderBy('reply', 'ASC')->get()->count();
        $result["list"] = $board_mails;
        $result["board"] = $board;
        $result["board_count"] = $board_count;
        $result["userId"] = $userId;
        $result["article"] = array();
        $previous = 0;
        $next = 0;
        if($request->get("bid")){
            $result["article"] = PbMessage::with("comments")
                ->where("id",$request->get("bid"))
                ->orderBy("created_at","DESC")->first();

        }

        $result["previous"] = $previous;
        $result["next"] = $next;

        if(empty($board)){
            echo "<script>alert('존재하지 않는 페지입니다.')</script>";
            return;

        }
        $result["comments"]  = array();
        if(!empty($result["article"])){
            $previous = PbMessage::where('id', '<', $result["article"]["id"])->where("type",$board_category);
            $next = PbMessage::where('id', '>', $result["article"]["id"])->where("type",$board_category);
            if($result["board"]["security"] == 1){
                $previous = $previous->where(function($query) use($userId){
                    $query->where("fromId",$userId);
                    $query->orwhere("toId",$userId);
                });
                $next = $next->where(function($query) use($userId){
                    $query->where("fromId",$userId);
                    $query->orwhere("toId",$userId);
                });
            }
            $previous = $previous->max('id');
            $next = $next->min('id');
            $result["self"]  = User::where("userId",$userId)->first();
            $result["comments"] = PbComment::with("suser.getLevel")->where("messageId",$result["article"]["id"])->orderBy("created_at","DESC")->get()->toArray();
        }

        if($result["board"]["view_use"] == 1 && !empty($result["article"])){
            $ip = $request->ip();
            $previous_viewd = PbView::where("ip",$ip)->where("postId",$result["article"]["id"])->first();
            if(empty($previous_viewd)){
                PbView::insert(["ip"=>$ip,"postId"=>$result["article"]["id"]]);
            }
        }
        return view('board_view',["css"=>"board.css","js"=>"board.js","result"=>$result]);
    }

    public function commentProcess(Request $request){
        if(!Auth::check()){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.history.back(1)</script>";
            return;
        }
        $user = Auth::user();
        $w = $request->post("w");
        $bo_table = $request->post("bo_table");
        $page = $request->post("page") ?? 1;
        $wr_id = $request->post("wr_id") ?? 0;
        $comment_id = $request->post("comment_id") ?? 0;
        $board_type = $request->post("board_type");
        $wr_content = $request->post("wr_content");
        if(empty($wr_id)){
            echo "<script>alert('잘못된 접근입니다.');window.history.back(1)</script>";
            return;
        }
        if(empty($wr_content)){
            echo "<script>alert('내용이 비였습니다.');window.history.back(1)</script>";
            return;
        }
        if($w == "c"){
            PbComment::insert(["messageId"=>$wr_id,"userId"=>$user->userId,"parent"=>$comment_id,"content"=>$wr_content]);
        }
        else{
            PbComment::where("userId",$user->userId)->where("id",$comment_id)->update(["content"=>$wr_content]);
        }


        echo "<script>location.href='/board?board_type={$board_type}&board_category={$bo_table}&bid={$wr_id}&page={$page}'</script>";
    }

    public function deleteComment(Request  $request){
        $user  =Auth::user();
        $id = $request->post("id");

        $checked_com = PbComment::where("userId",$user->userId)->where("id",$id)->first();
        if(empty($checked_com)){
            echo json_encode(array("status"=>0,"msg"=>"자료가 비였습니다"));
        }
        else
        {
            PbComment::find($id)->delete();
            PbComment::where("messageId",$checked_com["messageId"])->where("parent",">",$checked_com["parent"])->delete();
            echo json_encode(array("status"=>1,"msg"=>"삭제되었습니다."));
        }
    }

    public function setRecommend(Request $request){
        $user = Auth::user();
        $id = $request->post("id");
        $checked_recom = PbRecommend::where("userId",$user->userId)->where("postId",$id)->first();
        $mail = PbMessage::find($id);
        if($mail["fromId"]  == $user->userId){
            echo json_encode(array("status"=>0,"msg"=>"자신의 글에는 추천할수 없습니다."));
            return;
        }
        if(!empty($checked_recom)){
            echo json_encode(array("status"=>0,"msg"=>"이미 추천하신 글입니다"));
            return;
        }

        PbRecommend::insert(["userId"=>$user->userId,"postId"=>$id]);
        echo json_encode(array("status"=>1,"msg"=>"성공","count"=>PbRecommend::where("postId",$id)->get()->count()));
    }

    public function boardWrite(Request $request){
        $board_category = $request->get("board_category");
        if(!Auth::check() || empty($board_category)){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.');window.history.back(1)</script>";
            return;
        }
        $wr_id = $request->get("bid");
        $result["title"] = "";
        $result["content"] = "";
        if(!empty($wr_id)){
            $mail = PbMessage::where("id",$wr_id)->first();
            if(empty($mail)){
                echo "<script>alert('존재하지 않는 게시물입니다.');window.history.back(1)</script>";
                return;
            }
            $result["title"] = $mail["title"];
            $result["content"] = $mail["content"];
        }
        $user = Auth::user();
        $result["api_token"] = $user->api_token;
        $result["board"] = PbBoard::where("name",$board_category)->where("isDeleted",0)->first();
        if(empty($result["board"])){
            echo "<script>alert('존재하지 않는 게시판입니다.');window.history.back(1)</script>";
            return;
        }
        return view('board_write',["css"=>"board.css","js"=>"board.js","result"=>$result]);
    }

    public function writePost(Request $request){
        $board_type = $request->post("board_type");
        $board_category = $request->post("board_category");
        $wr_id = $request->post("wr_id");
        $wr_subject = $request->post("wr_subject");
        $wr_content = $request->post("wr_content");
        $reply = $request->post("reply") ?? 0;
        if(!Auth::check() || empty($board_category)){
            echo "<script>alert('잘못된 접근입니다.');window.history.back(1)</script>";
            return;
        }
        $user = Auth::user();
        $board = PbBoard::where("name",$board_category)->where("isDeleted",0)->first();
        if(empty($board)){
            echo "<script>alert('게시판이 존재하지 않습니다.');window.history.back(1)</script>";
            return;
        }

        if($board["security"] == 1)
            $toId = 0;
        else
            $toId = "";

        if(empty($wr_id)){
            $pbMessage = new PbMessage();
            $pbMessage->toId = $toId;
            $pbMessage->fromId = $user->userId;
            $pbMessage->title = $wr_subject;
            $pbMessage->content = $wr_content;
            $pbMessage->type = $board_category;
            $pbMessage->reply = $reply;
            $pbMessage->security = $board["security"];
            $pbMessage->save();
            if($reply == 1){
                $key = $request->post("rid");
            }
            else
                $key = $pbMessage->id;
            PbMessage::where("id",$pbMessage->id)->update(["keys"=>$key]);
            echo "<script>location.href='/board?board_type={$board_type}&board_category={$board_category}';</script>";
        }
        else{
            PbMessage::where("id",$wr_id)->update(["fromId"=>$user->userId,"title"=>$wr_subject,"content"=>$wr_content,"type"=>$board_category,"reply"=>$reply,"security"=>$board["security"]]);
            echo "<script>location.href='/board?board_type={$board_type}&board_category={$board_category}';</script>";
        }
        return;
    }

    public function deletePost(Request $request){
        $user = Auth::user();
        $id = $request->post("id");
        $mail = PbMessage::where("id",$id)->where("fromId",$user->userId)->first();
        if(empty($mail)){
            echo json_encode(array("status"=>0,"msg"=>"존재하지 않은 게시물입니다."));
            return;
        }
        $reply = PbMessage::where("reply",1)->where("keys",$id)->where("id","!=",$id)
            ->where(function($query) use ($user){
                $query->where("toId",$user->userId);
                $query->orwhere("fromId",$user->userId);
            })
            ->first();
        if(!empty($reply)){
            echo json_encode(array("status"=>0,"msg"=>"답변이 있는 게시물은 삭제할수 없습니다."));
            return;
        }
        PbMessage::find($id)->delete();
        echo json_encode(array("status"=>1,"msg"=>"삭제되었습니다."));
    }
}
