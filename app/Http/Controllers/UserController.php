<?php

namespace App\Http\Controllers;

use App\User;
use App\Log;
use App\Image;
use App\Country;
use App\State;
use App\City;
use DB;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AllUsers(Request $request, User $user)
    {
        $query = $user->newQuery();


        if($request->input('search') != '') {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->input('search') . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->input('search') . '%');
            });
        }

        $count = $query->count();
        $items = $query->orderBy('id', 'desc')->paginate(25);

        $menu = "users";

        return view('admin.users.index', compact("items", "count", "menu"));


    }

    public function addGet(){

        $menu = "users";
        return view('admin.users.add', compact("users",   "menu"));

    }

    public function addPost(Request $request){

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'group_role' => 'required|max:255',
            'password' => 'required|confirmed|min:6',
        ]);


        $user_exsist = User::where("email",$request->input('email'))->first();
        if(!is_null($user_exsist))
        {
            return redirect('users/add')->with('alert_fail', "Already added");
        }

        $requestUser = $request->all();
        $requestUser['password'] = bcrypt($request->input('password'));

        $user = User::create($requestUser);

        if($user){
            return redirect('users' )->with('alert_ok', "Successfully Added");
        }
        return redirect('users')->with('alert_fail', "An error has occurred");

    }


    public function newItem()
    {
        $item = User::create();
        return redirect('admin/users/update/'. $item->id );
    }

    public function updateGet($id){

        $item = User::find($id);
        $countries = Country::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $states = State::where("country_id", $item->country_id)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $cities = City::where("state_id", $item->state_id)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        if(!is_null($item)){
            $menu = "users";
            return view('admin.users.update', compact("item", "countries", "states", "cities", "menu"));
        }
        return redirect('users')->with('alert_fail', "An error has occurred");
    }

    public function updatePost(Request $request, $id){

        $user = User::find($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'username' => '',
            'about' => '',
            'firstname_en' => '',
            'lastname_en' => '',
            'username_en' => '',
            'about_en' => '',
            'mobile' => '',
            'website' => '',
            'facebook' => '',
            'instagram' => '',
            'behance' => '',
            'dribbble' => '',
            'bg_color' => '',
            'group_role' => 'required|max:255',
            'artist' => '',
        ]);

        $user = User::find($id);

        if(!is_null($user))
        {
            if ($request->has('images')) {
                $images = $request->images;
                $count=0;
                foreach($images as $each)  {
                    $count++;
                    Image::where('filename',$each)->where('type','user')->update(['item_id' => $user->id,'type' => "user",'sort_num' => $count]);
                }
            }

            $user->update($request->all());
            return back()->with('alert_ok', "Successfully Added");
        }
        return back()->with('alert_fail', "An error has occurred");
    }

    public function updateAddress(Request $request, $id){

        $user = User::find($id);

        $request->validate([
         ]);

        $user = User::find($id);

        if(!is_null($user))
        {
            $user->update($request->all());
            return back()->with('alert_ok', "Successfully Added");
        }
        return back()->with('alert_fail', "An error has occurred");
    }

    public function password(Request $request, $id){

        $item = User::find($id);

        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        if(!is_null($item))
        {
            $password =  $request->input('password');
            $item->password = bcrypt($password);
            $item->save();
            return back()->with('alert_ok', "Password successfully updated");
        }
        return back()->with('alert_fail', "Password not updated");

    }

    public function delete(Request $request){

        $item = User::find($request->id);

        $log = new Log();
        $log->comment = "Delete ". $item->name ." ID " . $item->id ;
        $log->action = "Delete User";
        $log->user_id = Auth::user()->id;
        $log->save();


        if(!is_null($item))  {
            $item->forceDelete();
            return back()->with('alert_ok', "Successfully Deleted");
        }

        return back()->with('alert_fail', "An error has occurred");

    }

}
