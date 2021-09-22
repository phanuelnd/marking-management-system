@extends('layouts.app')

@section('title', 'Edit student')

@section('content')
<p>
    <a href="{{route('admin.student.index')}}" class="text-primary">Students</a>
    ><a href="{{route('admin.student.show', $student)}}?student={{$student->id}}" class="text-primary">{{$student->name}}</a>
    ><a href="{{route('admin.student.edit', $student)}}" class="text-primary">Edit</a>
</p>

<h1 class="text-center m-2">Edit student</h1>
<x-forms.student :foculties="$foculties" :student="$student" />

@endsection
