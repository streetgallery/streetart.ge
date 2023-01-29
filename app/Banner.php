<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Banner extends Model
{

    protected $fillable = [
        'name',
        'link',
        'created_at',
        'updated_at'
    ];

    protected $table = 'banners';

    public function images()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "banner")->orderBy('sort_num');
    }
    
}




