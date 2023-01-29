<?php

namespace App\Http\Controllers;

use App;
use App\Image;
use App\ArticleCategory;
use DB;

use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = "categories";
        $items = ArticleCategory::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        return view('admin.articles.categories.index', compact("items", "menu"));
    }

    public function addGet()
    {
        $menu = "categories";
        return view('admin.articles.categories.add', compact("menu"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'sort' => 'numeric|nullable'
        ]);

        $item = ArticleCategory::create($item);

        if(!is_null($item))
        {
            return redirect('admin/articles/categories')->with('alert_ok', "Successfully Added");
        }

    }

    public function updateGet($id)
    {
        $menu = "categories";
        $item = ArticleCategory::find($id);
        return view('admin.articles.categories.update', compact("menu", "item"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => 'required|max:255',
            'name_en' => 'required|max:255',
            'sort' => 'numeric|nullable'
        ]);

        $item = ArticleCategory::find($id);
        $item->update($validation);
        if(!is_null($item))
        {
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = ArticleCategory::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");


    }

}
