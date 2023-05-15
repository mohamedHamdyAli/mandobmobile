<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancellOrder extends Model
{
    use HasFactory;
    protected $table = 'cancell_orders';
    protected $guarded = [];
}
