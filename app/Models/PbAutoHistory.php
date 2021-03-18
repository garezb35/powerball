<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbAutoHistory extends Model
{
    use HasFactory;
    protected  $table = "pb_auto_history";
    public $timestamps = true;
    protected $fillable = [
        'day_round',
        'userId',
        'auto_kind',
        'auto_type',
        'is_win',
        'bet_amount'
    ];
}
