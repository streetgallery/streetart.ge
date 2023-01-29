<?php
namespace App\Http\Controllers;

use App;
use App\Country;
use App\City;
use App\State;
use DB;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class CityController extends Controller
{
    public function index(Request $request, City $items)
    {
        $query = $items->newQuery();

        if($request->input('state_id') != '') {
            $query->where('state_id', $request->input('state_id'));
        }

        if($request->input('country_id') != '') {
            $query->whereHas('state', function (Builder $query2) use ($request){
                $query2->where('country_id',  $request->input('country_id'));
            })->get();
        }




        $items = $query->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(30);

        $menu = "cities";

        return view('admin.locations.cities.index', compact("items", "menu"));
    }

    public function addGet()
    {
        $menu = "cities";
        $countries = Country::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('admin.locations.cities.add', compact("menu", "countries"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'country_id' => 'required|int',
            'state_id' => 'required|int',
            'sort' => 'numeric|nullable'
        ]);

        $item = City::create($item);

        if(!is_null($item))
        {
            return redirect('admin/cities')->with('alert_ok', "Successfully Added");
        }

    }

    public function updateGet($id)
    {

        $menu = "cities";
        $item = City::find($id);
        $countries = Country::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $states = State::where("country_id", $item->state->country_id)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('admin.locations.cities.update', compact("menu", "item", "countries", "states"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'country_id' => 'required|int',
            'state_id' => 'required|int',
            'sort' => 'numeric|nullable'
        ]);

        $item = City::find($id);
        $item->update($validation);
        if(!is_null($item))
        {
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = City::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");
    }

    public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->get(['id', 'name', 'name_en'])->toArray();
        return response()->json($cities);
    }
}
