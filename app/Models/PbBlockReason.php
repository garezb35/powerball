<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbBlockReason extends Model
{
    use HasFactory;
    protected $table = "tbl_block_reason";
    protected $guarded = [];

    public function suser(){
        return  $this->hasOne(User::class,"userId","userId");
    }
}
