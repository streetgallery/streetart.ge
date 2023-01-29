<?php

namespace App\Http\Controllers;

use App;
use App\Image;
use App\Product;
use App\ProductCategory;
use App\Configuration;
use App\Contact;
use App\Location;
use App\User;
use DB;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = "projects";
        $items = Product::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(30);
        return view('admin.products.index', compact("items", "menu"));
    }

    public function addGet()
    {
        $menu = "projects";
        $categories = ProductCategory::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $artists = User::where('artist', 1)->orderBy('lastName', 'asc')->get();

        return view('admin.products.add', compact("menu","artists", "categories"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'required|max:255',
            'name_en' => '',
            'content' => '',
            'content_en' => '',
            'keywords' => '',
            'keywords_en' => '',
            'description' => '',
            'description_en' => '',
            'category_id' => 'required|max:255',
            'artist_id' => 'required|max:255',
            'status' => 'required',
            'sort' => 'numeric'
        ]);

        $item = Product::create($item);

        if(!is_null($item))
        {

            if ($request->has('images')) {
                $images = $request->images;
                $count=0;
                foreach($images as $each) {
                    $count++;
                    Image::where('filename',$each)->update(['item_id' => $item->id,'type' => "product",'sort_num' => $count]);
                }
            }

            return redirect('admin/projects')->with('alert_ok', "Successfully Added");
        }

    }
    
    public function new()
    {
        $item = Product::create();
        return redirect('admin/projects/update/'. $item->id );
    }

    public function updateGet($id)
    {
        $menu = "projects";
        $item = Product::find($id);
        $categories = ProductCategory::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $artists = User::orderBy('lastName', 'asc')->get();

        $locations = Location::orderBy('name', 'asc')->get();

        return view('admin.products.update', compact("menu", "locations", "artists", "categories", "item"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => '',
            'name_en' => '',
            'content' => '',
            'content_en' => '',
            'keywords' => '',
            'keywords_en' => '',
            'description' => '',
            'description_en' => '',
            'category_id' => '',
            'artist_id' => '',
            'city_id' => '',
            'latitude' => '',
            'longitude' => '',
            'if_not_location' => '',
            'location_id' => '',
            'status' => 'required',
            'sort' => ''
        ]);

        $item = Product::find($id);
        $item->update($validation);

        if(!is_null($item))
        {
            if ($request->has('images')) {
                $images = $request->images;
                $count=0;
                foreach($images as $each)  {
                    $count++;
                    Image::where('filename',$each)->where('type','product')->update(['item_id' => $item->id,'type' => "product",'sort_num' => $count]);
                }
            }
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = Product::find($request->id);

        $path = public_path('files/products/' .$item->id );
        File::deleteDirectory($path);

        if(!is_null($item))
        {

            $item->images()->delete();
            $item->contentImages()->delete();
            $item->forceDelete();

            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");


    }

}
