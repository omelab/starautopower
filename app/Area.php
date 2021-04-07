<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['title', 'city_id', 'time_list', 
    'delivery_charge', 'status'];


    /**
     * Get the cities for the model.
     *
     * @return string
    */
    public function city()
    {
        return $this->belongsTo('App\City');
    }


    /**
     * The Areas.
     *
     * @var array
     */ 
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
