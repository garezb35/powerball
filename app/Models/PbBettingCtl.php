<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbBettingCtl extends Model
{
    use HasFactory;
    protected $table = 'pb_betting_ctl';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    protected $fillable = [
        'userId',
        'round',
        'content',
        'game_type',
        'type',
        'status',
        'status1'
    ];
    public function room(){
        return $this->hasOne(PbRoom::class,"roomIdx","roomIdx");
    }
    public function user(){
        return $this->hasOne(User::class,"userId","userId");
    }
}
