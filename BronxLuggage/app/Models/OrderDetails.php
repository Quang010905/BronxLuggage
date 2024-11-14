<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    public $table = 'orderdetails';
    
    protected $primaryKey = 'order_details_id';

    public $timestamps= false;

    public $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'product_sales_quantity'
    ];

}