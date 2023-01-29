<?php

namespace App\Http\Controllers;

use App;
use App\Image;
use App\Article;
use App\ArticleCategory;
use App\Configuration;
use App\Navigation;
use App\Contact;
use DB;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function index()
    {
        $menu = "articles";
        $items = Article::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(30);
        return view('admin.articles.index', compact("items", "menu"));
    }

    public function addGet()
    {
        $menu = "articles";
        $categories = ArticleCategory::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('admin.articles.add', compact("menu", "categories"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'name' => 'required|max:255',
            'name_en' => '',
            'content' => '',
            'content_en' => '',
            'keywords' => '',
            'keywords_en' => '',
            'description' => '',
            'description_en' => '',
            'category_id' => 'required|max:255',
            'status',
            'sort' => 'numeric'
        ]);

        $item = Article::create($item);

        if(!is_null($item))
        {

            if ($request->has('images')) {
                $images = $request->images;
                $count=0;
                foreach($images as $each) {
                    $count++;
                    Image::where('filename',$each)->update(['item_id' => $item->id,'type' => "article",'sort_num' => $count]);
                }
            }

            return redirect('admin/articles')->with('alert_ok', "Successfully Added");
        }

    }
    public function newItem()
    {
        $item = Article::create();
        return redirect('admin/articles/update/'. $item->id );
    }

    public function updateGet($id)
    {
        $menu = "articles";
        $item = Article::find($id);
        $categories = ArticleCategory::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        return view('admin.articles.update', compact("menu", "categories", "item"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => '',
            'name_en' => '',
            'content' => '',
            'content_en' => '',
            'keywords' => '',
            'keywords_en' => '',
            'description' => '',
            'description_en' => '',
            'category_id' => '',
            'status' => '',
            'sort' => ''
        ]);

        $item = Article::find($id);
        $item->update($validation);

        if(!is_null($item))
        {
            if ($request->has('images')) {
                $images = $request->images;
                $count=0;
                foreach($images as $each)  {
                    $count++;
                    Image::where('filename',$each)->update(['item_id' => $item->id,'type' => "article",'sort_num' => $count]);
                }
            }
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = Article::find($request->id);

        $path = public_path('files/articles/' .$item->id );
        File::deleteDirectory($path);

        if(!is_null($item))
        {

            $item->images()->delete();
            $item->contentImages()->delete();
            $item->forceDelete();

            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");
    }

    public function blog(Request $request, Article $article)
    {
        $query = $article->newQuery();

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

        $items = $query->where('category_id', 1)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(12);

        $menu = "blog";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
 
        return view('blog.blog', compact("items","request", "top_nav", "main_nav", "bottom_nav", "configuration", "contact", "menu"));
    }
    
    public function blogJson(Request $request, Article $article)
    {
        $query = $article->newQuery();

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

        $articles = $query->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(10);
        $view = view('blog.load', compact('articles'))->render();
        return response()->json(['html'=>$view]);
    }

    public function article($id)
    {

        $item = Article::where('status', 1)->where('id', $id)->first();
        $menu = "article";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('blog.article', compact("item", "request", "id", "top_nav", "main_nav", "bottom_nav", "configuration", "contact", "menu"));
    }


    public function articleJson($id)
    {

        $item = Article::find($id);

        $view = view('blog.loadArticle', compact('item'))->render();
        return response()->json(['html'=>$view]);
    }

}
