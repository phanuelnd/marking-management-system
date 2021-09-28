<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentMarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function index(Student $student)
    {
        return response($student->marks()->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Student $student)
    {
        $fields = $request->validate([
            'module_id' => "required|exists:modules,id",
            'semester' => "required|in:I,II,III",
            'formative' => "required|numeric|max:50",
            'summative' => "required|numeric|max:50",
        ]);

        $fields['total'] = (int) $fields['formative'] + (int) $fields['summative'];
        $fields['decision'] = $fields['total'] >= 50 ? true : false;

        $marks = $student->marks()->create($fields);

        return response($marks, 201);
    }
}
