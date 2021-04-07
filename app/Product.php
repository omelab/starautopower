<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use Sluggable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','sku','image','detail','regular_price','sale_price', 'price_unit', 'cat_id', 'city_id', 'is_home', 'status',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ]
        ];
    } 

    // Category Relational
    public function categories()
    {
        return $this->belongsToMany('App\Category')->withTimestamps();
    }

    //City Relational
    public function cities()
    {
        return $this->belongsToMany('App\City')->withTimestamps();
    }

    //Get Images
    public function images(){
        return $this->hasMany('App\ProductImage');
    }

    //Products Options
    public function options(){
        return $this->hasMany('App\Option');
    }
}
