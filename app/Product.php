<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{

    protected $fillable = [
        'name',
        'name_en',
        'content',
        'content_en',
        'keywords',
        'keywords_en',
        'description',
        'description_en',
        'category_id',
        'views',
        'user_id',
        'artist_id',
        'status',
        'city_id',
        'latitude',
        'longitude',
        'if_not_location',
        'location_id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'products';

    public function category(){
        return $this->belongsTo('App\ProductCategory', 'category_id');
    }

    public function artist(){
        return $this->belongsTo('App\User', 'artist_id');
    }
    public function location(){
        return $this->belongsTo('App\Location', 'location_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function images()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "product")->orderBy('sort_num');
    }

    public function contentImages()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "productContent")->orderBy('sort_num');
    }


}




