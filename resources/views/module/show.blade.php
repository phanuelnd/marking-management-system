@extends('layouts.app')


@section('title', 'Show Module')

@section('content')

<p>
    <a @guest('student') href="{{ route(auth()->user()?->getUserType() . '.foculty.index') }}" @endguest class="text-primary">Foculties</a>
    ><a href="{{ route(auth()->user()?->getUserType() . '.foculty.show', $module->foculty) }}" class="text-primary">{{$module->foculty->name}}</a>
    ><a href="{{ route(auth()->user()?->getUserType() . '.module.index') }}?foculty={{$module->foculty->id}}" class="text-primary">Modules</a>
    ><a href="{{ route(auth()->user()?->getUserType() . '.module.show', $module) }}" class="text-primary">{{$module->name}}</a>

</p>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="my-3">{{$module->name}}</h4>
            @guest('student')
            <a href="{{route(auth()->user()?->getUserType() . '.marks.create')}}?module={{$module->id}}" class="btn btn-primary">Add marks</a>
            @endguest
        </div>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">Foculty:</span>
                <a href="{{route(auth()->user()?->getUserType() . '.foculty.show', $module->foculty)}}" class="btn btn-link">{{$module->foculty->name}}</a>
            </div>
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">Teacher:</span>
                
                <a @guest('teacher') href="{{route(auth()->user()?->getUserType() . '.teacher.show', $module->teacher)}}" @endguest class="btn btn-link">{{$module->teacher->name}}</a>
                
            </div>
        </div>
        
        <div class="card-body">
            <div class="d-flex align-items-center">
                <a href="{{route(auth()->user()?->getUserType() . '.marks.index')}}?module={{$module->id}}" class="btn btn-link">Marks recorded ({{$module->marks->count()}}).</a>
            </div>
        </div>
    </div>
    @auth('admin')
        
    <div class="card-footer">
        <a class="btn btn-primary" href="{{route(auth()->user()?->getUserType() . '.module.edit', $module)}}">
            EDIT
        </a>
        <form class="d-inline-block" action="{{route(auth()->user()?->getUserType() . '.module.destroy', $module)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
    @endauth
</div>
@endsection