<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    protected $table = 'product_image';

    protected $primaryKey = 'details_id';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'details_name',
        'details_image'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
