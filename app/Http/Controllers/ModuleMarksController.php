<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModuleMarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function index(Module $module)
    {
        $user = request()->user();

        if ($user->tokenCan("user:student")) {
            $marks = $module->marks()->where("student_id", $user->id)->paginate(20);
        } elseif ($user->tokenCan("user:teacher")){
            $marks = $module->marks()->whereHas("module", function ($query) {
                $query->where("teacher_id", request()->user()->id);
            })->paginate(20);
        } else {
            $marks = $module->marks()->paginate(20);
        }

        return response($marks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Module $module)
    {
        $fields = $request->validate([
            'student_id' => "required|exists:students,id",
            'semester' => "required|in:I,II",
            'formative' => "required|numeric|max:50",
            'summative' => "required|numeric|max:50",
            'academic_year' => 'required|regex:/^(\d){4}+ (-|\/) +(\d){4}$/'
        ]);

        $student = Student::find($request->student_id);
        if ($student->foculty->id !== $module->foculty->id) {
            // Validator::validat' => $student])
        }

        $fields['total'] = (int) $fields['formative'] + (int) $fields['summative'];
        $fields['decision'] = $fields['total'] >= 50 ? true : false;

        $marks = $module->marks()->create($fields);

        return response($marks, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function show(Mark $mark)
    {
        return response($mark);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mark $mark)
    {
        $fields = $request->validate([
            'module_id' => "exists:modules,id",
            'student_id' => "exists:students,id",
            'semester' => "in:I,II,III",
            'formative' => "numeric|max:50",
            'summative' => "numeric|max:50",
        ]);

        $fields['total'] = (int) $request->get('formative', $mark->formative) + (int) $request->get('summative', $mark->summative);
        $fields['decision'] = $fields['total'] >= 50 ? true : false;

        $mark->update($fields);

        return response($mark);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mark $mark)
    {
        $deleted = $mark->delete();

        return response(['deleted' => $deleted]);
    }
}
