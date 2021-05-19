<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbLog extends Model
{
    use HasFactory;
    protected $table = 'pb_log';
    protected $fillable = [
        'type',
        "content",
        "userId",
        "ip",
        "fromId",
        "toId"
    ];

    public function send_usr(){
        return  $this->hasOne(User::class,"userId","fromId");
    }
    public function received_usr(){
        return  $this->hasOne(User::class,"userId","toId");
    }
}
