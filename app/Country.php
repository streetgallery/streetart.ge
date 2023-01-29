<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable = [
        'sortname',
        'name',
        'name_en',
        'phonecode',
        'sort',
        'created_at',
        'updated_at'
    ];

    protected $table = 'countries';

    public function state()
    {
        return $this->hasMany('App\State', 'country_id')->orderBy('sort');
    }
    

}
