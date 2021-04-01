<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbRoom extends Model
{
    use HasFactory;
    protected $table = "pb_room";
    const UPDATED_AT = NULL;
    protected $fillable = [
        'room_connect',
        "max_connect",
        "type",
        "super",
        "manager",
        "fixed_user",
        "blocked",
        "coin",
        "recommend",
        'roomIdx',
        'public',
        "bullet",
        "round"
    ];

    public function roomandpicture()
    {
        return $this->hasOne(User::class,"userIdKey","super" );
    }
}
