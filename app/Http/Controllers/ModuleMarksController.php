<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Module;
use Illuminate\Http\Request;

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
        return response($module->marks()->paginate(20));
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
            'semester' => "required|in:I,II,III",
            'formative' => "required|numeric|max:50",
            'summative' => "required|numeric|max:50",
        ]);

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
