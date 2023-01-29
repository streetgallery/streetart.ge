<?php

namespace App\Logic\Image;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Image;

class UserImageRepository
{
    public function upload($form_data)
    {
        $validator = Validator::make($form_data, Image::$rules, Image::$messages);
        if ($validator->fails()) {
            return Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);
        }
        $photo = $form_data['file'];
        $originalName = $photo->getClientOriginalName();
        $extension = $photo->getClientOriginalExtension();
        $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);
        $filename = $this->sanitize($originalNameWithoutExt);

        $path = public_path('files/users/' .$form_data['item_id'] );

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        if(!File::isDirectory($path. "/original")){
            File::makeDirectory($path. "/original", 0777, true, true);
        }

        if(!File::isDirectory($path. "/medium")){
            File::makeDirectory($path. "/medium", 0777, true, true);
        }

        if(!File::isDirectory($path. "/small")){
            File::makeDirectory($path. "/small", 0777, true, true);
        }


        $allowed_filename = $this->createUniqueFilename($filename, $extension, $form_data['item_id']);
        $uploadSuccess1 = $this->original($photo, $allowed_filename, $form_data['item_id']);
        $uploadSuccess2 = $this->medium($photo, $allowed_filename, $form_data['item_id']);
        $uploadSuccess3 = $this->small($photo, $allowed_filename, $form_data['item_id']);

        if (!$uploadSuccess1 || !$uploadSuccess2 || !$uploadSuccess3) {
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
        if(isset($form_data['type'])){
            $sessionImage->type = $form_data['type'];
        }
        $sessionImage->original = "/files/users/". $form_data['item_id'] . "/original/" . $allowed_filename;
        $sessionImage->medium   = "/files/users/". $form_data['item_id'] . "/medium/" . $allowed_filename;
        $sessionImage->small    = "/files/users/". $form_data['item_id'] . "/small/" . $allowed_filename;
        $sessionImage->save();
        return Response::json([
            'error' => false,
            'code' => 200,
            'filename' => $allowed_filename
        ], 200);
    }

    public function createUniqueFilename($filename, $extension, $item_id)
    {
        $full_size_dir = public_path('files/users/'. $item_id .'/original/');
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
        $image = $manager->make($photo)->save(public_path('files/users/'. $item_id .'/original/') . $filename);
        return $image;
    }

    public function medium($photo, $filename, $item_id)
    {
        $manager = new ImageManager();
        $image = $manager->make($photo)->resize(700, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path('files/users/'. $item_id .'/medium/') . $filename);
        return $image;
    }

    public function small($photo, $filename, $item_id)
    {
        $manager = new ImageManager();
        $image = $manager->make($photo)->fit(350, 350)
            ->save(public_path('files/users/'. $item_id .'/small/') . $filename);
        return $image;
    }

    public function delete($filename,$item_id,$type)
    {
        $original_dir = public_path('files/users/'. $item_id .'/original/');
        $medium_dir = public_path('files/users/'. $item_id .'/medium/') ;
        $small_dir = public_path('files/users/'. $item_id .'/small/') ;

        $sessionImage = Image::where('type', $type)->where('filename', $filename)->where('item_id', $item_id)->first();

        if (empty($sessionImage)) {
            return Response::json([
                'error' => true,
                'code' => 400
            ], 400);
        }
        $full_path1 = $original_dir . $sessionImage->filename;
        $full_path2 = $medium_dir . $sessionImage->filename;
        $full_path3 = $small_dir . $sessionImage->filename;

        if (File::exists($full_path1)) {
            File::delete($full_path1);
        }
        if (File::exists($full_path2)) {
            File::delete($full_path2);
        }
        if (File::exists($full_path3)) {
            File::delete($full_path3);
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