<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Veichle extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'veichles';
    protected $fillable = ['name_en', 'name_ar', 'amount', 'max_num_km', 'extra_price'];
}
