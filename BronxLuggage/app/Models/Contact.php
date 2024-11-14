<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Contact extends Model
{
    public $table = 'contact';
    
    protected $primaryKey = 'contact_id';

    public $timestamps= false;

    public $fillable = [
        'customer_id',
        'contact_customername',
        'contact_customeremail',
        'contact_subject',
        'contact_message',
    ];

}