<?php

namespace App\Http\Controllers;

use App\Models\Student;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = null;

        if ($request->user()->tokenCan('user:teacher')) {
            $students = Student::taughtBy($request->user()->id)->paginate(50);
        } else {
            $students = Student::paginate(50);
        }
        return response($students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->user()->tokenCan('user:admin')) {
            return response(status: 403);
        }

        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'phone' => ['numeric', Rule::unique('students', 'phone')],
            'password' => 'required|confirmed',
            'index_number' => 'required',
            'foculty_id' => 'required|exists:foculties,id',
        ]);

        $fields['password'] = Hash::make($request->password);

        $student = Student::create($fields);

        return response($student, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return response($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $fields = $request->validate([
            'name' => 'string',
            'phone' => ['numeric', Rule::unique('students', 'phone')->ignore($student->id)],
            'email' => Rule::unique('students', 'email')->ignore($student->id),
            'index_number' => 'string',

        ]);

        $student->update($fields);
        return response($student);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $deleted = $student->delete();

        return response(['deleted' => $deleted], 200);
    }

    /**
     * Returns a list of student modules
     *
     * @param Student $student
     * @return \Illuminate\Http\Response
     */
    public function modules(Student $student)
    {
        return response($student->foculty->modules()->paginate(20));
    }
}
