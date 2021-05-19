<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbRecommend extends Model
{
    use HasFactory;
    protected $table = "pb_recommend";
    protected $fillable = [
        "userId",
        "postId"
    ];
}
