<?php

namespace App\Models;

use App\Models\PbAutoMatch;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\CodeDetail;

class User extends Authenticatable
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
        'userIdKey'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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


}
