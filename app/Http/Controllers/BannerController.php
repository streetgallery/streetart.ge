<?php

namespace App\Http\Controllers;

use App;
use App\Image;
use App\Banner;
use DB;

use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = "banners";
        $items = Banner::orderBy('id', 'desc')->get();
        return view('admin.banners.index', compact("items", "menu"));
    }

    public function addGet()
    {
        $menu = "banners";
        return view('admin.banners.add', compact("menu"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'max:255',
            'name_en' => 'max:255',
            'description' => 'max:255',
            'description_en' => 'max:255',
            'link' => 'max:255',
        ]);

        $item = Banner::create($item);

        if(!is_null($item))
        {
            if ($request->has('images')) {
                $images = $request->images;
                $count=0;
                foreach($images as $each) {
                    $count++;
                    Image::where('filename',$each)->update(['item_id' => $item->id,'type' => "banner",'sort_num' => $count]);
                }
            }
            return redirect('admin/banners')->with('alert_ok', "Successfully Added");
        }

    }

    public function updateGet($id)
    {
        $menu = "banners";
        $item = Banner::find($id);

        return view('admin.banners.update', compact("menu", "item"));

    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => 'max:255',
            'name_en' => 'max:255',
            'description' => 'max:255',
            'description_en' => 'max:255',
            'link' => 'max:255',
            'sort' => 'numeric'
        ]);

        $item = Banner::find($id);
        $item->update($validation);
 
        if ($request->has('images')) {
            $images = $request->images;
            $count=0;
            foreach($images as $each)  {
                $count++;
                Image::where('filename',$each)->update(['item_id' => $item->id,'type' => "banner",'sort_num' => $count]);
            }
        }

        return back()->with('alert_ok', "Successfully Updated");

    }

    public function delete(Request $request)
    {
        $item = Banner::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");


    }

}
