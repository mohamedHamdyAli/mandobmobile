<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, Notifiable , InteractsWithMedia;

    protected $table = 'users';
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'phone',
        'wallet',
        'password',
        'user_type',
        'player_id',
        'contact_number',
        'address',
        'status',
        'user_otp',
        'zone_id',
        'expire_at',
        'is_featured',
        'time_zone',
        'last_notification_seen',
        'device_token',
        'email_verified_at',
        'device_key',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function roles(){
        return $this->belongsTo('App\Models\Roles','user_type','id');
    }
    public function zone(){
        return $this->belongsTo('App\Models\Zone','zone_id','id');
    }
}
