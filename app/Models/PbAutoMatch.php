<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbAutoMatch extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected  $table = "tbl_auto_match";
    // protected $fillable = [
    //     'userid',
    //     'auto_type',
    //     'auto_kind',
    //     'auto_index',
    //     'auto_step',
    //     'auto_start',
    //     'auto_train',
    //     'auto_last_step',
    //     'auto_pattern',
    //     'money',
    //     'auto_oppo',
    //     'process_count',
    //     'state',
    //     "process_pattern",
    //     "past_step",
    //     "past_cruiser",
    //     "past_pattern"
    // ];

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'userId', 'userId');
    }
}
