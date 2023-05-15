<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverRate extends Model
{
    use HasFactory;
    protected $table = 'driver_rates';
    protected $fillable = [
        'rate',
        'user_id',
        'driver_id',
        'feedback',
        'user_type',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function driver(){
        return $this->belongsTo('App\Models\Driver','driver_id','id');
    }
}
