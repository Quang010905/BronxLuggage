<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'category';
    
    protected $primaryKey = 'category_id';

    public $timestamps= false;

    public $fillable = [
        'category_name',
        'category_description',
        'category_status'
    ];

}