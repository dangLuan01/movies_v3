<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Session;

class AuthSocialLoginController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::orderBy('id', 'ASC')->where('status', 1)->get();
        $genre = Genre::where('status', 1)->orderBy('id', 'DESC')->get();
        $country = Country::where('status', 1)->orderBy('id', 'DESC')->get();
        if (Auth::guard('customer')->check()) {

            return redirect()->back();
        }
        return view('pages.login', compact('category', 'genre', 'country'));
    }
    public function githubredirect(Request $request)
    {

        return Socialite::driver('github')->redirect();
    }
    public function githubcallback(Request $request)
    {
        try {
            $userdata = Socialite::driver('github')->user();

            $user = Customer::where('email', $userdata->email)->where('auth_type', 'github')->first();
           
            if (isset($user)) {
                if($user->status == 1){
                    Auth::guard('customer')->login($user);
                    Session::put('customer_id',$user->id);
                    return redirect()->back()->with('status', 'Your login was successful!');
                }else{
                    return redirect()->back()->with('status_error', 'Tài khoản đã bị khóa!');
                }
                
            } else {

                $uuid = Str::uuid()->toString();
                $user = new Customer();
                $user->name = $userdata->name;
                $user->avatar = $userdata->avatar;
                $user->email = $userdata->email;
                $user->password = Hash::make($uuid . now());
                $user->auth_type = 'github';

                if ($user->name == '') {
                    // toastr()->warning('LỖI ."USERNAME" TRONG TÀI KHOẢN GITHUB CỦA BẠN KHÔNG ĐƯỢC ĐỂ TRỐNG!', 'Login error!', ['timeOut' => 7000]);
                    return redirect('/auth/login')->with('status_warning', 'Your deposit was successful!');
                }
                $user->save();
                Session::put('customer_id',$user->id);
                Auth::guard('customer')->login($user);
                //dd($next);
                return redirect()->back()->with('status', 'Your deposit was successful!');
            }
        } catch (\Throwable $th) {

            return redirect()->back()->with('status_error', 'Your login was error!');
        }

        //dd($user);
        // $user->token
    }

    public function googleredirect(Request $request)
    {

        return Socialite::driver('google')->redirect();
    }
    public function googlecallback(Request $request)
    {
        try {
            $userdata = Socialite::driver('google')->user();
            //dd($userdata);
            $user = Customer::where('email', $userdata->email)->where('auth_type', 'google')->first();
            //dd($user);
            if (isset($user)) {
                Auth::guard('customer')->login($user);
                Session::put('customer_id',$user->id);
                return redirect(route('homepage'))->with('status', 'Your deposit was successful!');
            } else {

                $uuid = Str::uuid()->toString();
                $user = new Customer();
                $user->name = $userdata->name;
                $user->email = $userdata->email;
                $user->avatar = $userdata->avatar;
                $user->password = Hash::make($uuid . now());
                $user->auth_type = 'google';

                // if ($user->name=='') {
                //     toastr()->warning('LỖI ."USERNAME" TRONG TÀI KHOẢN GITHUB CỦA BẠN KHÔNG ĐƯỢC ĐỂ TRỐNG!','Login error!',['timeOut' => 7000]);
                //     return redirect('/auth/login');

                // }
                $user->save();

                Auth::guard('customer')->login($user);
                Session::put('customer_id',$user->id);
                return redirect(route('homepage'))->with('status', 'Your deposit was successful!');
            }
        } catch (\Throwable $th) {

            return redirect()->back()->with('status_error', 'Your login was error!');
        }

        //dd($user);
        // $user->token
    }

    public function facebookredirect()
    {

        return Socialite::driver('facebook')->redirect();
    }
    public function facebookcallback(Request $request)
    {
        try {
            $userdata = Socialite::driver('facebook')->user();
            //dd($userdata);
            $user = Customer::where('email', $userdata->email)->where('auth_type', 'facebook')->first();
            //dd($user);
            if (isset($user)) {
                Auth::guard('customer')->login($user);
                Session::put('customer_id',$user->id);
                return redirect()->back()->with('status', 'Your deposit was successful!');
            } else {

                $uuid = Str::uuid()->toString();
                $user = new Customer();
                $user->name = $userdata->name;
                $user->email = $userdata->email;
                $user->avatar = $userdata->avatar;
                $user->password = Hash::make($uuid . now());
                $user->auth_type = 'facebook';
                $user->save();

                Auth::guard('customer')->login($user);
                Session::put('customer_id',$user->id);
                return redirect()->back()->with('status', 'Your login was successful!');
            }
        } catch (\Throwable $th) {

            return redirect()->back()->with('status_error', 'Your login was error!');
        }
    }

    public function sociallogout()
    {
        Session::flush();
        return redirect()->back()->with(Auth::guard('customer')->logout());
    }
}
