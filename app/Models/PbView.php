<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbView extends Model
{
    use HasFactory;

    protected $table = "pb_view";

    protected $fillable= [
        "ip",
        "postId"
    ];
}
