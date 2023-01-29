<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\Configuration;
use App\Contact;
use App\Navigation;
use DB;

use Auth;
use Illuminate\Http\Request;


class ArtistController extends Controller
{
    
    public function artists(Request $request, User $user)
    {
        $query = $user->newQuery();

        $alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

        if($request->input('search') != '') {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('firstname', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('mobile', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->input('search') . '%');
            });
        }

        if($request->input('alphabet') != '') {
            $query->where('firstname', 'LIKE', $request->input('alphabet').'%')
                ->orWhere('username', 'LIKE', $request->input('alphabet').'%')
                ->orWhere('username_en', 'LIKE', $request->input('alphabet').'%');
        }

        $items = $query->where('artist', 1)->orderBy('id', 'desc')->paginate(20);

        $menu = "artists";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('artists.items', compact("items","main_nav", "top_nav", "bottom_nav", "request", "alphabet", "configuration", "contact", "menu"));


    }

    public function artist($id,Request $request, Product $projects){

        $artist = User::find($id);
        $query = $projects->newQuery();

        $query->where('status', 1);
        $query->where('artist_id', $id);

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
        if($request->input('category_id') != '') {
            $query->where('category_id', $request->input('category_id'));
        }

      // $projects = $query->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(10);
        $projects = $query->inRandomOrder()->paginate(20);

        if(!is_null($artist)){
            $menu = "artist";
            $configuration = Configuration::find(1);
            $contact = Contact::find(1);

            $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
            $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
            $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

            return view('artists.item', compact("artist","main_nav", "top_nav", "bottom_nav", "projects", "request", "configuration", "contact", "menu"));
        }
        return redirect('/')->with('alert_fail', "An error has occurred");
    }

}
