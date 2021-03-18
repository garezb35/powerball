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
        'mny'
    ];

    public function itemusers(){
        return $this->hasOne(PbItemUse::class,"userId","userId");
    }
}
