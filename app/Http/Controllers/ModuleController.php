<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = null;
        if (request()->user()->tokenCan('user:teacher')) {
            $modules = request()->user()->modules()->paginate(50);
        } elseif (request()->user()->tokenCan('user:student')) {
            $modules = Module::hasStudent(request()->user()->id)->paginate(50);
        } else {
            $modules = Module::paginate(50);
        }

        return response($modules);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
            'credits' => 'required|numeric',
            'code' => 'required|string',
            'foculty_id' => 'required|exists:foculties,id'
        ]);

        $module = Module::create($fields);

        return response($module);
    }

    public function students(Module $module)
    {
        return $module->foculty->students()->paginate(50);
    }
}
