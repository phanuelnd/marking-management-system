<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Foculty;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Teacher;
use Hamcrest\Core\AllOf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $modules = $foculties = $teachers = [];

        $request->validate([
            'module' => 'nullable|exists:modules,id',
            'foculty' => 'nullable|exists:foculties,id',
            'teacher' => 'nullable|exists:teachers,id',
            'semester' => 'nullable|in:I,II,III',
            'min_marks' => 'nullable|numeric',
            'max_marks' => 'nullable|numeric'
        ]);



        $request->flash();

        $marks = Mark::join('students', 'students.id', '=', 'marks.student_id')
            ->join('modules', 'modules.id', '=', 'marks.module_id')
            ->where(function (Builder $query) use ($request) {
                $query->where(function (Builder $query) use ($request) {
                    $request->foculty ?  $query->where('students.foculty_id', $request->foculty) : null;
                    $request->module ? $query->where('marks.module_id', $request->module) : null;
                    $request->semester ? $query->where('marks.semester', $request->semester) : null;
                    $request->min_marks ? $query->where('marks.marks', '>=', $request->min_marks) : null;
                    $request->max_marks ? $query->where('marks.marks', '<=', $request->max_marks) : null;

                    if (auth('teacher')->check()) {
                        $query->where('modules.teacher_id', auth()->user()->id);
                    } else {
                        $request->teacher ?  $query->where('modules.teacher_id', $request->teacher) : null;
                    }

                    if (auth('student')->check()) {
                        $query->where('students.id', auth()->user()->id);
                    }
                });
            })
            ->where(function (Builder $query) use ($request) {
                if (auth('student')->check()) {
                    $query->where('students.foculty_id', auth()->user()->foculty->id);
                } else {
                    $request->foculty ? $query->where('students.foculty_id', $request->foculty) : null;
                }
            })
            ->whereHas('module', function (Builder $query) {
                if (auth('teacher')->check()) {
                    $query->where('teacher_id', auth()->user()->id);
                }
            })
            ->with(['module', 'student'])
            ->select(['marks.*'])->get()->all();

        // dd($marks[0]->student);

        if (auth('teacher')->check()) {
            $modules = auth()->user()->modules;
            $foculties = Foculty::hasTeacher(auth()->user()->id)->get()->all();
        } elseif (auth('admin')->check()) {
            $modules = Module::all();
            $foculties = Foculty::all();
            $teachers = Teacher::all();
        } elseif (auth('student')->check()) {
            $modules = Module::hasStudent(auth()->user()->id)->get()->all();
            $teachers = Teacher::hasStudent(auth()->user()->id);
        }

        return view('admin.dashboard', [
            'modules' => $modules,
            'foculties' => $foculties,
            'teachers' => $teachers,
            'marks' => $marks
        ]);
    }
}
