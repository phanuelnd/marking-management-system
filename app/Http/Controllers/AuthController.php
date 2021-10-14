<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'user_type' => 'required|in:admin,student,teacher'
        ]);

        $user = match ($request->user_type) {
            'admin' => Admin::where('email', $request->email)->first(),
            'teacher' => Teacher::where('email', $request->email)->first(),
            'student' => Student::where('email', $request->email)->first()
        };

        if (!($user && Hash::check($request->password, $user->password))) {
            return response(['message' => "Incorrect email or password"], 400);
        }

        $token = $user->createToken('my_user_token', ['user:' . $request->user_type])->plainTextToken;
        $user->type = $request->user_type;

        return response(['user' => $user, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user->tokens()->delete()) {
            return response(status: 200);
        }

        return response(status: 403);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        if ($user->tokenCan('user:admin')) {
            $user->type = 'admin';
        } elseif ($user->tokenCan('user:teacher')) {
            $user->type = 'teacher';
        } elseif ($user->tokenCan('user:student')) {
            $user->type = 'student';
        }

        return response($user);
    }
}
