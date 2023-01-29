<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    protected $fillable = [
        'name',
        'name_en',
        'city_id',
        'latitude',
        'longitude',
        'sort',
        'created_at',
        'updated_at'
    ];

    protected $table = 'locations';

    public function city(){
        return $this->belongsTo('App\City', 'city_id');
    }

    public function images()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "location")->orderBy('sort_num');
    }

    
    public function projects()
    {
        return $this->hasMany('App\Product', 'location_id')->where('status', 1)->orderBy('id');
    }

}
