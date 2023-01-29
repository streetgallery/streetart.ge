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
use DB;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile(){

        $item = User::find(Auth::user()->id);
        $countries = Country::orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $states = State::where("country_id", $item->country_id)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $cities = City::where("state_id", $item->state_id)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        $menu = "profile";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('profile.profile', compact("item","main_nav", "top_nav", "bottom_nav", "configuration", "contact", "menu", "countries", "states", "cities"));
     }

    public function profileUpdate(Request $request){

        $user = User::find(Auth::user()->id);

        $request->validate([
            'firstname_en' => 'required|max:255',
            'lastname_en' => 'required|max:255',
            'username_en' => '',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'username' => '',
            'about' => '',
            'mobile' => 'required|max:255',
            'about_en' => '',
            'website' => '',
            'email' => 'required|max:255|email|unique:users,email,'.$user->id,
        ]);

        $user = User::find(Auth::user()->id);

        if(!is_null($user))
        {
            $user->update($request->all());

            if(\App::isLocale('ka')){
                return back()->with('alert_ok', 'პროფილი წამატებით განახლდა');
            } else {
                return back()->with('alert_ok', 'Profile updated successfully');
            }

         }
        return back()->with('alert_fail', "An error has occurred");
    }

    public function profileUpdateKa(Request $request){


        $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'username' => '',
            'about' => '',
        ]);

        $user = User::find(Auth::user()->id);

        if(!is_null($user))
        {
            $user->update($request->all());

            if(\App::isLocale('ka')){
                return back()->with('alert_ok', 'პროფილი წამატებით განახლდა');
            } else {
                return back()->with('alert_ok', 'Profile updated successfully');
            }

         }
        return back()->with('alert_fail', "An error has occurred");
    }

    public function avatar(){

        $item = User::find(Auth::user()->id);

        $menu = "avatar";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('profile.avatar', compact("item","main_nav", "top_nav", "bottom_nav", "configuration", "contact", "menu", "countries", "states", "cities"));
     }

    public function deleteAvatar()
    {
        $item = User::find(Auth::user()->id);
        $path = public_path('files/user/' .$item->id );
        File::deleteDirectory($path);
        $item->images()->delete();

        if(!is_null($item))
        {
            if(\App::isLocale('ka')){
                return back()->with('alert_ok', 'ავატარი წამატებით წაიშალა');
            } else {
                return back()->with('alert_ok', 'Avatar deleted successfully');
            }
        }
        return back()->with('alert_fail', "An error has occurred");
    }

    public function social(){

        $item = User::find(Auth::user()->id);

        $menu = "social_profiles";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('profile.social', compact("item","main_nav", "top_nav", "bottom_nav", "configuration", "contact", "menu", "countries", "states", "cities"));
    }

    public function socialUpdate(Request $request){

        $request->validate([
            'facebook' => '',
            'instagram' => '',
            'behance' => '',
            'dribbble' => '',
        ]);

        $user = User::find(Auth::user()->id);

        if(!is_null($user))
        {
            $user->update($request->all());

            if(\App::isLocale('ka')){
                return back()->with('alert_ok', 'სოციალური პროფილები წარმატებით განახლდა');
            } else {
                return back()->with('alert_ok', 'Social profiles updated successfully');
            }

        }
        return back()->with('alert_fail', "An error has occurred");
    }

    public function password(){

        $item = User::find(Auth::user()->id);

        $menu = "password";
        $configuration = Configuration::find(1);
        $contact = Contact::find(1);

        $main_nav = Navigation::where('navigation','main')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $top_nav = Navigation::where('navigation','top')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();
        $bottom_nav = Navigation::where('navigation','bottom')->where("parent_id", 0)->orderBy(DB::raw('ISNULL(sort), sort'), 'asc')->orderBy('id', 'desc')->get();

        return view('profile.password', compact("item","main_nav", "top_nav", "bottom_nav", "configuration", "contact", "menu", "countries", "states", "cities"));
    }

    public function passwordUpdate(Request $request){

        $user = User::find(Auth::user()->id);


        $request->validate([
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6|different:password',
        ]);


        if (Hash::check($request->old_password, $user->password)) {

            $password =  $request->new_password;
            $user->password = bcrypt($password);
            $user->save();

            if(\App::isLocale('ka')){
                return back()->with('alert_ok', 'პაროლი წამატებით განახლდა');
            } else {
                return back()->with('alert_ok', 'Password successfully updated');
            }


        } else {

            return back()->with('alert_fail', "Password not updated");

         }



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


}
