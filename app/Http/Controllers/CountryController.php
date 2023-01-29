<?php

namespace App\Http\Controllers;

use App;
use App\Country;
use DB;

use Illuminate\Http\Request;


class CountryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = "countries";
        $items = Country::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        return view('admin.locations.countries.index', compact("items", "menu"));
    }

    public function addGet()
    {
        $menu = "countries";
        return view('admin.locations.countries.add', compact("menu"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'country_id' => 'required|numeric|nullable',
            'sortname' => '',
            'sort' => 'numeric|nullable'
        ]);

        $item = Country::create($item);

        if(!is_null($item))
        {
            return redirect('admin/countries')->with('alert_ok', "Successfully Added");
        }

    }

    public function updateGet($id)
    {
        $menu = "countries";
        $item = Country::find($id);
        return view('admin.locations.countries.update', compact("menu", "item"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'phonecode' => 'numeric|nullable',
            'sortname' => '',
            'sort' => 'numeric|nullable'
        ]);

        $item = Country::find($id);
        $item->update($validation);
        if(!is_null($item))
        {
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = Country::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");


    }


}
