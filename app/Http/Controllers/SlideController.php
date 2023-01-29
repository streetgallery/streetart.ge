<?php

namespace App\Http\Controllers;

use App;
use App\Image;
use App\Slide;
use DB;

use Illuminate\Http\Request;

class SlideController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = "slides";
        $items = Slide::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        return view('admin.slides.index', compact("items", "menu"));
    }

    public function addGet()
    {
        $menu = "slides";
        return view('admin.slides.add', compact("menu"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'max:255',
            'name_en' => 'max:255',
            'description' => 'max:255',
            'description_en' => 'max:255',
            'button' => 'max:255',
            'button_en' => 'max:255',
            'color' => 'max:255',
            'bg_color' => 'max:255',
            'link' => 'max:255',
            'sort' => 'numeric'
        ]);

        $item = Slide::create($item);

        if(!is_null($item))
        {

            if ($request->has('images')) {

                $images = $request->images;
                $count=0;
                foreach($images as $each) {
                    $count++;
                    Image::where('filename',$each)->update(['item_id' => $item->id,'type' => "slide",'sort_num' => $count]);
                }
            }




            return redirect('admin/slides')->with('alert_ok', "Successfully Added");
        }

    }

    public function updateGet($id)
    {
        $menu = "slides";
        $item = Slide::find($id);
        return view('admin.slides.update', compact("menu", "item"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => 'max:255',
            'name_en' => 'max:255',
            'description' => 'max:255',
            'description_en' => 'max:255',
            'button' => 'max:255',
            'button_en' => 'max:255',
            'color' => 'max:255',
            'bg_color' => 'max:255',
            'link' => 'max:255',
            'sort' => 'numeric'
        ]);

        $item = Slide::find($id);
        $item->update($validation);

        if(!is_null($item))
        {
            if ($request->has('images')) {
                $images = $request->images;
                $count=0;
                foreach($images as $each)  {
                    $count++;
                    Image::where('filename',$each)->update(['item_id' => $item->id,'type' => "slide",'sort_num' => $count]);
                }
            }
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = Slide::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");


    }

}
