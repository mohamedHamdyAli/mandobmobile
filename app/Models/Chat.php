<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chats';
    protected $fillable = [
        'user_id',
        'driver_id',
        'order_id',
        'message',
        'flag',
        'date',
        'time',
        'read',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function driver(){
        return $this->belongsTo('App\Models\Driver','driver_id','id');
    }


}
