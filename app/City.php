<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */     
    protected $fillable = ['title', 'status'];

    /**
     * The Areas.
     *
     * @var array
     */ 
    public function areas()
    {
        return $this->hasMany('App\Area');
    }

    /**
     * The Areas.
     *
     * @var array
     */ 
    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }
}
