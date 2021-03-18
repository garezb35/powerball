<?php

namespace App\Http\Controllers;

use App\Models\CodeDetail;
use App\Models\PbPurItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;

class MemberController extends Controller
{
    //
    public function index(Request $request){

        if(!Auth::check()){
            echo "<script>alert('잘못된 접속입니다.')</script>";
            return;
        }
        $user= Auth::user();
        $type = empty($request->type) ? "mine" : $request->type;
        switch ($type){
            case "mine";
                return view('member/powerball-mypage', [   "js" => "",
                                                                "css" => "member.css"
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
}
