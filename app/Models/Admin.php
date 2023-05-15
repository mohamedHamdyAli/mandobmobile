<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Admin extends Authenticatable implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'admins';
    protected $guarded = [];


    protected $hidden = [
        'password' => 'remember_token',
    ];
}
