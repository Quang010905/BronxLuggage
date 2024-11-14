<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'product';

    protected $primaryKey = 'product_id';

    public $timestamps = false;

    public $fillable = [
        'product_name',
        'category_id',
        'brand_id',
        'product_description',
        'product_content',
        'product_price',
        'product_image',
        'product_status',
        'product_quantity'
    ];
    public function comment()
    {
        return $this->hasMany('App\Models\Comment');
    }
    
    public function images()
    {
        return $this->hasMany(ProductGallery::class);
    }
}
