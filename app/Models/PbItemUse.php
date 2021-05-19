<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbItemUse extends Model
{
    use HasFactory;
    protected  $table = "pb_item_use";
    const CREATED_AT = 'created_date';
    const UPDATED_AT = NULL;
    protected $fillable = [
        'userId',
        "market_id",
        "terms1",
        "terms2",
        "terms_type"
    ];

    public function item(){
        return $this->hasOne(PbMarket::class,"code","market_id");
    }
}
