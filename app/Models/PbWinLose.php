<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbWinLose extends Model
{
    use HasFactory;
    protected $table = "pb_win_lose";
    protected $guarded = [];
}
