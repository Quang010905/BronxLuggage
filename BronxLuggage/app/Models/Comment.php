<?php



namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $table = 'comment';

    protected $primaryKey = 'comment_id';
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'comment_product');
    }
}
