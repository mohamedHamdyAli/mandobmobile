<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_request extends Model
{
    use HasFactory;
    protected $table = 'order_requests';
    protected $fillable = [
        'address_to',
        'lat_to',
        'long_to',
        'order_name',
        'order_id',
        'client_name',
        'phone',
        'block',
        'buliding_num',
        'road',
        'flat_office',
        'price',
    ];

    public function order(){
        return $this->belongsTo('App\Models\Order','order_id','id');
    }
}
