<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomRecommend extends Model
{
    use HasFactory;
    protected $table = "room_recommend";
    protected $fillable = [
        "userId","roomIdx"
    ];
}
