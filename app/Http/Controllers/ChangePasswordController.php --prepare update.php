<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Model\User;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\updatePasswordRequest;
use Illuminate\Support\Facades\DB;

class ChangePasswordController extends Controller
{
    public function showForm()
    {
        return view('authorization.forgot_password');
    }

    public function getEmail(Request $request)
    {
        //dd($request);

        $user = User::where('user_email', $request->email)->first();

        $data = $user;

        if ($user == null) {
            return redirect()->back()->with(['error', 'Mail not exists']);
        }

        Mail::to($user->user_email)->send(new SendMail($data));

        return redirect('/')->with(['success', 'Email succes sending. Open your email']);
    }

    public function newPassword()
    {
        return view('authorization.change_password');
    }

    public function changePassword(Request $request)
    {
        // dd($request);
        $user = User::where('user_email', $request->email)->first();
        $user->password = md5(sha1(md5('btlunzavitalissystem')));
        //$user->updated_by = Auth::user()->user_name;
        $user->save();

        // auth()->user()->update([
        //     'password' => Hash::make(md5(sha1(md5('btl'.$request->password.'system'))))
        // ]);

        return response()->json($user);
    }

    public function ChangeDefaultPassword($mail)
    {
        $realmail = Crypt::decryptString($mail);
        return view('authorization.changeDefaultPassword', compact('mail'));
    }

    public function resetDefaultPassword(updatePasswordRequest $request)
    {
        $realmail = Crypt::decryptString($request->mail);
        $password =  Hash::make('Hr' . $request->password . 'syst3m');
        DB::transaction(function () use ($realmail, $password) {
            User::where('user_email', $realmail)->update(['password' => $password]);
        });
        return response()->json(['status' => 'ok', "message" => "Password Changed Successfully "]);
    }
}
