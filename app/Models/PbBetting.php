<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbBetting extends Model
{
    use HasFactory;
    protected $table = 'pb_betting';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    protected $fillable = [
        'round',
        'game_type',
        'type',
        'game_code',
        'pick',
        'is_win',
        'changed'
    ];
}
