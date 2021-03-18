<?php

namespace App\Http\Controllers;

use App\Models\CodeDetail;
use App\Models\User;
use Illuminate\Http\Request;

class ExpController extends Controller
{
    protected $user;
    protected $user_level;
    protected $next = 0;
    protected $normal_exp = 0;
    protected  $item = 0;
    protected $next_code = "";
    protected $userId = 0;
    protected $exp = 0;
    public function __construct($userId,$exp)
    {
        $this->userId = $userId;
        $this->exp = $exp;
        if($userId > 0 && $exp > 0 ){
            $this->user = new User;
            $codedetail = new CodeDetail;
            $this->user_level = $this->user->find($userId)->getLevel()->get()->toArray();
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
        }
    }

    public function CheckNextLevel(){
        if($this->next > 0 && $this->userId > 0  && $this->exp > 0 && $this->next_code!=""){
            if($this->exp > $this->next)
            {
                $user = User::find($this->userId);
                $user->level = $this->next_code;
                $user->save();
            }
        }
    }
}
