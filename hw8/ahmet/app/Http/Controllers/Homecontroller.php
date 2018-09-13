<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;

class HomeController extends Controller
{
    public function showChangePasswordForm(){
        return view('auth.passwords.changepsw');
    }

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
// The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
//Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[.#?!@$%^&*-,]).{6,}$/',
            'new-password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[.#?!@$%^&*-,]).{6,}$/',
        ]);
//Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Password changed successfully !");
    }

    public function showChangeProfileForm(){
        return view('auth.updatePro');
    }

    public function changeProfile(Request $request){
        if (!(Hash::check($request->get('password'), Auth::user()->password))) {
// The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.Auth::user()->id.'',
        ]);
//Change Password
        $user = Auth::user();
        $user->name=$request->get('name');
        $user->surname=$request->get('surname');
        $user->email=$request->get('email');
        $user->save();
        return redirect()->back()->with("success","Profile updated!");
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

}
