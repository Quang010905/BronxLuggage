<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $table = 'payment';
    
    protected $primaryKey = 'payment_id';

    public $timestamps= false;

    public $fillable = [
        'payment_method',
        'payment_status'
    ];

}