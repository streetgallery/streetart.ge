<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'created_at',
        'updated_at'
    ];

    protected $table = 'subscribers';



}
