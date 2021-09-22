@extends('layouts.app')

@section('title', 'Edit Marks')

@section('content')
<p>
    <a href="{{route(auth()->user()?->getUserType() . '.marks.index')}}" class="text-primary">Marks</a>
    ><a href="{{route(auth()->user()?->getUserType() . '.marks.show', $marks)}}?student={{$marks->student->id}}" class="text-primary">{{$marks->student->name}}</a>
    ><a href="{{route(auth()->user()?->getUserType() . '.marks.edit', $marks)}}" class="text-primary">Edit</a>
    @if ($marks)
    ><a href="{{route(auth()->user()?->getUserType() . '.marks.edit', $marks)}}" class="text-primary">{{$marks->module->name}}</a>
    @endif

</p>
<x-forms.marks :marks="$marks" />

@endsection