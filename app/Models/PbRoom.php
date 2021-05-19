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
        "round",
        "password",
        "userId",
        "win_date",
        "cur_win",
        "badge",
        "badge_date"
    ];

    public function roomandpicture()
    {
        return $this->hasOne(User::class,"userIdKey","super" );
    }

    public function winitem(){
        return $this->hasOne(PbItemUse::class,"userId","userId" )
            ->where("terms2" ,">",date("Y-m-d H:i:s"))
            ->where("terms1" ,"<=",date("Y-m-d H:i:s"))
            ->where("market_id","ORDER_HONOR_30");
    }
}
