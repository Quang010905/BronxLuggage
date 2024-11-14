<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $table = 'shoppingcart';

    protected $primaryKey = 'cart_id';

    public $timestamps = false;

    public $fillable = [
        'cart_name',
        'cart_price',
        'cart_image',
        'cart_quantity',
        'customer_id',
        'product_id'
    ];

 
}
