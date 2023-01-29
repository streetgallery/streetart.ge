<?php

namespace App\Http\Controllers;

use App\Image;

use Illuminate\Support\Facades\Storage;
use App\Logic\Image\ImageRepository;
use App\Logic\Image\ArticleImageRepository;
use App\Logic\Image\ArticleContentImageRepository;
use App\Logic\Image\UserImageRepository;
use App\Logic\Image\ProductImageRepository;
use App\Logic\Image\ProductContentImageRepository;
use App\Logic\Image\EventImageRepository;
use App\Logic\Image\EventContentImageRepository;
use App\Logic\Image\AvatarImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


class ImageController extends Controller
{
    //protected $image;

    /*
    public function __construct(ImageRepository $imageRepository)
    {
        $this->image = $imageRepository;
    }
    */

    // files
    public function fileUpload(Request $request, ImageRepository $imageRepository)
    {
        $photo = $request->all();
        $response = $imageRepository->upload($photo);
        return $response;
    }

    public function deleteUpload(Request $request,ImageRepository $imageRepository)
    {
        $this->image = $imageRepository;

        $id = $request->id;
        if(!$id)
        {
            return 0;
        }
         $response = $this->image->delete( $id );

        return $response;
    }
    // end files


    // article
    public function articleUpload(Request $request, ArticleImageRepository $articleImageRepository)
    {
        $photo = $request->all();
        $response = $articleImageRepository->upload($photo);
        return $response;
    }

    public function articleContentUpload(Request $request, ArticleContentImageRepository $articleContentImageRepository)
    {
        $photo = $request->all();
        $response = $articleContentImageRepository->upload($photo);
        return $response;
    }

    public function deleteArticle(Request $request, ArticleImageRepository $articleImageRepository)
    {
        $file_name = $request->file_name;
        $item_id = $request->item_id;
        if(!$file_name)
        {
            return 0;
        }
        $response = $articleImageRepository->delete($file_name,$item_id );
        return $response;
    }
    // end article



    // user
    public function userUpload(Request $request, UserImageRepository $userImageRepository)
    {
        $photo = $request->all();
        $response = $userImageRepository->upload($photo);
        return $response;
    }

    public function deleteUser(Request $request,UserImageRepository $userImageRepository)
    {

        $file_name = $request->file_name;
        $item_id = $request->item_id;
        $type = $request->type;
        if(!$file_name)
        {
            return 0;
        }

        $response = $userImageRepository->delete($file_name,$item_id,$type );

        return $response;
    }
    // user


    // product
    public function productUpload(Request $request, ProductImageRepository $productImageRepository)
    {
        $photo = $request->all();
        $response = $productImageRepository->upload($photo);
        return $response;
    }

    public function productContentUpload(Request $request, ProductContentImageRepository $productContentImageRepository)
    {
        $photo = $request->all();
        $response = $productContentImageRepository->upload($photo);
        return $response;
    }

    public function deleteProduct(Request $request,ProductImageRepository $productImageRepository)
    {

        $file_name = $request->file_name;
        $item_id = $request->item_id;
        $type = $request->type;
        if(!$file_name)
        {
            return 0;
        }

        $response = $productImageRepository->delete($file_name,$item_id,$type );

        return $response;
    }
    // end product


    // event
    public function eventUpload(Request $request, EventImageRepository $eventImageRepository)
    {
        $photo = $request->all();
        $response = $eventImageRepository->upload($photo);
        return $response;
    }

    public function EventContentUpload(Request $request, EventContentImageRepository $eventContentImageRepository)
    {
        $photo = $request->all();
        $response = $eventContentImageRepository->upload($photo);
        return $response;
    }

    public function deleteEvent(Request $request,EventImageRepository $eventImageRepository)
    {

        $file_name = $request->file_name;
        $item_id = $request->item_id;
        if(!$file_name)
        {
            return 0;
        }

        $response = $eventImageRepository->delete($file_name,$item_id );

        return $response;
    }
    // end event




    // user
    public function avatarUpload(Request $request, AvatarImageRepository $avatarImageRepository)
    {
        $photo = $request->all();
        $response = $avatarImageRepository->upload($photo);
        return $response;
    }
    // user



}
