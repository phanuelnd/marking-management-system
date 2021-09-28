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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module, Mark $mark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module, Mark $mark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module  $module
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module, Mark $mark)
    {
        //
    }
}
