<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbBoard extends Model
{
    use HasFactory;
    protected $table  = "pb_board";

    protected $fillable=[
        "name",
        "category_use",
        "category",
        "isDeleted",
        "comment_use",
        "encoded_url",
        "recommend_use",
        "writter_use",
        "view_use",
        "content",
        "security",
        "reply_use",
        "nid",
        "writing_use"
    ];
}

