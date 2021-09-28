<?php

namespace App\Http\Controllers;

use App\Models\Foculty;
use App\Models\Module;
use Illuminate\Http\Request;

class DepartmentModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Foculty  $foculty
     * @return \Illuminate\Http\Response
     */
    public function index(Foculty $foculty)
    {
        return response($foculty->modules()->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Foculty  $foculty
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Foculty $foculty)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
            'credits' => 'required|numeric',
            'code' => 'required|string'
        ]);

        $module = $foculty->modules()->create($fields);

        return response($module);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Foculty  $foculty
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        return response($module);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Foculty  $foculty
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        $fields = $request->validate([
            'name' => 'string',
            'teacher_id' => 'exists:teachers,id',
            'credits' => 'numeric',
            'code' => 'string'
        ]);

        $module->update($fields);
        return response($module);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Foculty  $foculty
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        $deleted = $module->delete();
        return response(['deleted' => $deleted]);
    }
}
