<?php
namespace App\Http\Controllers;

use App;
use App\Country;
use App\City;
use App\State;
use App\Location;
use App\Configuration;
use App\Contact;
use App\Navigation;
use App\Product;
use DB;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class LocationController extends Controller
{
    public function index(Request $request, Location $items)
    {
        $query = $items->newQuery();

        if($request->input('state_id') != '') {
            $query->where('state_id', $request->input('state_id'));
        }

        if($request->input('state_id') != '') {
            $query->whereHas('city', function (Builder $query2) use ($request){
                $query2->where('state_id',  $request->input('state_id'));
            })->get();
        }


        $items = $query->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(30);

        $menu = "locations";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        return view('admin.locations.locations.index', compact("items", "configuration", "contact", "menu"));
    }

    public function addGet()
    {
        $menu = "locations";
        $countries = Country::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('admin.locations.locations.add', compact("menu", "countries"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'country_id' => 'required|int',
            'state_id' => 'required|int',
            'city_id' => 'required|int',
            'latitude' => '',
            'longitude' => '',
            'sort' => 'numeric|nullable'
        ]);

        $item = Location::create($item);

        if(!is_null($item))
        {
            return redirect('admin/locations')->with('alert_ok', "Successfully Added");
        }

    }

    public function updateGet($id)
    {

        $menu = "locations";
        $item = Location::find($id);
        $countries = Country::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $states = State::where("country_id", $item->city->state->country_id)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $cities = City::where("state_id", $item->city->state_id)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('admin.locations.locations.update', compact("menu", "item", "countries", "states", "cities"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'country_id' => 'required|int',
            'state_id' => 'required|int',
            'city_id' => 'required|int',
            'latitude' => '',
            'longitude' => '',
            'sort' => 'numeric|nullable'
        ]);

        $item = Location::find($id);
        $item->update($validation);
        if(!is_null($item))
        {
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = Location::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");
    }

    public function getCities($state_id)
    {
        $locations = Location::where('state_id', $state_id)->get(['id', 'name', 'name_en'])->toArray();
        return response()->json($locations);
    }


    public function locations_old(Request $request, Location $items)
    {

        $query = $items->newQuery();

        if($request->input('id') != '') {
            $query->where('id', $request->input('id'));
        }

        if($request->input('state_id') != '') {
            $query->where('state_id', $request->input('state_id'));
        }

        if($request->input('state_id') != '') {
            $query->whereHas('city', function (Builder $query2) use ($request){
                $query2->where('state_id',  $request->input('state_id'));
            })->get();
        }

        $items = $query->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(30);

        $menu = "locations";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('locations', compact("items", "main_nav", "top_nav",  "bottom_nav", "configuration", "contact", "menu"));
    }

    public function locations(Request $request, Product $items)
    {

        $query = $items->newQuery();

        if($request->input('id') != '') {
            $query->where('id', $request->input('id'));
        }

        if($request->input('state_id') != '') {
            $query->where('state_id', $request->input('state_id'));
        }

        if($request->input('state_id') != '') {
            $query->whereHas('city', function (Builder $query2) use ($request){
                $query2->where('state_id',  $request->input('state_id'));
            })->get();
        }
        
        $query->where('if_not_location', 1);

        $projects = $query->where('status', 1)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(30);

        $menu = "locations";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);
        $locations = Location::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();


        return view('locations', compact("locations","projects", "main_nav", "top_nav",  "bottom_nav", "configuration", "contact", "menu"));
    }

    public function location(Request $request, Product $items, $id)
    {

        $item = Location::find($id);

        $query = $items->newQuery();

        $query->where('location_id', $id);

        if($request->input('id') != '') {
            $query->where('id', $request->input('id'));
        }

        $items = $query->where('status', 1)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(20);

        $menu = "locations";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);
        $locations = Location::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();


        return view('location', compact("item","locations", "items", "main_nav", "top_nav",  "bottom_nav", "configuration", "contact", "menu"));
    }
}
