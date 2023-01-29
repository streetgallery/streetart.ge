<?php

namespace App\Logic\Image;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Image;

class EventContentImageRepository
{
    public function upload($form_data)
    {
        $validator = Validator::make($form_data, Image::$rulesEventContent, Image::$messagesEventContent);
        if ($validator->fails()) {
            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);
        }
        $photo = $form_data['upload'];
        $originalName = $photo->getClientOriginalName();
        $extension = $photo->getClientOriginalExtension();
        $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);
        $filename = $this->sanitize($originalNameWithoutExt);

        // $form_data['item_id'] = 20;

        $path = public_path('files/events/' . $form_data['item_id'] );

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if(!File::isDirectory($path. "/content")){
            File::makeDirectory($path. "/content", 0777, true, true);
        }

        $allowed_filename = $this->createUniqueFilename($filename, $extension, $form_data['item_id']);
        $uploadSuccess1 = $this->original($photo, $allowed_filename, $form_data['item_id']);

        if (!$uploadSuccess1) {

            return Response::json([
                'error' => true,
                'message' => 'Server error while uploading',
                'code' => 500
            ], 500);

        }


        $sessionImage = new Image;
        $sessionImage->filename = $allowed_filename;
        $sessionImage->original_name = $originalName;

        if(isset($form_data['item_id'])){
            $sessionImage->item_id = $form_data['item_id'];
        }

        $sessionImage->type = "eventContent";
        $sessionImage->original = "/files/events/". $form_data['item_id'] . "/content/" . $allowed_filename;
        $sessionImage->save();

        $url = "/files/events/". $form_data['item_id'] ."/content/".$allowed_filename ;
        $message = "Image uploaded successfully";
        $function_number = $form_data['CKEditorFuncNum'];

        return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";

        /*
        return Response::json([
            'error' => false,
            'code' => 200,
            'filename' => $allowed_filename
        ], 200);
        */
    }

    public function createUniqueFilename($filename, $extension, $item_id)
    {
        $full_size_dir = public_path('files/events/'. $item_id .'/content/');
        $full_image_path = $full_size_dir . $filename . '.' . $extension;
        //if (File::exists($full_image_path)) {
        if (1) {
            // Generate token for image
            $imageToken = substr(sha1(uniqid()), 0, 15);
            //return $filename . '-' . $imageToken . '.' . $extension;
            return $imageToken . '.' . $extension;
        }
        return $filename . '.' . $extension;
    }

    public function original($photo, $filename, $item_id)
    {
        $manager = new ImageManager();
        $image = $manager->make($photo)->save(public_path('files/events/'. $item_id .'/content/') . $filename);
        return $image;
    }

    public function delete($filename,$item_id)
    {
        $original_dir = public_path('files/events/'. $item_id .'/content/');
        $sessionImage = Image::where('filename', $filename)->where('item_id', $item_id)->first();
        if (empty($sessionImage)) {
            return Response::json([
                'error' => true,
                'code' => 400
            ], 400);
        }
        $full_path1 = $original_dir . $sessionImage->filename;

        if (File::exists($full_path1)) {
            File::delete($full_path1);
        }

        if (!empty($sessionImage)) {
            $sessionImage->delete();
        }

        return Response::json([
            'error' => false,
            'code' => 200
        ], 200);
    }

    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
}