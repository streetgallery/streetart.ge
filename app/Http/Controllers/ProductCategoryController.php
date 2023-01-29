<?php

namespace App\Http\Controllers;

use App;
use App\Image;
use App\ProductCategory;
use DB;

use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = "productCategories";
        $items = ProductCategory::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        return view('admin.products.categories.index', compact("items", "menu"));
    }

    public function addGet()
    {
        $menu = "productCategories";
        return view('admin.products.categories.add', compact("menu"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'sort' => 'numeric'
        ]);

        $item = ProductCategory::create($item);

        if(!is_null($item))
        {
            return redirect('admin/projects/categories')->with('alert_ok', "Successfully Added");
        }

    }

    public function updateGet($id)
    {
        $menu = "productCategories";
        $item = ProductCategory::find($id);
        return view('admin.products.categories.update', compact("menu", "item"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'sort' => 'numeric'
        ]);

        $item = ProductCategory::find($id);
        $item->update($validation);
        if(!is_null($item))
        {
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = ProductCategory::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");


    }

}
