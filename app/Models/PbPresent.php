<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbPresent extends Model
{
    use HasFactory;
    protected $table = "pb_present";
    protected $fillable = [
        "userId",
        "result",
        "perfectatt",
        "comment"
    ];

    public function user(){
        return $this->hasOne(User::class,"userId","userId");
    }
}
