<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbWinGift extends Model
{
    use HasFactory;
    protected $table = "pb_win_gift";
    protected $fillable = [
        "order",
        "market_id",
        "count"
    ];
}
