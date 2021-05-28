<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbBank extends Model
{
    use HasFactory;
    protected $table = "pb_bank";
    protected $fillable = [
        "name",
        "status"
    ];
}
