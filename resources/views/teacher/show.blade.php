@extends('layouts.app')

@section('title', "Teacher show")


@section('content')

<p><a href="{{route('admin.teacher.index')}}" class="text-primary">Teachers</a>><a href="{{route('admin.teacher.show', $teacher)}}?teacher={{$teacher->id}}" class="text-primary">{{$teacher->name}}</a></p>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">{{$teacher->name}}</h4>
        
        <form action="{{ route('admin.teacher.reg.' . ($teacher->confirmed_at ? 'reject' : 'confirm'),$teacher) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-{{$teacher->confirmed_at ? 'danger' : 'success'}}">
                {{ucfirst($teacher->confirmed_at ? 'reject' : 'confirm')}}
            </button>
        </form>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">Index number: </span>
                <span class="text-muted mx-2 d-inline-block">{{$teacher->index_number}}</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">E-mail: </span>
                <span class="text-muted mx-2 d-inline-block">{{$teacher->email}}</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">Phone: </span>
                <span class="text-muted mx-2 d-inline-block">{{$teacher->phone ?? " - ??? -"}}</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">Registered: </span>
                <span class="text-muted mx-2 d-inline-block">{{$teacher->created_at->toDateString()}}</span>
            </div>

            <div class="d-flex align-items-center">
                <a href="{{route('admin.module.index')}}?teacher={{$teacher->id}}" class="text-primary d-inline-block">
                    <span class="font-weight-bold">Module(s): </span>({{$teacher->modules->count()}})
                </a>
            </div>
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">Marks recorded: <small>{{$teacher->marks->count()}}</small></span>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a class="btn btn-primary" href="{{route('admin.teacher.edit', $teacher)}}">
            EDIT
        </a>
        <form class="d-inline-block" action="{{route('admin.teacher.destroy', $teacher)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

@endsection