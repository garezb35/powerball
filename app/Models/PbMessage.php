<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbMessage extends Model
{
    use HasFactory;
    protected $table  = "pb_message";

    protected $fillable=[
        "toId",
        "fromId",
        "title",
        "content",
        "type",
        "category",
        "security",
        "notice",
        "reply",
        "keys"
    ];

    public function send_usr(){
        return  $this->hasOne(User::class,"userId","fromId");
    }
    public function received_usr(){
        return  $this->hasOne(User::classs,"userId","toId");
    }

    public function comments(){
        return $this->hasMany(PbComment::class,"messageId","id")->where("parent",0);
    }

    public function views(){
        return $this->hasMany(PbView::class,"postId","id");
    }

    public function recommend(){
        return $this->hasMany(PbRecommend::class,"postId","id");
    }
}
