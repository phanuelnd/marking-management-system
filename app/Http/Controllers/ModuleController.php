<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        return Module::paginate(20);
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
}
