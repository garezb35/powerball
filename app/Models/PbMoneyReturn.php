<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbMoneyReturn extends Model
{
    use HasFactory;
    protected  $table = "pb_money_return";
    protected  $guarded = [
        "id",
        "created_at",
        "updated_at"
    ];

    public function user(){
        return $this->hasOne(User::class,"userId","userId");
    }
}
