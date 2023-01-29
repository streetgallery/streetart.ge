<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    protected $fillable = [
        'user_id',
        'action',
        'created_at',
        'updated_at'
    ];

    protected $table = 'logs';

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }


}




