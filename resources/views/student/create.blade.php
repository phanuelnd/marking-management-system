@extends('layouts.app')

@section('title', 'Register student')

@section('content')
<p><a href="{{route('admin.student.index')}}" class="text-primary">Students</a>><a href="{{route('admin.student.create')}}" class="text-primary">Create</a></p>
<h1 class="text-center m-2">Register student @if($foculty)<small style="font-size:medium;" class="text-sm text-primary"><br> in '{{$foculty->name}}'</small> @endif </h1>
<x-forms.student :foculty="$foculty" :foculties="$foculties" />

@endsection
