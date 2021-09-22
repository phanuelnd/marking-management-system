<?php

namespace App\Http\Controllers;

use App\Models\Foculty;
use App\Models\Module;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modules =  [];
        $foculty = $teacher = null;

        $request->validate([
            'foculty' => 'exists:foculties,id',
            'teacher' => 'exists:teachers,id'
        ]);

        if ($request->has('foculty')) {
            if (auth('admin')->check()) {
                $foculty = Foculty::find($request->foculty);
            } elseif (auth('teacher')->check()) {
                $foculty = Foculty::whereHas(
                    'modules',
                    function ($query) {
                        $query->where('teacher_id', auth()->user()->id);
                    }
                )->find($request->foculty);
            } elseif (auth('student')->check()) {
                $foculty = auth()->user()->foculty;
            }
            $modules = $foculty?->modules ?? [];
        } elseif (!auth('teacher')->check() && $request->has('teacher')) {
            $teacher = Teacher::find($request->teacher);
            $modules = $teacher->modules;
        } else {
            if (auth('admin')->check()) {
                $modules = Module::all();
            } elseif (auth('teacher')->check()) {
                $modules = Teacher::find(auth()->user()->id)->modules;
            } elseif (auth('student')->check()) {
                $modules = Module::hasStudent(auth()->user()->id)->get()->all();
            }
        }

        return view('module.index', [
            'foculty' => $foculty,
            'teacher' => $teacher,
            'modules' => $modules
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $foculties = $teachers = [];
        $foculty = $teacher = null;

        $request->validate([
            'foculty' => 'exists:foculties,id',
            'teacher' => 'exists:teachers,id'
        ]);

        if ($request->has('teacher')) {
            $teacher = Teacher::find($request->teacher);
        } else {
            $teachers = Teacher::all();
        }

        if ($request->has('foculty')) {
            $foculty = Foculty::find($request->foculty);
        } else {
            $foculties = Foculty::all();
        }

        return view('module.create', [
            'teachers' => $teachers,
            'foculties' => $foculties,
            'foculty' => $foculty,
            'teacher' => $teacher
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
            'name' => 'required|string',
            'foculty_id' => 'required|numeric|exists:foculties,id',
            'teacher_id' => 'required|numeric'
        ]);

        Module::create($fields);

        return back()->with('success', 'Module created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        return view('module.show', ['module' => $module]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        return view('module.edit', [
            'module' => $module,
            'teachers' => Teacher::all(),
            'foculties' => Foculty::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'foculty_id' => 'required|numeric|exists:foculties,id',
            'teacher_id' => 'required|numeric'
        ]);

        $module->update($fields);

        return back()->with('success', 'Module updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        $module->delete();

        return back()->with('success', 'Module deleted!');
    }
}
