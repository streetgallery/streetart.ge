<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Configuration extends Model
{

    protected $fillable = [
        'name',
        'name_en',
        'logo',
        'site_off',
        'bodystart',
        'created_at',
        'updated_at'
    ];

    protected $table = 'configuration';

    public function images()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "auth")->inRandomOrder();
    }

    public function blog_cover()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "blog_cover")->inRandomOrder();
    }
 
    public function event_cover()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "event_cover")->inRandomOrder();
    }


}

