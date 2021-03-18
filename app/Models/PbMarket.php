<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbMarket extends Model
{
    use HasFactory;
    protected $table = "pb_market";
    const CREATED_AT = 'created_date';
    const UPDATED_AT = null;
    protected $fillable = [
        'type',
        "name",
        "bonus",
        "description",
        "image",
        "hot_icon",
        "price",
        "price_type",
        "gift_used"
    ];

    public function mitem(){
        return $this->belongsTo(PbPurItem::class,"market_id","code");
    }
}
