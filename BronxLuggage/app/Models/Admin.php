<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $table = 'admin';
    
    protected $primaryKey = 'id';

    public $timestamps= false;

    public $fillable = [
        'email',
        'password',
        'name',
        'phone'
    ];

}