<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbAutoSetting extends Model
{
    use HasFactory;
    protected $table = "pb_auto_setting";
    protected $fillable = [
        'userId',
        'start_amount',
        'user_amount',
        'start_round',
        'end_round',
        'current_round',
        'betting_type',
        'martin',
        'step',
        'mny',
        'win_limit',
        'lost_limit',
        "w1",
        "w2",
        "w3",
        "w4",
        "rest1",
        "rest2",
        "rest3",
        "rest4",
        "bet_amount"
    ];

    public function itemusers(){
        return $this->hasOne(PbItemUse::class,"userId","userId");
    }

    public function game(){
        return $this->hasMany(PbAutoMatch::class,"userId","userId")->where("state",1)->where("auto_pattern","!=",NULL);
    }
    public function winlose(){
        return $this->hasMany(PbWinLose::class,"userId","userId");
    }
}
