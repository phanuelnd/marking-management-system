@extends('layouts.app')

@section('title', 'Edit teacher')

@section('content')
<p>
    <a href="{{route('admin.teacher.index')}}" class="text-primary">Teacher</a>
    ><a href="{{route('admin.teacher.show', $teacher)}}?teacher={{$teacher->id}}" class="text-primary">{{$teacher->name}}</a>
    ><a href="{{route('admin.teacher.edit', $teacher)}}" class="text-primary">Edit</a>
</p>

<h1 class="text-center m-2">Edit teacher</h1>
<x-forms.teacher :teacher="$teacher" />

@endsection
