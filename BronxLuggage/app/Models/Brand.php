<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $table = 'brand';
    
    protected $primaryKey = 'brand_id';

    public $timestamps= false;

    public $fillable = [
        'brand_name',
        'brand_description',
        'brand_status'
    ];


}