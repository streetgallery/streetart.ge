<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Slide extends Model
{

    protected $fillable = [
        'name',
        'name_en',
        'description',
        'description_en',
        'button',
        'button_en',
        'color',
        'bg_color',
        'link',
        'sort',
        'created_at',
        'updated_at'
    ];

    protected $table = 'slides';

    public function images()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "slide")->orderBy('sort_num');
    }


}




