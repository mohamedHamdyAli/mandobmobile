<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'address_from',
        'lat_from',
        'long_from',
        'note',
        'user_id',
        'zone_id',
        'status',
        'total_cost',
        'pick_up_type',
        'order_date',
        'order_time',
        'activity_type_ids',
        'veichle_type_id',
        'cancell_details',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function veichle_type(){
        return $this->belongsTo('App\Models\Veichle','veichle_type_id','id');
    }
    public function activity_type(){
        return $this->belongsTo('App\Models\Activity','activity_type_ids','id');
    }
    public function zone(){
        return $this->belongsTo('App\Models\Zone','zone_id','id');
    }
    public function cancell(){
        return $this->belongsTo('App\Models\CancellOrder','cancell_details','id');
    }
}
