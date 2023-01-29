<?php

namespace App\Http\Controllers;

use App;
use App\Subscriber;
use App\Contact;
use App\User;
use App\Configuration;
use App\Letter;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Response;


use App\Exports\SubscribersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;


class SubscriberController extends Controller
{

    //საადმინო
    public function index()
    {
        $menu = "subscribers";
        $items = Subscriber::orderBy('id', 'desc')->get();
        return view('admin.subscribers.index', compact("items", "menu"));
    }

    public function addGet()
    {
        $menu = "subscribers";
        return view('admin.subscribers.add', compact("menu"));
    }

    public function addPost(Request $request)
    {
        $item = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        $item = Subscriber::create($item);

        if(!is_null($item))
        {
            return redirect('admin/subscribers')->with('alert_ok', "Successfully Added");
        }

    }

    public function updateGet($id)
    {
        $menu = "subscribers";
        $item = Subscriber::find($id);
        return view('admin.subscribers.update', compact("menu", "item"));
    }

    public function updatePost($id, Request $request)
    {

        $validation = $request->validate([
            'email' => 'max:255'
        ]);

        $item = Subscriber::find($id);
        $item->update($validation);

        if(!is_null($item))
        {
            return back()->with('alert_ok', "Successfully Updated");
        }

    }

    public function delete(Request $request)
    {
        $item = Subscriber::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");


    }


    public function subscribe(Request $request)
    {





        $checkEmail = Subscriber::where('email' , $request->input('email'))->first();

        if(is_null($checkEmail))
        {
            $subscribers = Subscriber::create($request->all());
            if(!is_null($subscribers))
            {


                if(\App::isLocale('ka')){
                    return back()->with('alert_ok', "მადლობა გამოწერისათვის!");
                }else {
                    return back()->with('alert_ok', "Thank you for subscribing!");
                }


            }
            return back()->with('alert_fail', "Error");
        } else {

            if(\App::isLocale('ka')){
                return back()->with('alert_fail', "ელ-ფოსტა უკვე გამოწერილია");
            }else {
                return back()->with('alert_fail', "Email already added");
            }
        }

    }

    public function unsubscribe(Request $request)
    {

        $request->validate([
            'email' => 'required|email|max:255',
        ]);


        $subscriber = Subscriber::where('email',$request->input('email'))->first();

        if(!is_null($subscriber))
        {
            $subscriber->forceDelete();
             return back()->with('alert_ok', "Successfully Unsubscribed");
        }

        return back()->with('alert_fail', "Error");

    }

    public function unsubscribeForm()
    {
         $template = "unsubscribe";
        $contact = Contact::find(1);
        $configuration = Configuration::find(1);

        return view('mail.unsubscribe', compact("template","contact", "configuration" ));


    }

    public function export()
    {
        return Excel::download(new SubscribersExport, 'subscribers.xlsx');
    }

    public function exportCSV()
    {

        $subscribers = Subscriber::all();
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($subscribers, ['email'])->download();

    }
    public function export2CSV()
    {

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=subscribers.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $reviews = Subscriber::get();
        $columns = array('email');

        $callback = function() use ($reviews, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($reviews as $review) {
                fputcsv($file, array($review->email));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);

    }

}
