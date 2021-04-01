<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pb_Result_Powerball extends Model
{
    use HasFactory;
    protected $table = 'pb_result_powerball';

    public function bettingData(){
        return $this->hasOne(PbBettingCtl::class,"round","day_round")->where("type",2)->where("roomIdx","!=","");
    }
}
