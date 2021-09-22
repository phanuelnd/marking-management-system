@extends('layouts.app')

@section('title', "Student show")


@section('content')

<p>
    <a href="{{ route(auth()->user()?->getUserType() . '.foculty.index') }}" class="text-primary">Foculties</a>
    ><a href="{{ route(auth()->user()?->getUserType() . '.foculty.show', $student->foculty) }}" class="text-primary">{{$student->foculty->name}}</a>
    ><a href="{{ route(auth()->user()?->getUserType() . '.student.index') }}?foculty={{$student->foculty->id}}" class="text-primary">Students</a>
    ><a href="{{route(auth()->user()?->getUserType() . '.student.show', $student)}}?student={{$student->id}}" class="text-primary">{{$student->name}}</a>

</p>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">{{$student->name}}</h4>
        @auth('admin')
            
        <form action="{{ route(auth()->user()?->getUserType() . '.student.reg.' . ($student->confirmed_at ? 'reject' : 'confirm'),$student) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-{{$student->confirmed_at ? 'danger' : 'success'}}">
                {{ucfirst($student->confirmed_at ? 'reject' : 'confirm')}}
            </button>
        </form>
        @endauth
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">Index number: </span>
                <span class="text-muted mx-2 d-inline-block">{{$student->index_number}}</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">E-mail: </span>
                <span class="text-muted mx-2 d-inline-block">{{$student->email}}</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">Phone: </span>
                <span class="text-muted mx-2 d-inline-block">{{$student->phone ?? " - ??? -"}}</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">Registered: </span>
                <span class="text-muted mx-2 d-inline-block">{{$student->created_at->toDateString()}}</span>
            </div>

            <div class="d-flex align-items-center">
                <span class="font-weight-bold">Foculty: </span>
                <a href="{{route(auth()->user()?->getUserType() . '.foculty.show', $student->foculty)}}" class="btn btn-link d-inline-block">{{$student->foculty->name}}</a>
            </div>
            <div class="d-flex align-items-center">
                <span class="font-weight-bold">Marks: </span>
                <a href="{{route(auth()->user()?->getUserType() . '.marks.index')}}?student={{$student->id}}" class="btn btn-link d-inline-block">{{$student->name . " (marks)" }}</a>
            </div>
        </div>
    </div>
    @auth('admin')
        
    <div class="card-footer">
        <a class="btn btn-primary" href="{{route(auth()->user()?->getUserType() . '.student.edit', $student)}}">
            EDIT
        </a>
        <form class="d-inline-block" action="{{route(auth()->user()?->getUserType() . '.student.destroy', $student)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
    @endauth
</div>

@endsection