@extends('layouts.app')

@section('title', 'Modules')

@section('content')
<p>
    @if ($teacher)
        @guest('student')
        <a href="{{ route(auth()->user()?->getUserType() . '.teacher.index') }}" class="text-primary">Teachers</a>
        >
        @endguest
        <a href="{{ route(auth()->user()?->getUserType() . '.teacher.show', $teacher) }}" class="text-primary">{{$teacher->name}}</a>
        >
        <a href="{{ route(auth()->user()?->getUserType() . '.module.index') }}?teacher={{$teacher->id}}" class="text-primary">Modules</a>
    @elseif($foculty)
        @guest('student')<a href="{{ route(auth()->user()?->getUserType() . '.foculty.index') }}" class="text-primary">Foculties</a>
        >@endguest<a href="{{ route(auth()->user()?->getUserType() . '.foculty.show', $foculty) }}" class="text-primary">{{$foculty->name}}</a>
        ><a href="{{ route(auth()->user()?->getUserType() . '.module.index') }}?foculty={{$foculty->id}}" class="text-primary">Modules</a>
    @else
        <a href="{{ route(auth()->user()?->getUserType() . '.module.index') }}" class="text-primary">Modules</a>
    @endif
    </p>
<div class="d-flex justify-content-between align-items-center">
    <h2 class="my-3">Modules
    @if($foculty)
    <a href="{{route(auth()->user()?->getUserType() . '.foculty.show', $foculty)}}" class="btn btn-link btn-sm"> in {{ $foculty->name }}</a>
    @endif
    </h2>
    @auth('admin')
        <a href="{{route(auth()->user()?->getUserType() . '.module.create'). ($foculty ? '?foculty='.$foculty->id:'')}}" class="btn btn-primary">New module</a>
    @endauth
</div>
@forelse ($modules as $module)
    <ul class="list-group list-unstyled" style="max-width: 500px;">
        <li class="list-group-item">
            <a href="{{ route(auth()->user()?->getUserType() . '.module.show', $module) }}">{{$module->name}}</a>
        </li>
    </ul>
@empty
<p>No modules yet.
    @auth('admin')
        <a href="{{route(auth()->user()?->getUserType() . '.module.create') . ($foculty ? '?foculty='.$foculty->id:'')}}" class="btn btn-link">Create new</a>
    @endauth
</p>
@endforelse

@endsection