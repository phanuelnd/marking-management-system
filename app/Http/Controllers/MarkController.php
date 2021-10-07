<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MarkController extends Controller
{
    public function index(Request $request)
    {
        // return response($request->all(), 400);
        return response(Mark::where([
            ["semester", "=", $request->semester],
            ["academic_year", "=", $request->academic_year]
        ])->paginate(20));
        // return Mark::where([["semester", "=", "I"],["academic_year", "=", "2021-2022"]])->paginate(20);
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'student_id' => 'required|exists:students,id',
                'module_id' => "required|exists:modules,id",
                'semester' => "required|in:I,II",
                'formative' => "required|numeric|max:50",
                'summative' => "required|numeric|max:50",
                'academic_year' => ['required', 'regex:/^(\d){4}+( |)(-|\/)( |)+(\d){4}$/']
            ],
        );


        $validator->after(function ($validator) use ($request) {
            $student = Student::find($request->student_id);
            $module = Module::find($request->module_id);
            if ($student && $module && $student->foculty_id !== $module->foculty_id) {
                $validator->errors()->add(
                    'module_id',
                    'Selected module don\'t exist student\'s department.'
                );
            }
        });

        $fields = $validator->validate();

        $fields['total'] = (int) $fields['formative'] + (int) $fields['summative'];
        $fields['decision'] = $fields['total'] >= 50 ? true : false;

        $marks = Mark::create($fields);

        return response($marks);
    }
}
