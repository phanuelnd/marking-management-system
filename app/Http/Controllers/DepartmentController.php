<?php

namespace App\Http\Controllers;

use App\Models\Foculty;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foculties = Foculty::paginate(20);
        return response($foculties);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate(['name' => 'required|string']);
        $foculty = Foculty::create($fields);
        return response($foculty, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Foculty  $foculty
     * @return \Illuminate\Http\Response
     */
    public function show(Foculty $foculty)
    {
        return response($foculty);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Foculty  $foculty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Foculty $foculty)
    {
        $fields = $request->validate(['name' => 'string']);
        $foculty->update($fields);
        return response($foculty);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Foculty  $foculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Foculty $foculty)
    {
        $deleted = $foculty->delete();
        return response(['deleted' => $deleted]);
    }
}
