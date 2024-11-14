<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'order';
    
    protected $primaryKey = 'order_id';

    public $timestamps= false;

    public $fillable = [
        'customer_id',
        'shipping_id',
        'payment_id',
        'order_total',
        'order_status',
        'order_quantity'
    ];

}