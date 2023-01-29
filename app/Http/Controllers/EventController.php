<?php

namespace App\Http\Controllers;

use App;
use App\Image;
use App\Event;
use App\Location;
use App\Artist;
use App\User;
use App\Configuration;
use App\Navigation;
use App\Contact;
use DB;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;

class EventController extends Controller
{

    public function index()
    {
        $menu = "events";
        $items = Event::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(30);
        return view('admin.events.index', compact("items", "menu"));
    }

    public function addGet()
    {

        $menu = "events";
        $artists  = Artist::orderBy('id', 'desc')->get();
        $locations = Location::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('admin.events.add', compact("menu", "artists", "locations"));
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
            'artist_id' => '',
            'location_id' => '',
            'status',
            'sort' => 'numeric|nullable'
        ]);

        $item = Event::create($item);

        if(!is_null($item)){

            if ($request->has('images')) {
                $images = $request->images;
                $count=0;
                foreach($images as $each) {
                    $count++;
                    Image::where('filename',$each)->update(['item_id' => $item->id,'type' => "event",'sort_num' => $count]);
                }
            }

            return redirect('admin/events')->with('alert_ok', "Successfully Added");
        }

    }

    public function newItem()
    {
        $item = Event::create();
        return redirect('admin/events/update/'. $item->id );
    }

    public function updateGet($id)
    {
        $menu = "events";
        $item = Event::find($id);
        $artists  = User::where('artist', 1)->orderBy('lastname', 'asc')->get();
        $locations = Location::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $arrayLocation = explode(",", $item->location_id);

        return view('admin.events.update', compact("menu", "item", "artists", "arrayLocation", "locations"));
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
            'artist_id' => '',
            'location_id' => '',
            'status' => '',
            'facebook' => '',
            'instagram' => '',
            'youtube' => '',
            'event_date' => '',
            'sort' => 'numeric|nullable'
        ]);

        $item = Event::find($id);

        $requestEvent = $validation;
        $selectedLocation = collect($requestEvent['location_id']);
        $requestEvent['location_id'] = $selectedLocation->implode(',');


        $item->update($requestEvent);

        if(!is_null($item))
        {
            if ($request->has('images')) {
                $images = $request->images;
                $count=0;
                foreach($images as $each)  {
                    $count++;
                    Image::where('filename',$each)->update(['item_id' => $item->id,'type' => "event",'sort_num' => $count]);
                }
            }
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = Event::find($request->id);

        $path = public_path('files/events/' .$item->id );
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

    public function events(Request $request, Event $items)
    {
        $query = $items->newQuery();


        if ( $request->input('date')  != '') {
            $query->whereDate('event_date', $request->input('date'));
        }


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

        $items = $query->where('status', 1)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(7);

        $menu = "events";
        $events = Event::where('status', 1)->get();
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $locations = Location::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('events.events', compact("items","events", "locations", "request", "top_nav", "main_nav", "bottom_nav", "configuration", "contact", "menu"));
    }

    public function eventsJson(Request $request, Event $items)
    {
        $query = $items->newQuery();


        if ( $request->input('date')  != '') {
            $query->whereDate('event_date', $request->input('date'));
        }


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

        $items = $query->where('status', 1)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->paginate(7);
        $view = view('events.loadEvents', compact('items'))->render();
        return response()->json(['html'=>$view]);
    }

    public function event($id)
    {
        $item = Event::where('id', $id)->where('status', 1)->first();
        $menu = "article";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('events.event', compact("item", "request", "id", "top_nav", "main_nav", "bottom_nav", "configuration", "contact", "menu"));
    }

    public function eventJson($id)
    {

        $item = Event::find($id);
        $locations = Location::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        $view = view('events.loadEvent', compact('item', 'locations'))->render();
        return response()->json(['html'=>$view]);
    }

}
