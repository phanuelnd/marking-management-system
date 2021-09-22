@extends('layouts.app')


@section('title', 'Show Foculty')

@section('content')
<p>
    <a href="{{route(auth()->user()?->getUserType() . '.foculty.index')}}" class="text-primary">Foculties</a>
    ><a href="{{route(auth()->user()?->getUserType() . '.foculty.show', $foculty)}}" class="text-primary">{{$foculty->name}}</a>
</p>
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="my-3">{{$foculty->name}}</h4>
            @auth('admin')
            <a href="{{route(auth()->user()?->getUserType() . '.module.create')}}?foculty={{$foculty->id}}" class="btn btn-primary">Add module</a>
            @endauth
        </div>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <a href="{{route(auth()->user()?->getUserType() . '.module.index')}}?foculty={{$foculty->id}}" class="btn btn-link">Modules ({{$foculty->modules->count()}})</a>
                <a href="{{route(auth()->user()?->getUserType() . '.student.index')}}?foculty={{$foculty->id}}" class="btn btn-link">Students ({{$foculty->students->count()}})</a>
            </div>
        </div>
    </div>
    @auth('admin')
    <div class="card-footer">
        <a class="btn btn-primary" href="{{route(auth()->user()?->getUserType() . '.foculty.edit', $foculty)}}">
            EDIT
        </a>
        <form class="d-inline-block" action="{{route(auth()->user()?->getUserType() . '.foculty.destroy', $foculty)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
    @endauth
</div>
@endsection