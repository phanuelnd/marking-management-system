<?php

namespace App\Http\Controllers;

use App\Models\Foculty;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:teacher');
        $this->middleware('guest:student');
    }

    public function studentRegisterView()
    {
        return view('auth.register', ['url' => 'student', 'foculties' => Foculty::all()]);
    }

    public function teacherRegisterView()
    {
        return view('auth.register', ['url' => 'teacher']);
    }
}
