@extends('layouts.app')

@section('title', 'Teachers')

@section('content')
<p><a href="{{route('admin.teacher.index')}}" class="text-primary">Teachers</a></p>
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="m-2 mb-4">@isset($not_confirmed)
            Unconfirmed Teachers
            @else
            Teachers
            @endisset
        </h2>
        <a href="{{route('admin.teacher.create')}}" class="btn btn-primary">New teacher</a>
    </div>

    @if (!count($teachers))
        <div class="my-5">

            @isset($not_confirmed)
                No unconfirmed teachers
                <a href="{{ route('admin.teacher.index') }}" class="text-prinary">See Teachers</a>
            @else
                No registered teachers yet
                <a href="{{ route('admin.teacher.create') }}" class="text-prinary">Register Teachers</a>
            @endisset
        </div>
    @endif
    <div class="p-2 mb-4">
        <form style="max-width: 500px;" action="" class="d-flex justify-content-between align-items-center" method="get">
            <div style="position: relative;" class="flex-grow-1 form-group d-flex align-items-center">
                <img style="position: absolute;left: 20px;" src="/icons/search.svg" alt="search icon">
                <input type="text" placeholder="Teachers" name="search"
                    class="form-control rounded-pill px-4 py-3 pl-5" id="">
            </div>
            <button type="submit" class="btn btn-lg ml-2 btn-secondary">Search</button>
        </form>
        
    </div>
    @foreach ($teachers as $teacher)
        <div class="d-flex align-items-center rounded-pill p-1 m-1">
            <div>
                <span
                    class="rounded-circle bg-dark text-light font-weight-bolder border border-secondary mr-1 d-flex align-items-center justify-content-center text-center p-2"
                    style="width: 36px;height:36px;font-size:1.4rem;">{{ strtoupper($teacher->name[0]) }}</span>
            </div>
            <div class="d-flex align-items-center">
                <div class="muted ml-1 d-flex align-items-center">
                    <a href="{{route('admin.teacher.show', $teacher)}}">
                        <span class="d-inline-block">{{ ucwords($teacher->name) }}</span>
                    </a>
                </div>
                @if (session('fail' . $teacher->id))
                    <div class="text-danger d-inline-block">{{ session('fail' . $teacher->id) }}</div>
                @endif
                @if (session('success' . $teacher->id))
                    <div class="text-success d-inline-block">{{ session('success' . $teacher->id) }}</div>
                @endif
                <div class="btn-group justify-self-end d-flex align-items-center">
                    @isset($not_confirmed)
                        <form action="{{ route(auth()->user()?->getUserType() . '.teacher.reg.confirm', $teacher) }}"
                            method="post" class="mx-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-success">Confirm</button>

                        </form>
                        <form action="{{ route(auth()->user()?->getUserType() . '.teacher.reg.reject', $teacher) }}"
                            method="post" class="mx-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger">Reject</button>

                        </form>
                    @else
                        <form action="{{ route(auth()->user()?->getUserType() . '.teacher.reg.reject', $teacher) }}"
                            method="post" class="mx-1">
                            @if (session('success' . $teacher->id))
                            @endif
                            @csrf
                            <button class="btn btn-link ml-3 text-danger p-0 px-1">Reject</button>

                        </form>
                    @endisset
                </div>
            </div>

        </div>
    @endforeach

@endsection
