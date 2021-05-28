<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbPrison extends Model
{
    use HasFactory;
    protected $table = "pb_prison";
    protected  $fillable = [
        "userId",
        "reason"
    ];
}
