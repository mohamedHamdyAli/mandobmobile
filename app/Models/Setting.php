<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'settings';
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'instgram_url',
        'youtube_url',
        'Help_number',
        'email',
        'currency',
        'wallet_user',
        'wallet_driver',
        'wallet_driver_completed',
    ];
}
