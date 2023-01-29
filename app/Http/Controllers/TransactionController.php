<?php

namespace App\Http\Controllers;

use App;
use App\Transaction;
use App\User;

use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, Transaction $transactions)
    {

        $query = $transactions->newQuery();
        if($request->input('user_id') != '') {
            $query->where('user_id', $request->input('user_id'));
        }
        
        $sum = $query->sum('amount');

        $items = $query->orderBy('id', 'desc')->paginate(30);
        $menu = "transactions";
        $users = User::orderBy('id', 'asc')->get();

        return view('admin.transactions.index', compact("items","sum", "users", "menu"));

    }

    public function modal($id,Request $request, Transaction $transactions)
    {

        $query = $transactions->newQuery();
        $menu = "transactions";
        $query->where('user_id', $id);
        $sum = $query->sum('amount');

        $items = $query->orderBy('id', 'desc')->paginate(30);
        return view('admin.transactions.modal', compact("items","sum", "menu"));

    }


    public function delete(Request $request)
    {
        $item = Transaction::find($request->id);
        if(!is_null($item))
        {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully deleted");
        }
        return back()->with('alert_fail', "An error has occurred");


    }


}
