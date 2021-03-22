<?php

namespace App\Http\Controllers;

use App\Models\PbPurItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $item_count= 0;
        $api_token = "";
        if(Auth::check())
        {
            $item_count = PbPurItem::where("userId",Auth::id())->where("active",1)->sum("count");
            $api_token = AUth::user()->api_token;
        }
        return view('chat/home',["p_remain"=>TimeController::getTimer(2),"item_count"=>$item_count,"api_token"=>$api_token]);
    }

    public function roomWait(){
        return view('chat/waiting',["js"=>"","css"=>"chat-room.css","pick_visible"=>"none","p_remain"=>TimeController::getTimer(0)]);
    }

    public function viewChat(){
        return view('chat/view',["js"=>"","css"=>"chat-room.css","pick_visible"=>"none","p_remain"=>TimeController::getTimer(0)]);
    }
}
