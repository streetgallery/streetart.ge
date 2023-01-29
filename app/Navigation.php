<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'link',
        'parent_id',
        'navigation',
        'sort',
        'created_at',
        'updated_at'
    ];

    protected $table = 'navigation';

    public function parent()
    {
        return $this->hasMany('App\Navigation', 'parent_id')->orderBy('sort');
    }


    public function parentGet(){
        return $this->belongsTo('App\Navigation', 'parent_id');
    }

}
