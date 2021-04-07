<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ordproduct extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'order_id', 'product_id', 'optid', 'name', 'image', 'qty', 'price', 'regprice', 'size', 'color',
    ];

    //link with products
    public function product()
    {
        return $this->belongsTo('App\Product', 'id');
    }
}
