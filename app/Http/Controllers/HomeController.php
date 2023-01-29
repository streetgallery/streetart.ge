<?php

namespace App\Http\Controllers;
use App;
use App\Slide;
use App\Transaction;
use App\Location;
use App\Event;
use App\Article;
use App\Configuration;
use App\Navigation;
use App\Contact;
use App\Product;
use App\Banner;
use DB;

use Carbon\Carbon;


use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function index()
    {

        /*
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
        */

        $menu  = "home";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $locations = Location::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        $slides = Slide::orderBy('sort', 'asc')->get();
        $events = Event::where('status', 1)->orderBy('id', 'desc')->take(2)->get();
        $articles = Article::where('category_id', 7)->where('status', 1)->orderBy('id', 'desc')->take(9)->get();
        $projects = Product::where('status', 1)->orderBy('id', 'desc')->take(8)->get();
        $projectsMap = Product::where('status', 1)->where('if_not_location', 1)->orderBy('id', 'desc')->take(4)->get();
        $banners = Banner::orderBy('id', 'desc')->get();

        return view('index', compact("menu","projectsMap","banners", "projects", "locations", "configuration", "main_nav", "top_nav", "bottom_nav", "contact", "slides", "articles", "events"));
    }


    public function off()
    {
        $configuration = Configuration::find(1);

        $menu  = "off";

        return view('off', compact("menu", "configuration"));
    }


    public function admin()
    {
        $menu = "home";

        $transactions = Transaction::sum('amount');
        $today = Transaction::whereDate('created_at', Carbon::today())->sum('amount');


        $last30days = array();
        $last30tran = array();
        for($i = 0; $i < 30; $i++){
            $last30days[]  =  strtotime('-'. $i .' days');
        }

        foreach($last30days as $item){

            $total = Transaction::whereDate('created_at', date("Y-m-d", $item) )->sum('amount');
            $date =  date("M d", $item);
            $last30tran[] = array("date" => $date, "total" => $total );

        }

        return view('admin.index', compact("menu","last30tran", "stations", "transactions", "today"));

    }

    public function last30day()
    {

        $last30days = array();
        $json = array();
        for($i = 0; $i < 90; $i++){
            $last30days[]  =  strtotime('-'. $i .' days');
        }

        foreach($last30days as $item){

             $total = Transaction::whereDate('created_at', date("Y-m-d", $item) )->sum('amount');
             $date =  date("M d", $item);
             $json[] = array("date" => $date, "total" => $total );

        }

        return response()->json($json);

    }

    public function sidebar(Request $request)
    {

        if($request->sidebar == "sidebar-xs")
        {
            session()->put("sidebar","sidebar-xs");
        }
        elseif($request->sidebar == "sidebar-lg")
        {
            session()->put("sidebar","sidebar-lg");
        }


        if(session()->has("sidebar")){
            $sidebar = session()->get('sidebar');
        } else {
            $sidebar = "sidebar-lg";
        }

        return  $sidebar;
    }

}
