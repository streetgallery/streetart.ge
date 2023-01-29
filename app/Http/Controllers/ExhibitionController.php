<?php

namespace App\Http\Controllers;

use App\User;
use App\Log;
use App\Image;
use App\Country;
use App\State;
use App\City;
use App\Configuration;
use App\Contact;
use App\Navigation;
use App\Exhibition;
use DB;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ExhibitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = "exhibitions";
        $items = Exhibition::orderBy('id', 'desc')->get();
        return view('admin.exhibitions.index', compact("items", "menu"));
    }

    public function updateGet($id)
    {
        $menu = "exhibitions";
        $item = Exhibition::find($id);
        return view('admin.exhibitions.update', compact("menu", "item"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'name' => 'required|max:255',
            'about_you' => 'required|max:255',
            'about_exhibition' => 'required|max:255',
            'category' => 'required|max:255',
            'importent_type' => '',
            'link' => 'required|max:255',
        ]);

        $item = Exhibition::find($id);

        $item->update($validation);

        if(!is_null($item))
        {
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = Exhibition::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");


    }


    public function exhibition(){

        $menu = "exhibition";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('exhibition', compact("main_nav", "top_nav", "bottom_nav", "configuration", "contact", "menu"));

    }

    public function exhibitionPost(Request $request){


        if(\App::isLocale('ka')){

            $message = array(
                'name.required' => 'სახელი აუცილებელია',
                'about_you.required' => 'თქვენ შესახებ აუცილებელია',
                'about_exhibition.required' => 'გამოფენის შესახებ აუცილებელია',
                'category.required' => 'კატეგორი აუცილებელია',
                'link.required' => 'ბმულლი აუცილებელია',
                'g-recaptcha-response.required' => 'გთხოვთ შეამოწმეთ recaptcha'
            );

        } else {

            $message = array(
                'g-recaptcha-response.required' => 'Please check recaptcha',
            );

        }

        $item = $request->validate([
            'name' => 'required|max:255',
            'about_you' => 'required|max:255',
            'about_exhibition' => 'required|max:255',
            'category' => 'required|max:255',
            'importent_type' => '',
            'link' => 'required|max:255',
        ], $message);

        /*
        $captcha = $item['g-recaptcha-response'] ;
        $secret = '6LfwuN8ZAAAAAFd7sP7pDDPKRG-4hYnGzi6XEKyM';
        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);

        if($response['success'] == false)
        {
            return back()->with('alert_fail', "You are spammer!!!");
        }
        */


        $user = User::find(Auth::user()->id);

        $item = Exhibition::create($item);

        $item->user_id = $user->id;
        $item->save();
        if(!is_null($item))
        {


            if(\App::isLocale('ka')){
                return back()->with('alert_ok', 'გამოფენა გაგზავნილია');
            } else {
                return back()->with('alert_ok', 'Exhibition Sent');
            }

        }
        return back()->with('alert_fail', "An error has occurred");
    }










}
