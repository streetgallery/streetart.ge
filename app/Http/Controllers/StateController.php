<?php

namespace App\Http\Controllers;

use App;
use App\Country;
use App\State;
use DB;

use Illuminate\Http\Request;



class StateController extends Controller
{

    public function index(Request $request, State $items)
    {
        $query = $items->newQuery();

        if($request->input('country_id') != '') {
            $query->where('country_id', $request->input('country_id'));
        }

        $items = $query->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(30);

        $menu = "states";

        return view('admin.locations.states.index', compact("items", "menu"));
    }

    public function addGet()
    {
        $menu = "states";
        $countries = Country::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('admin.locations.states.add', compact("menu", "countries"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'country_id' => 'required|int',
            'sort' => 'numeric|nullable'
        ]);

        $item = State::create($item);

        if(!is_null($item))
        {
            return redirect('admin/states')->with('alert_ok', "Successfully Added");
        }

    }

    public function updateGet($id)
    {
        $menu = "states";
        $item = State::find($id);
        $countries = Country::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('admin.locations.states.update', compact("menu", "item", "countries"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'country_id' => 'required|int',
            'sort' => 'numeric|nullable'
        ]);

        $item = State::find($id);
        $item->update($validation);
        if(!is_null($item))
        {
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = State::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");

    }


    public function getStates($country_id)
    {
        $states = State::where('country_id', $country_id)->get(['id', 'name', 'name_en'])->toArray();
        return response()->json($states);
    }


}