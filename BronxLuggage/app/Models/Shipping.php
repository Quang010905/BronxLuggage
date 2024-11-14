<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $table = 'shipping';
    
    protected $primaryKey = 'shipping_id';

    public $timestamps= false;

    public $fillable = [
        'shipping_name',
        'shipping_address',
        'shipping_phone',
        'shipping_email',
        'shipping_note'
    ];


}