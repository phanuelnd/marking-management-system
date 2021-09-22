<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Str;
use App\Scopes\ConfirmScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:teacher');
        $this->middleware('guest:student');
    }

    public function loginView(string $guard)
    {
        return view('auth.login', ['url' => $guard]);
    }

    public function login(Request $request, string $guard)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = null;

        if ($guard === 'student') {
            $user = Student::withoutGlobalScope(ConfirmScope::class)->where('email', '=', $request->email)->first();
        } elseif ($guard === 'teacher') {
            $user = Teacher::withoutGlobalScope(ConfirmScope::class)->where('email', '=', $request->email)->first();
        } else {
            $user = Admin::where('email', '=', $request->email)->first();
        }


        // check if user exists and password mathes
        if ($user && Hash::check($request->password, $user->password)) {

            // check if account was confirmed by the admin
            if ($user && in_array($guard, ['student', 'teacher']) && !$user->confirmed_at) {
                return back()->with('fail', 'Sorry, Your account is still waiting for admin confirmation!');
            }

            // Authenticate user
            if (Auth::guard($guard)->login($user, $request->remember_me)) {
                return redirect()->route($guard . '.dashboard');
            }
        }

        return back()->with(['fail' => 'Incorrect email or password'])->withInput($request->only('email'));
    }

    public function studentLoginView()
    {
        return $this->loginView('student');
    }

    public function studentLogin(Request $request)
    {
        return $this->login($request, 'student');
    }

    public function teacherLoginView()
    {
        return $this->loginView('teacher');
    }

    public function teacherLogin(Request $request)
    {
        return $this->login($request, 'teacher');
    }

    public function adminLoginView()
    {
        return $this->loginView('admin');
    }

    public function adminLogin(Request $request)
    {
        return $this->login($request, 'admin');
    }
}
