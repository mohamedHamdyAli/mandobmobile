<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverCancel extends Model
{
    use HasFactory;
    protected $table = 'driver_cancel';
    protected $fillable = [
        'order_id',
        'driver_id',
        'status',
        'user_id',
    ];
    public function order(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }
    public function driver(){
        return $this->belongsTo('App\Models\Driver','driver_id','id');
    }
    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
