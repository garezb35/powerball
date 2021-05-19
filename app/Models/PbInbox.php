<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbInbox extends Model
{
    use HasFactory;
    protected $table = "pb_inbox";
    protected $fillable = [
        'fromId',
        "toId",
        "content",
        "state",
        "report",
        "mail_type",
        "view_date"
    ];

    public function received_usr(){
        return $this->hasOne(User::class,"userId","toId");
    }
    public function send_usr(){
        return $this->hasOne(User::class,"userId","fromId");
    }
}
