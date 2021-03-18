<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbBettingCtl extends Model
{
    use HasFactory;
    protected $table = 'pb_betting_ctl';
    protected $fillable = [
        'userId',
        'round',
        'content',
        'game_type',
        'type'
    ];
}
