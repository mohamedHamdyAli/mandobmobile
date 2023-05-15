<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverAccept extends Model
{
    use HasFactory;
        protected $table = 'drivers_accept';
        protected $fillable = [
            'order_id',
            'driver_id',
            'status',
        ];
}
