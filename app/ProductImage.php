<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'filename'];

   	public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
