<?php

namespace App\Http\Controllers;

use App;
use App\Image;
use App\Product;
use App\ProductCategory;
use App\User;
use App\Configuration;
use App\Contact;
use App\Navigation;
use App\Location;
use DB;
use Illuminate\Support\Facades\File;

use Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function projects(Request $request, Product $projects)
    {
        $query = $projects->newQuery();

        $query->where('status', 1);

        if($request->input('search') != '') {
            $query->where('status', 1)->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('name_en', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('content', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('content_en', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('keywords', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('keywords_en', 'LIKE', '%' . $request->input('search') . '%');
            });
        }

        if($request->input('category_id') != '') {
            $query->where('category_id', $request->input('category_id'));
        }

        if($request->input('artist_id') != '') {
            $query->where('artist_id', $request->input('artist_id'));
        }
        
        if($request->input('location_id') != '') {
            $query->where('location_id', $request->input('location_id'));
        }

       $projects = $query->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(12);
        //$projects = $query->inRandomOrder()->paginate(20);
        // $projects = $query->paginate(20);

        $menu = "projects";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $categories = ProductCategory::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $artists = User::where('artist', 1)->orderBy('lastName', 'asc')->get();
        $locations = Location::orderBy('name', 'asc')->get();

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();



        return view('projects.items2', compact("projects","locations" ,"main_nav", "top_nav", "bottom_nav", "request","artists","categories", "configuration", "contact", "menu"));
    }

    public function itemsJson(Request $request, Product $item)
    {
        $query = $item->newQuery();
        
        $query->where('status', 1);

        if($request->input('search') != '') {
            $query->where('status', 1)->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('name_en', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('content', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('content_en', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('keywords', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('keywords_en', 'LIKE', '%' . $request->input('search') . '%');
            });
        }

        if($request->input('category_id') != '') {
            $query->where('category_id', $request->input('category_id'));
        }
        if($request->input('take') != '') {
            $query->take($request->input('take'));
        }

        $items = $query->inRandomOrder()->get();


        foreach ($items as &$each) {

            if(isset($each->images)){
                $each->images = $each->images;
            }
            
            if(isset($each->artist)){
                $each->artist = $each->artist;
                 if(isset($each->artist->images)){
                 //    $each->artist->avatar = $each->artist->images[0]->small;
                 }

            }

        }

        return response()->json($items);

    }

    public function item(Request $request, $id)
    {
        $categories = ProductCategory::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        $item = Product::where('id', $id)->where('status', 1)->first();
        $item->views = $item->views + 1;
        $item->save();

        $menu = "projects";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('projects.item', compact("item", "main_nav", "top_nav", "bottom_nav", "categories", "request", "id", "configuration", "contact",  "menu"));
    }

    public function itemJson($id)
    {
        $item = Product::find($id);
        $item->views = $item->views + 1;
        $item->save();

        $view = view('projects.loadItem', compact('item'))->render();
        return response()->json(['html'=>$view]);
    }

    public function addGet()
    {

        $menu = "add-project";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $statement = DB::select("SHOW TABLE STATUS LIKE 'products'");
        $nextId = $statement[0]->Auto_increment;


        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        $categories = ProductCategory::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $artists = User::where('id','!=', Auth::user()->id  )->where('artist', 1)->orderBy('lastName', 'asc')->get();
        $locations = Location::orderBy('name', 'asc')->get();


        return view('projects.add', compact( "nextId", "categories", "artists", "locations", "main_nav", "top_nav", "bottom_nav", "configuration", "contact",  "menu"));

    }

    public function addPost(Request $request)
    {

        if(\App::isLocale('ka')){
            $message = array(
                'name.required' => 'დასახელება აუცილებელია',
                'artist_id.required' => 'მხატვარი აუცილებელია',
                'g-recaptcha-response.required' => 'გთხოვთ შეამოწმეთ recaptcha'
            );
        } else {
            $message = array(
                'artist_id.required' => 'Artist field is required',
                'g-recaptcha-response.required' => 'Please check recaptcha',
            );
        }


        $item = $request->validate([
            'name' => 'required|max:255',
            'name_en' => '',
            'content' => '',
            'content_en' => '',
            'keywords' => '',
            'keywords_en' => '',
            'description' => '',
            'description_en' => '',
            'category_id' => '',
            'artist_id' => 'required|max:255',
            'location_id' => '',
            'latitude' => '',
            'longitude' => '',
            'if_not_location' => '',
        ],$message);

        $item = Product::create($item);
        //$item->artist_id = Auth::user()->id ;
       // $item->save() ;

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
            if(\App::isLocale('ka')){
                return redirect('add-project')->with('alert_ok', "ნამუშევარი წარმატებით დაემატა");

            } else {
                return redirect('add-project')->with('alert_ok', "The work has been successfully added");

            }
        }

    }



}
