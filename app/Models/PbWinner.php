<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbWinner extends Model
{
    use HasFactory;
    protected $table = "pb_winner";
    protected $fillable = [
        "userId",
        "order",
        "old_order"
    ];

    public  function user(){
        return $this->hasOne(User::class,"userId","userId");
    }
}
