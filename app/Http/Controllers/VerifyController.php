<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;

class VerifyController extends Controller
{
    public function veriPass(Request $request){
        if(!Auth::check()){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.')</script>";
            return;
        }
        return view('member/veriPass', [
            "js" => "security.js",
            "css" => "modify.css",
            "api_token"=>Auth::user()->api_token
        ]);
    }

    public function verifySeconds(Request $request){
        if(!Auth::check()){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.')</script>";
            return;
        }
        $user = Auth::user();
        if($user->second_password == $request->post("securityPasswd")){
            $user->second_use = 0;
            $user->save();
            Redirect::to('/')->send();
        }
        else
            Redirect::to('veriPass')->send();
    }

    public function authIp(Request $request){
        if(!Auth::check()){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.')</script>";
            return;
        }
        return view('member/authIp', [
            "js" => "",
            "css" => "mail.css",
            "ip"=>str_replace(",","",Auth::user()->accept_ip),
            "api_token"=>Auth::user()->api_token
        ]);
    }

    public function saveIP(Request $request){
        if(!Auth::check()){
            echo "<script>alert('로그아웃상태이므로 요청을 수락할수 없습니다.')</script>";
            return;
        }
        $user = Auth::user();
        $ip = trim($request->post("ip"));
        $ip_list = explode("\n",$ip);
        $newArr = array_splice($ip_list, 0, 10);
        $user->accept_ip = implode(",",$newArr);
        $user->save();
        Redirect::to('authIp')->send();
    }
}
