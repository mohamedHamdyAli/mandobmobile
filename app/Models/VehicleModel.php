<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;
    protected $table = 'vehicle_models';
    protected $fillable = ['name_en', 'name_ar', 'vehicle_brand_id'];

    public function vehicle_brand(){
        return $this->belongsTo('App\Models\VehicleBrand','vehicle_brand_id','id');
    }

}
