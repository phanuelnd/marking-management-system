<?php

namespace App\Http\Controllers;

use App\Models\Foculty;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $foculty = null;

        $request->validate([
            'foculty' => 'exists:foculties,id|numeric'
        ]);

        if ($request->has('foculty')) {
            $foculty = Foculty::find($request->foculty);
        }

        $students = !$foculty ? Student::paginate(20) : $foculty->students()->paginate(20);
        return view('student.index', [
            'students' => $students, 'foculty' => $foculty
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $foculties = [];
        $foculty = null;

        $request->validate(['foculty' => 'exists:foculties,id']);

        if ($request->has('foculty')) {
            $foculty = Foculty::find($request->foculty);
        } else {
            $foculties = Foculty::all();
        }

        return view('student.create', [
            'foculties' => $foculties,
            'foculty' => $foculty
        ]);
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
            'email' => 'required|email|unique:students,email',
            'password' => 'required|confirmed',
            'index_number' => 'required',
            'foculty_id' => 'required|exists:foculties,id',
        ]);

        $fields['password'] = Hash::make($request->password);

        if (auth('admin')->check()) {
            $fields['confirmed_at'] = now();
        }

        Student::create($fields);

        if (auth('admin')->check()) {
            return back()->with('success', 'Student account created!');
        }

        return redirect()
            ->route('auth.student.login')
            ->with('success', 'Student account created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return view('student.show', ['student' => $student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('student.edit', [
            'foculties' => Foculty::all(),
            'student' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $fields = $request->validate([
            'name' => 'string',
            'email' => 'email|unique:students,email',
            'password' => 'required_with:current_password|confirmed',
            'phone' => 'numeric'
        ]);

        if ($request->has('password')) {
            if (!Hash::check($request->current_password, $student->password)) {
                return back()->withInput()->withErrors('Current password isn\'t correct', 'current_password');
            }

            $fields['password'] = bcrypt($fields['password']);
        }

        $student->update($fields);

        return back()->with('success', 'Student account updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return back()->with('success', 'Student deleted!');
    }


    /**
     * Display a listing of the teacher students.
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherStudents(Request $request)
    {
        $foculty = null;

        $request->validate([
            'foculty' => 'exists:foculties,id|numeric'
        ]);

        if ($request->has('foculty')) {
            $foculty = Foculty::wherehas('modules', function ($query) {
                $query->where('teacher_id', auth()->user('teacher')->id);
            })->find($request->foculty);
        }

        $students = !$foculty ? Student::taughtBy(auth()->user()->id)->paginate(20) : $foculty->students()->paginate(20);

        return view('teacher.list.students', [
            'students' => $students, 'foculty' => $foculty
        ]);
    }
}
