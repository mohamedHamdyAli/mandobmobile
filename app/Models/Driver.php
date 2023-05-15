<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Driver extends Authenticatable implements HasMedia
{
    use HasApiTokens, Notifiable , InteractsWithMedia;
    protected $table = 'drivers';
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'phone',
        'rate',
        'user_type',
        'veichle_type_id',
        'vehicle_brand_id',
        'vehicle_model_id',
        'vehicle_year',
        'vehicle_color_id',
        'vehicle_plate_number',
        'user_otp',
        'player_id',
        'zone_id',
        'address',
        'status',
        'is_featured',
        'time_zone',
        'last_notification_seen',
        'email_verified_at',
        'expire_at',

    ];
    protected $hidden = [
        'remember_token',
    ];


    public function roles(){
        return $this->belongsTo('App\Models\Roles','user_type','id');
    }
    public function zone_name(){
        return $this->belongsTo('App\Models\Zone','zone_id','id');
    }
    public function veichle_type(){
        return $this->belongsTo('App\Models\Veichle','veichle_type_id','id');
    }
    public function vehicle_brand(){
        return $this->belongsTo('App\Models\VehicleBrand','vehicle_brand_id','id');
    }
    public function vehicle_model(){
        return $this->belongsTo('App\Models\VehicleModel','vehicle_model_id','id');
    }
    public function vehicle_color(){
        return $this->belongsTo('App\Models\VehicleColor','vehicle_color_id','id');
    }
    public function routeNotificationForOneSignal(){
        return $this->player_id;
    }
}
