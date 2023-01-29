<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Exhibition extends Model
{

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'mobile',
        'name',
        'about_you',
        'about_exhibition',
        'category',
        'importent_type',
        'link',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $table = 'exhibitions';

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }


}




