<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Contact extends Model
{

    protected $fillable = [
        'name',
        'name_en',
        'description',
        'description_en',
        'content',
        'content_en',
        'facebook',
        'instagram',
        'created_at',
        'updated_at'
    ];

    protected $table = 'contact';

    public function images()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "contact")->inRandomOrder();
    }


}

