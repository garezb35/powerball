<?php

namespace App\Http\Controllers;
use App\Models\PbInbox;
use App\Models\PbMessage;
use App\Models\PbRoom;
use App\Models\PbView;
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
    protected $mail_count = 0;
    protected  $rooms = array();
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
                $this->mail_count = PbInbox::where('toId',Auth::user()->userId)->where("view_date",NULL)->get()->count();
            }

            $humor = PbMessage::with("comments")->where("type","humor")->orderBy("created_at","DESC")->limit(12)->get()->toArray();
            $photo = PbMessage::with("comments")->where("type","photo")->orderBy("created_at","DESC")->limit(14)->get()->toArray();
            $pick = PbMessage::with("comments")->where("type","pick")->orderBy("created_at","DESC")->limit(12)->get()->toArray();
            $free = PbMessage::with("comments")->where("type","free")->orderBy("created_at","DESC")->limit(12)->get()->toArray();
            $notice = PbMessage::where("type","notice")->orderBy("created_at","DESC")->limit(5)->get()->toArray();
            $days_ago = date('Y-m-d H:i:s', strtotime('-26  hours', strtotime("now")));
            $rooms = PbRoom::with(["roomandpicture.getLevel","roomandpicture.item_use"])->where("created_at",">",$days_ago)->orderBy("cur_win","DESC")->orderBy("cur_win","DESC")->limit(6)->get()->toArray();
            $this->rooms = $rooms;
            $userIdToken = !Auth::check() ? "" : Auth::user()->api_token;
            View::share('user_level', $this->user_level);
            View::share('next_level', $this->next);
            View::share('normal_level', $this->normal_exp);
            View::share('item_count', $this->item);
            View::share('mail_count', $this->mail_count);
            View::share('humor', $humor);
            View::share('photo', $photo);
            View::share('pick', $pick);
            View::share('free', $free);
            View::share('notice', $notice);
            View::share('rooms', $this->rooms);
            View::share('userIdToken', $userIdToken);
            return $next($request);
        });
    }
}
