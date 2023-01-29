<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'country_id',
        'sort',
        'created_at',
        'updated_at'
    ];

    protected $table = 'states';


    public function cities()
    {
        return $this->hasMany('App\City', 'state_id')->orderBy('sort');
    }

    public function country(){
        return $this->belongsTo('App\Country', 'country_id');
    }

}