<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::all();

        return view('teacher.index', ['teachers' => $teachers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|confirmed',
        ]);

        $fields['password'] = Hash::make($request->password);

        if (auth('admin')->check()) {
            $fields['confirmed_at'] = now();
        }

        Teacher::create($fields);

        if (auth('admin')->check()) {
            return back()->with('success', 'Teacher account created!');
        }

        return redirect()
            ->route('auth.teacher.login')
            ->with('success', 'Teacher account created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        return view('teacher.show', ['teacher' => $teacher]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        return view('teacher.edit', ['teacher' => $teacher]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $fields = $request->validate([
            'name' => 'string',
            'email' => 'email|unique:teachers,email',
            'password' => 'required_with:current_password|confirmed'
        ]);

        if ($request->has('password')) {
            if (!Hash::check($request->current_password, $teacher->password)) {
                return back()->withInput()->withErrors('Current password isn\'t correct', 'current_password');
            }

            $fields['password'] = Hash::make($fields['password']);
        }

        $teacher->update($fields);

        return back()->with('success', 'Teacher account updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return back()->with('success', 'Teacher deleted!');
    }
}
