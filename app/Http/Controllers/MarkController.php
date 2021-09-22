<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $student = $module = $semester = null;
        $modules = $students = [];

        $request->validate([
            'module' => 'nullable|numeric|exists:modules,id',
            'student' => 'nullable|numeric|exists:students,id',
            'semester' => 'nullable|in:I,II,III'
        ]);

        $request->flash();

        if ($request->has('modules')) {
            if (auth('teacher')->check()) {
                $modules = auth()->user()->modules()->paginate(20)->withQueryString();
            } elseif (auth('admin')->check()) {
                $modules = Module::paginate(20)->withQueryString();
            } else {
                $modules = Module::hasStudent(auth()->user()->id)->paginate(20)->withQueryString();
            }
        } elseif ($request->has('students')) {
            if (auth('teacher')->check()) {
                $students = Student::taughtBy(auth()->user()->id)->paginate(20)->withQueryString();
            } elseif (auth('admin')->check()) {
                $students = Student::paginate(20)->withQueryString();
            }
        }

        if ($request->has('module')) {
            if (auth('teacher')->check()) {
                $module = auth('teacher')->user()->modules()->whereHas('marks');
            } elseif (auth('admin')->check()) {
                $module = Module::whereHas('marks');
            } elseif (auth('student')->check()) {
                $module = Module::hasStudent(auth()->user()->id);
            }

            $module = $module->with('marks', function ($query) use ($request) {
                if ($request->get('semester', null)) {
                    $query->where('semester', $request->semester);
                }
            })->find($request->module);
        } elseif ($request->has('student')) {
            if (auth('teacher')->check()) {
                $student = Student::taughtBy(auth()->user()->id)->where('id', $request->student);
            } elseif (auth('admin')->check()) {
                $student = Student::where('id', $request->student);
            } elseif (auth('student')->check()) {
                $student = Student::where('id', auth()->user()->id);
            }

            $student = $student->with('marks', function ($query) use ($request) {
                if ($request->get('semester', null)) {
                    $query->where('semester', $request->semester);
                }
            })->find($request->student);
        }

        if ($request->get('semester', null)) {
            $semester = $request->semester;
        }

        return view('marks.index', [
            'module' => $module,
            'student' => $student,
            'students' => $students,
            'modules' => $modules,
            'semester' => $semester
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $student = null;
        $students = $modules = [];

        $request->validate(['student' => 'exists:students,id']);

        if ($request->has('student')) {
            if (auth('teacher')->check()) {
                $student = Student::taughtBy(auth()->user()->id)->findOrFail($request->student);
            } elseif (auth('admin')->check()) {
                $student = Student::find($request->student);
            }

            $modules = $student->foculty->modules;
        } else {
            if (auth('admin')->check()) {
                $students = Student::paginate(20)->withQueryString();
            } elseif (auth('teacher')->check()) {
                $students = Student::taughtBy(auth()->user()->id)->paginate(20)->withQueryString();
            }
        }

        return view('marks.create', [
            'modules' => $modules,
            'students' => $students,
            'student' => $student,
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
            'student_id' => 'required|numeric|exists:students,id',
            'module_id' => 'required|numeric|exists:modules,id',
            'marks' => 'required|numeric',
            'semester' => 'required|in:I,II,III'
        ]);

        $already_recorded = Mark::where([
            ['student_id', $request->student_id],
            ['semester', $request->semester],
            ['module_id', $request->module_id],
        ])->first();

        if ($already_recorded) {
            return back()->withInput()->with('fail', "Marks for the same student, module and semester was already recorded!");
        }

        $module = Module::find($request->module_id);
        $student = Student::find($request->student_id);

        if ($module->foculty_id !== $student->foculty_id) {
            return back()->with('fail', "Selected module doesn't belong to the student's foculty.");
        }

        Mark::create($fields);
        return back()->with('success', 'Marks recorded!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function show(Mark $mark)
    {
        if (!$mark->student) {
            throw new NotFoundHttpException('Marks belongs to non existent student!');
        }
        return view('marks.show', ['marks' => $mark]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function edit(Mark $mark)
    {
        return view('marks.edit', ['marks' => $mark]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mark $mark)
    {
        $fields = $request->validate([
            'student_id' => 'required|numeric|exists:students,id',
            'module_id' => 'required|numeric|exists:modules,id',
            'marks' => 'required|numeric',
            'semester' => 'required|in:I,II,III'
        ]);

        $mark->update($fields);

        return back()->with('success', 'Marks updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mark $mark)
    {
        $mark->delete();

        return back()->with('success', 'Marks deleted!');
    }
}
