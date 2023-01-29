<?php

namespace App\Http\Controllers;
use App;
use App\Article;
use App\Configuration;
use App\Contact;
use App\Navigation;
use DB;
use Mail;

use Carbon\Carbon;


use Illuminate\Http\Request;

class ConfigurationController extends Controller
{

    public function configuration()
    {
        $item = Configuration::find(1);
        $menu = "configuration";
        return view('admin.configuration.index', compact("menu", "item"));
    }

    public function blog_cover()
    {
        $menu = 'blog_cover';
        $item = Configuration::find(1);
        return view('admin.configuration.blog_cover', compact("item","menu"));
    }
    
    public function event_cover()
    {
        $menu = 'blog_cover';
        $item = Configuration::find(1);
        return view('admin.configuration.event_cover', compact("item","menu"));
    }

    public function edit($id, Request $request)
    {
        $validation = $request->validate([
            'name' => '',
            'name_en' => '',
            'logo' => '',
            'site_off' => '',
            'bodystart' => '',
        ]);

        $item = Configuration::find($id);
        $item->update($validation);

        return back()->with('alert_ok', "Successfully Updated");
    }

    public function contactGet()
    {
        $item = Contact::find(1);
        $menu = "contact";


        return view('admin.configuration.contact', compact("menu", "item"));
    }

    public function contactPost($id, Request $request)
    {
        $validation = $request->validate([
            'name' => '',
            'name_en' => '',
            'description' => '',
            'description_en' => '',
            'content' => '',
            'content_en' => '',
            'facebook' => '',
            'instagram' => ''
        ]);

        $item = Contact::find($id);
        $item->update($validation);

        return back()->with('alert_ok', "Successfully Updated");
    }

    public function contact()
    {

        $configuration = Configuration::find(1);
        $contact = Contact::find(1);
        $menu = "contact";

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('contact', compact("menu","contact", "main_nav", "top_nav", "bottom_nav", "configuration"));
    }


    public function sendMail(Request $request)
    {



        if(\App::isLocale('ka')){

            $message = array(
                'firstname.required' => 'სახელი აუცილებელია',
                'lastname.required' => 'გვარი აუცილებელია',
                'email.required' => 'ელ-ფოსტა აუცილებელია',
                'message.required' => 'შეტყოინება აუცილებელია',
                'g-recaptcha-response.required' => 'გთხოვთ შეამოწმეთ recaptcha'
            );

        } else {

            $message = array(
                'g-recaptcha-response.required' => 'Please check recaptcha',
            );

        }



        $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|max:255|email',
            'message' => 'required|max:255',
            'g-recaptcha-response' => 'required',
        ],$message);


        $captcha = $request->input('g-recaptcha-response');
        $secret = '6LfwuN8ZAAAAAFd7sP7pDDPKRG-4hYnGzi6XEKyM';
        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);

        if($response['success'] == false)
        {
            return back()->with('alert_ok', "You are spammer ! Get the @$%K out");
        }
        else {
            Mail::send('mail.contact', ['cantact' => $request ], function ($m) use ($request) {
                $m->from("noreply@artup.ge", $request->lastname);
                $m->to("levangeliashvili@gmail.com");
                $m->to("n.potskhveria@gmail.com");
                $m->subject("From Contact ". $request->lastname);
            });

            return back()->with('alert_ok', "Successfully Sent");
        }



    }

}
