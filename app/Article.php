<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Article extends Model
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
        'status',
        'created_at',
        'updated_at'
    ];

    protected $table = 'articles';

    public function category(){
        return $this->belongsTo('App\ArticleCategory', 'category_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function images()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "article")->orderBy('sort_num');
    }


    public function contentImages()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "articleContent")->orderBy('sort_num');
    }


}




