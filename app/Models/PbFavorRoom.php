<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbFavorRoom extends Model
{
    use HasFactory;
    protected $table = "pb_favor_room";
    protected $fillable = ["userId","roomIdx"];
}
