<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
     
    public static $rules = [
        'file' => 'required|mimes:png,gif,jpeg,jpg',
        'item_id' => '',
        'type' => ''
    ];


    public static $messages = [
        'file.mimes' => 'Uploaded file is not in image format',
        'file.required' => 'Image is required'
    ];


    // product
    public static $rulesProductContent = [
        'upload' => 'required|mimes:png,gif,jpeg,jpg',
        'item_id' => '',
        'type' => ''
    ];

    public static $messagesProductContent = [
        'upload.mimes' => 'Uploaded file is not in image format',
        'upload.required' => 'png,gif,jpeg,jpg is required'
    ];

    

    // event
    public static $rulesEventContent = [
        'upload' => 'required|mimes:png,gif,jpeg,jpg',
        'item_id' => '',
        'type' => ''
    ];

    public static $messagesEventContent = [
        'upload.mimes' => 'Uploaded file is not in image format',
        'upload.required' => 'png,gif,jpeg,jpg is required'
    ];



}