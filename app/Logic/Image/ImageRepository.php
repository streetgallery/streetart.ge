<?php

namespace App\Logic\Image;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use App\Image;

class ImageRepository
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
        $allowed_filename = $this->createUniqueFilename($filename, $extension);
        $uploadSuccess1 = $this->original($photo, $allowed_filename);
        $uploadSuccess2 = $this->medium($photo, $allowed_filename);
        $uploadSuccess3 = $this->small($photo, $allowed_filename);
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
        $sessionImage->original = "/files/articles/original/" . $allowed_filename;
        $sessionImage->medium = "/files/articles/medium/" . $allowed_filename;
        $sessionImage->small = "/files/articles/small/" . $allowed_filename;
        $sessionImage->save();
        return Response::json([
            'error' => false,
            'code' => 200,
            'filename' => $allowed_filename
        ], 200);
    }


    public function createUniqueFilename($filename, $extension)
    {
        $full_size_dir = Config::get('images.original');
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

    public function original($photo, $filename)
    {
        $manager = new ImageManager();
        $image = $manager->make($photo)->save(Config::get('images.original') . $filename);
        return $image;
    }

    public function medium($photo, $filename)
    {
        $manager = new ImageManager();
        $image = $manager->make($photo)->resize(700, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(Config::get('images.medium') . $filename);
        return $image;
    }

    public function small($photo, $filename)
    {
        $manager = new ImageManager();
          $image = $manager->make($photo)->fit(200, 200)
              ->save(Config::get('images.small') . $filename);
        return $image;
    }
    
    public function delete($filename)
    {
        $original_dir = Config::get('images.original');
        $medium_dir = Config::get('images.medium');
        $small_dir = Config::get('images.small');
        $sessionImage = Image::where('filename', 'like', $filename)->first();
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