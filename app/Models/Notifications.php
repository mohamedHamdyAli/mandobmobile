<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $fillable = [
        'title',
        'title_ar',
        'body',
        'body_ar',
        'user_id',
        'driver_id',
        'order_id',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function driver(){
        return $this->belongsTo('App\Models\Driver','driver_id','id');
    }
}
