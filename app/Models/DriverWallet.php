<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverWallet extends Model
{
    use HasFactory;
    protected $table = 'driver_wallets';
    protected $fillable = [
        'wallet',
        'wallet_cost',
        'driver_id',
        'date',
        'time',
    ];
    public function driver(){
        return $this->belongsTo('App\Models\Driver','driver_id','id');
    }

}
