<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
    }

    public function adminLogout(Request $request)
    {
        $this->logout($request);
        return redirect('/admin/login');
    }

    public function teacherLogout(Request $request)
    {
        $this->logout($request);
        return redirect('/teacher/login');
    }

    public function studentLogout(Request $request)
    {
        $this->logout($request);
        return redirect('/student/login');
    }
}
