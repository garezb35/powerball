<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbAuth extends Model
{
    use HasFactory;

    protected $table = "pb_auth";
    protected $fillable = [
        "phoneNumber",
        "auth_num"
    ];
}
