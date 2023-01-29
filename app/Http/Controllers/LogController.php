<?php

namespace App\Http\Controllers;

use App;
use App\Log;
use App\User;

use Illuminate\Http\Request;

class LogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, Log $log)
    {

        $query = $log->newQuery();

        if($request->input('user_id') != '') {
            $query->where('user_id', $request->input('user_id'));
        }



        $items = $query->orderBy('id', 'desc')->paginate(30);
        $menu = "logs";
        $users = User::orderBy('id', 'asc')->get();

        return view('admin.logs.index', compact("items","users", "menu"));

    }

    public function modal($id,Request $request, Log $log)
    { 
        $query = $log->newQuery();
        $menu = "logs";
        $query->where('user_id', $id);
        $items = $query->orderBy('id', 'desc')->paginate(30);
         return view('admin.logs.modal', compact("items", "menu"));

    }


    public function delete(Request $request)
    {
        $item = Log::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");


    }


}
