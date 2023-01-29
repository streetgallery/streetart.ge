<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $fillable = [
        'name',
        'name_en',
        'state_id',
        'sort',
        'created_at',
        'updated_at'
    ];

    protected $table = 'cities';
    
    public function locations()
    {
        return $this->hasMany('App\Location', 'city_id')->orderBy('sort');
    }

    public function state(){
        return $this->belongsTo('App\State', 'state_id');
    }

}
