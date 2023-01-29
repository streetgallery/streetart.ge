<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'about',
        'firstname_en',
        'lastname_en',
        'username_en',
        'about_en',
        'artist',
        'email',
        'mobile',
        'country_id',
        'state_id',
        'city_id',
        'website',
        'facebook',
        'instagram',
        'behance',
        'dribbble',
        'bg_color',
        'group_role',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function images()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "user")->orderBy('sort_num');
    }

    public function country(){
        return $this->belongsTo('App\Country', 'country_id');
    }

    public function state(){
        return $this->belongsTo('App\State', 'state_id');
    }

    public function city(){
        return $this->belongsTo('App\City', 'city_id');
    }

}
