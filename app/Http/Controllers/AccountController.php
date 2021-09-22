<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        return view("auth.account");
    }

    public function changeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        if (auth()->user()->update(['email' => $request->email])) {
            return back()->with('success', 'Email changed successfully!');
        }

        return back()->with('fail', 'Something went wrong. Try again!');
    }

    public function changePersonal(Request $request)
    {
        $fields = $request->validate([
            'name' => 'string',
            'phone' => 'numeric'
        ]);

        if (auth()->user()->update($fields)) {
            return back()->with('success', 'Personal info changed successfully!');
        }
        return back()->with('fail', 'Something went wrong. Try again!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withInput()->withErrors(['current_password' => 'Current password isn\'t correct']);
        }

        if (auth()->user()->update(['password' => bcrypt($request->password)])) {
            return back()->with('success', 'Password changed successfully!');
        }

        return back()->with('fail', 'Something went wrong. Try again!');
    }
}
