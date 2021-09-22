@extends('layouts.app')

@section('title', 'Add module')


@section('content')
<p>
    @if ($teacher)
        <a href="{{ route('admin.teacher.index') }}" class="text-primary">Teachers</a>
        ><a href="{{ route('admin.teacher.show', $teacher) }}" class="text-primary">{{$teacher->name}}</a>
        ><a href="{{ route('admin.module.index') }}?teacher={{$teacher->id}}" class="text-primary">Modules</a>
        ><a href="{{ route('admin.module.create') }}?teacher={{$teacher->id}}" class="text-primary">Create</a>
    @elseif($foculty)
        <a href="{{ route('admin.foculty.index') }}" class="text-primary">Foculties</a>
        ><a href="{{ route('admin.foculty.show', $foculty) }}" class="text-primary">{{$foculty->name}}</a>
        ><a href="{{ route('admin.module.index') }}?foculty={{$foculty->id}}" class="text-primary">Modules</a>
        ><a href="{{ url()->full() }}" class="text-primary">Create</a>
    @else
        <a href="{{ route('admin.module.index') }}" class="text-primary">Modules</a>
        ><a href="{{ route('admin.module.create') }}" class="text-primary">Create</a>
    @endif
</p>

<h1 class="text-center m-2">
Add module 
@if($foculty)
<a href="{{route('admin.foculty.show', $foculty)}}" class="btn btn-link">in {{ $foculty->name }}</a>
@endif
</h1>
<x-forms.module :teacher="$teacher" :teachers="$teachers" :foculty="$foculty" :foculties="$foculties" />

@endsection