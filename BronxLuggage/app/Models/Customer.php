<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $table = 'customer';
    
    protected $primaryKey = 'customer_id';

    public $timestamps= false;

    public $fillable = [
        'customer_name',
        'customer_password',
        'customer_email',
        'customer_phone',
        'customer_birthday',
        'customer_gender'
    ];

}