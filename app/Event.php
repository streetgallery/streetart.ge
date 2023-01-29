<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Event extends Model
{

    protected $fillable = [
        'name',
        'name_en',
        'content',
        'content_en',
        'keywords',
        'keywords_en',
        'description',
        'description_en',
        'views',
        'user_id',
        'artist_id',
        'location_id',
        'status',
        'facebook',
        'instagram',
        'youtube',
        'event_date',
        'created_at',
        'updated_at'
    ];

    protected $table = 'events';

    protected $dates = ['event_date'];


    public function artist(){
        return $this->belongsTo('App\User', 'artist_id');
    }

    public function location(){
        return $this->belongsTo('App\Location', 'location_id');
    }

 


    public function images()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "event")->orderBy('sort_num');
    }


    public function contentImages()
    {
        return $this->hasMany('App\Image', 'item_id')->where('type', "eventContent")->orderBy('sort_num');
    }

}




