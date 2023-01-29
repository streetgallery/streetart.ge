<?php

namespace App\Http\Controllers;

use App;
use App\Navigation;
use DB;

use Illuminate\Http\Request;

class NavigationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = "navigation";
        $items = Navigation::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $main = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('admin.navigation.index', compact("items", "main", "top", "bottom", "menu"));
    }

    public function addGet()
    {
        $menu = "navigation";
        $navigation = Navigation::where("parent_id",0)
                            ->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')
                            ->orderBy('id', 'desc')->get();
        return view('admin.navigation.add', compact("menu", "navigation"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'max:255',
            'name_en' => 'max:255',
            'parent_id' => 'max:255',
            'navigation' => 'max:255',
            'link' => 'max:255',
            'sort' => 'numeric|nullable'
        ]);

        $item = Navigation::create($item);

        if(!is_null($item))
        {
            return redirect('admin/navigation')->with('alert_ok', "Successfully Added");
        }

    }

    public function updateGet($id)
    {
        $menu = "navigation";
        $item = Navigation::find($id);
        $navigation = Navigation::where("id",'!=', $item->id)
                            ->where("navigation",$item->navigation)
                            ->where("parent_id",0)
                            ->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')
                            ->orderBy('id', 'desc')->get();

        return view('admin.navigation.update', compact("menu", "item", "navigation"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => 'max:255',
            'name_en' => 'max:255',
            'parent_id' => 'max:255',
            'navigation' => 'max:255',
            'link' => 'max:255',
            'sort' => 'numeric|nullable'
        ]);

        $item = Navigation::find($id);
        $item->update($validation);
        if(!is_null($item))
        {
            return back()->with('alert_ok', "Successfully Updated");
        }
    }

    public function delete(Request $request)
    {
        $item = Navigation::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return  redirect('admin/navigation')->with('alert_ok', "Successfully deleted");
        }
        return redirect('admin/navigation')->with('alert_fail', "An error has occurred");


    }

}
