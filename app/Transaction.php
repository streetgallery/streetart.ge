<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'comment',
        'transactionid',
        'created_at',
        'updated_at'
    ];

    protected $table = 'transactions';
 
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

}




