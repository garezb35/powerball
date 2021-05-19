<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbComment extends Model
{
    use HasFactory;
    protected $table = "pb_comment";

    protected $fillable = [
        "messageId",
        "userId",
        "parent",
        "content"
    ];

    public function suser(){
        return  $this->hasOne(User::class,"userId","userId");
    }
}
