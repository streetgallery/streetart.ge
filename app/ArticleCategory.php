<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class ArticleCategory extends Model
{

    protected $fillable = [
        'name',
        'name_en',
        'sort',
        'created_at',
        'updated_at'
    ];

    protected $table = 'article_categories';

}


