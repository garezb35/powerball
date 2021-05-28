<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbIpBlocked extends Model
{
    use HasFactory;
    protected $table  ="pb_ip_blocked";
    protected $fillable = ["ip"];
}
