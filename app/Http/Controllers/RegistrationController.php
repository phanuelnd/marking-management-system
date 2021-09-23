<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    // public function

    public function listStudents()
    {
        $students = Student::unconfirmed()->paginate(20);
        // dd($students);
        return view('student.index', [
            'students' => $students,
            'not_confirmed' => true,
            'foculty' => null
        ]);
    }

    public function listRejectedStudents()
    {
        return view('student.rejected', [
            'students' => Student::rejected()
        ]);
    }

    public function restoreStudent(Student $student)
    {
        $student->restore();

        return back()->with('success', 'Student was confirmed!');
    }

    public function confirmStudent(Student $student)
    {
        $student->update(['confirmed_at' =>  now()]);
        return back()->with('success' . $student->id, 'Student registration confirmed!');
    }

    public function rejectStudent(Student $student)
    {
        if (!$student->delete()) {
            return back()->with('fail' . $student->id, 'Student rejection failed!');
        }

        return back()->with('success' . $student->id, 'Student registration rejected!');
    }

    public function listTeachers()
    {
        $teachers = Teacher::unconfirmed()->get()->all();

        return view('teacher.index', [
            'teachers' => $teachers,
            'not_confirmed' => true
        ]);
    }

    public function listRejectedTeachers()
    {
        return view('teacher.rejected', [
            'teachers' => Teacher::rejected()
        ]);
    }

    public function restoreTeacher(Teacher $teacher)
    {
        $teacher->restore();

        return back()->with('success', 'Teacher was confirmed!');
    }

    public function confirmTeacher(Teacher $teacher)
    {
        // $teacher->confirmed_at = date('Y-m-d h:i:s');

        if (!$teacher->update(['confirmed_at' => now()])) {
            return back()->with('fail' . $teacher->id, 'Teacher can\'t be confirmed!');
        }

        return back()->with('success' . $teacher->id, 'Teacher registration confirmed!');
    }

    public function rejectTeacher(Teacher $teacher)
    {
        $teacher->delete();

        return back()->with('success' . $teacher->id, 'Teacher registration rejected!');
    }
}
