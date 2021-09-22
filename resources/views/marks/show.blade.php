@extends('layouts.app')


@section('title', 'Show marks')

@section('content')

    <p>
        <a href="{{ route(auth()->user()?->getUserType() . '.marks.index') }}" class="text-primary">Marks</a>
        ><a href="{{ route(auth()->user()?->getUserType() . '.marks.index') }}?students=1"
            class="text-primary">Students</a>
        @if ($marks->student) ><a href="{{ url()->current() }}?students=1&student={{ $marks->student->id }}" class="text-primary">{{ $marks->student->name }}</a> @endif
        ><a href="{{ route(auth()->user()?->getUserType() . '.marks.index') }}?modules=1"
            class="text-primary">Modules</a>
        ><a href="{{ url()->current() }}??modules=1&module={{ $marks->module->id }}"
            class="text-primary">{{ $marks->module->name }}</a>

    </p>


    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <a @guest('student') href="{{ route(auth()->user()?->getUserType() . '.student.show', $marks->student) }}" @endguest>{{ $marks->student->name }}</a>'s
                Marks in
                '<a
                    href="{{ route(auth()->user()?->getUserType() . '.module.show', $marks->module) }}">{{ $marks->module->name }}</a>'
            </h4 class="card-title">
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold">Foculty:</span>
                    <a href="{{ route(auth()->user()?->getUserType() . '.foculty.show', $marks->student->foculty) }}"
                        class="btn btn-link">{{ $marks->student->foculty->name }}</a>
                </div>
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold">Module:</span>
                    <a href="{{ route(auth()->user()?->getUserType() . '.module.show', $marks->module) }}"
                        class="btn btn-link">{{ $marks->module->name }}</a>
                </div>
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold">Student:</span>
                    <a @guest('student') href="{{ route(auth()->user()?->getUserType() . '.student.show', $marks->student) }}" @endguest
                        class="btn btn-link">{{ $marks->student->name }}</a>
                </div>
                @auth('admin')
                    <div class="d-flex align-items-center">
                        <span class="font-weight-bold">Teacher:</span>
                        <a href="{{ route(auth()->user()?->getUserType() . '.teacher.show', $marks->module->teacher) }}"
                            class="btn btn-link">{{ $marks->module->teacher->name }}</a>
                    </div>
                @endauth
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold">Marks:</span>
                    <a href="{{ route(auth()->user()?->getUserType() . '.marks.show', $marks) }}"
                        class="btn btn-link">{{ $marks->marks }}</a>
                </div>
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold">Semester:</span>
                    <span class="ml-2">{{ $marks->semester }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold">Date:</span>
                    <span class="ml-2">{{ $marks->created_at->toDateString() }}</span>
                </div>
            </div>
        </div>
        @guest('student')
        <div class="card-footer">
            <a class="btn btn-primary" href="{{ route(auth()->user()?->getUserType() . '.marks.edit', $marks) }}">
                EDIT
            </a>
            <form class="d-inline-block" action="{{ route(auth()->user()?->getUserType() . '.marks.destroy', $marks) }}"
                method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
        @endguest
    </div>

@endsection
