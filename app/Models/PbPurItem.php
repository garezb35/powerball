<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbPurItem extends Model
{
    use HasFactory;
    protected $table = 'pb_pur_item';
    const CREATED_AT = 'created_date';
    const UPDATED_AT = null;
    protected $fillable = [
        'userId',
        "market_id",
        "count"
    ];
    public function items(){
        return $this->hasOne(PbMarket::class,"code","market_id" );
    }
}
