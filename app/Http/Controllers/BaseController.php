<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\CodeDetail;
use App\Models\PbPurItem;
use Illuminate\Support\Facades\Auth;
use View;


class BaseController  extends Controller
{
    protected $user;
    protected $user_level;
    protected $next = 0;
    protected $normal_exp = 0;
    protected  $item = 0;
    protected $next_code = "";
    public function  __construct(){
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                $this->user = new User;
                $codedetail = new CodeDetail;
                $this->user_level = $this->user->find(Auth::user()->userId)->getLevel()->get()->toArray();
                if (!empty($this->user_level)) {
                    $temp = $codedetail->where("class", "0020")->where("code", sprintf("%02d", intval($this->user_level[0]["code"])))->get()->first();
                    $this->normal_exp = empty($temp) ? $this->user_level[0]["value1"] : $temp["value1"];
                    $next_code = intval($this->user_level[0]["code"]) + 1;
                    $temp = $codedetail->where("class", "0020")->where("code", sprintf("%02d", $next_code))->where("value2",0)->get()->first();
                    $this->next = empty($temp) ? 0 : $temp["value1"];
                    $this->next_code = empty($temp) ? 0 : $temp["code"];
                } else {
                    $this->next = 0;
                }
                $this->item = PbPurItem::where("userId",Auth::id())->where("active",1)->sum("count");
            }
            View::share('user_level', $this->user_level);
            View::share('next_level', $this->next);
            View::share('normal_level', $this->normal_exp);
            View::share('item_count', $this->item);
            return $next($request);
        });
    }
}
