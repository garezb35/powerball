<?php

namespace App\Models;

use App\Models\CodeDetail;
use App\Models\PbAutoMatch;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends \TCG\Voyager\Models\User
{
    protected $table = 'pb_users';
    protected $primaryKey = 'userId';

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loginId',
        'nickname',
        'name',
        'email',
        'password',
        'phoneNumber',
        'api_token',
        'old_nickname',
        'userIdKey',
        'win_date',
        'fixed',
        'frd_list',
        'bet_number',
        'bet_date',
        'bet_number1',
        'bet_date1',
        'bet_number2',
        'bet_date2',
        'bet_number3',
        'bet_date3',
        'bet_number4',
        'bet_date4',
        'badge',
        "ip",
        "second_password",
        "second_active",
        "second_use",
        "except_ip"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function getUserClass(){
        return $this->hasOne(CodeDetail::class,"code","level");
    }

    /* 유저 급수 */
    public function getLevel(){
        return $this->getUserClass()->where('class','=', '0020');
    }

    /* 유저 형태 */
    public function getUserType(){
        return $this->getUserClass()->where('class','=', '0010');
    }

    public function getAutoMatches(){
        return $this->hasMany(PbAutoMatch::class,"userid","userId");
    }

    public function item(){
        return $this->hasMany(PbPurItem::class,"userId","userId");
    }

    public function blocked(){
        return $this->hasOne(PbIpBlocked::class,"ip","ip");
    }

    public function errorUser(){
        return $this->hasOne(PbPrison::class,"userId","userId");
    }

    public function item_use(){
        return $this->hasMany(PbItemUse::class,"userId","userId")
            ->where("terms1","<=",date("Y-m-d H:i:s"))
            ->where("terms2",">",date("Y-m-d H:i:s"))
            ->where("market_id","ORDER_HONOR_30");
    }
}
