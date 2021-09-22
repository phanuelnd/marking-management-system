<?php

namespace App\Http\Controllers;

use App\Models\Foculty;
use Illuminate\Http\Request;

class FocultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth('teacher')->check()) {
            $foculties = Foculty::hasTeacher(auth()->user()->id)->get()->all();
        } elseif (auth('admin')->check()) {
            $foculties = Foculty::all();
        }

        return view('foculty.index', ['foculties' => $foculties]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('foculty.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:foculties,name']);
        Foculty::create($request->only('name'));
        return back()->with('success', 'Foculty created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Foculty  $foculty
     * @return \Illuminate\Http\Response
     */
    public function show(Foculty $foculty)
    {
        return view('foculty.show', [
            'foculty' => $foculty,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Foculty  $foculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Foculty $foculty)
    {
        return view('foculty.edit', ['foculty' => $foculty]);
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
        $request->validate(['name' => 'required|string|unique:foculties,name']);
        $foculty->update($request->only('name'));

        return back()->with('success', 'Foculty updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Foculty  $foculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Foculty $foculty)
    {
        $foculty->delete();

        return back()->with('success', 'Foculty deleted!');
    }
}
