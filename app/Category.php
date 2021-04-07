<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Category extends Model
{
     use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','parent_id','image', 'position'];

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


    
    /**
     * Get the index name for the model.
     *
     * @return string
    */
    public function childs() {
    	return $this->hasMany('App\Category','parent_id','id')->orderByRaw('-position DESC');
    }

    /**
     * The Products.
     *
     * @var array
     */ 
    /*public function products()
    {
        return $this->hasMany('App\Product');
    }*/
    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }
}
