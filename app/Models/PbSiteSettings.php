<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PbSiteSettings extends Model
{
    use HasFactory;

    protected $table = "pb_site_settings";
    protected $guarded= [];
}
