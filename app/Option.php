<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{ 
    protected $fillable = ['product_id', 'size', 'color', 'regular_price', 'sales_price', 'quantity', 'images'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

}
