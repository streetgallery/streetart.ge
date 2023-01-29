<?php

namespace App\Http\Controllers;

use App;
use App\Group;

use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = "groups";
        $items = Group::orderBy('id', 'desc')->get();
        return view('admin.groups.index', compact("items", "menu"));
    }

    public function addGet()
    {
        $menu = "groups";
        return view('admin.groups.add', compact("menu"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'required|max:255'
        ]);


        $item = Group::create($item);

        if(!is_null($item))
        {
            return redirect('admin/groups')->with('alert_ok', "Successfully Added");
        }

     }

    public function updateGet($id)
    {
        $menu = "groups";
        $item = Group::find($id);
        return view('admin.groups.update', compact("menu", "item"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => 'required|max:255'
        ]);

        $item = Group::find($id);
        $item->update($validation);

        if(!is_null($item))
        {
            return back()->with('alert_ok', "Successfully Added");
        }

    }

    public function delete(Request $request)
    {
            $item = Group::find($request->id);
            if(!is_null($item))
            {
                $item->forceDelete();
                return back()->with('alert_ok', "Successfully deleted");
            }
            return back()->with('alert_fail', "An error has occurred");


    }

}
