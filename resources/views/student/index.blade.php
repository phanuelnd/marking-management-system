@extends('layouts.app')

@section('title', 'Students')

@section('content')
<p>
    @if($foculty)
        <a href="{{ route('admin.foculty.index') }}" class="text-primary">Foculties</a>
        ><a href="{{ route('admin.foculty.show', $foculty) }}" class="text-primary">{{$foculty->name}}</a>
        ><a href="{{ route('admin.student.index') }}?foculty={{$foculty->id}}" class="text-primary">Students</a>
    @else
        <a href="{{route('admin.student.index')}}" class="text-primary">Students</a>
    @endif  
</p>
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="m-2">@isset($not_confirmed)
            Unconfirmed Students
            @else
            Students  @if($foculty)<small style="font-size:medium;" class="text-primary"> in '{{$foculty->name}}'</small> @endif
            @endisset
        </h2>
        <a href="{{route('admin.student.create')}}" class="btn btn-primary">New student</a>
    </div>

    @if (!count($students))
        <div class="my-2">

            @isset($not_confirmed)
                No unconfirmed students
                <a href="{{ route('admin.student.index') }}" class="text-prinary">See Students</a>
            @else
                No registered students @if($foculty) in '{{$foculty->name}}' @endif found
                &nbsp;<a href="{{ route('admin.student.create') . ($foculty ? '?foculty='.$foculty->id : '') }}" class="text-prinary">Register Students</a>
            @endisset
        </div>
    @endif
    <div class="p-2 mb-4">
        <form style="max-width: 500px;" action="" class="d-flex justify-content-between align-items-center" method="get">
            <div style="position: relative;" class="flex-grow-1 form-group d-flex align-items-center">
                <img style="position: absolute;left: 20px;" src="/icons/search.svg" alt="search icon">
                <input type="text" placeholder="Students" name="search"
                    class="form-control rounded-pill px-4 py-3 pl-5" id="">
            </div>
            <button type="submit" class="btn btn-lg ml-2 btn-secondary">Search</button>
        </form>
        
    </div>
    @foreach ($students as $student)
        <div class="d-flex align-items-center rounded-pill p-1 m-1">
            <div>
                <span
                    class="rounded-circle bg-dark text-light font-weight-bolder border border-secondary mr-1 d-flex align-items-center justify-content-center text-center p-2"
                    style="width: 36px;height:36px;font-size:1.4rem;">{{ strtoupper($student->name[0]) }}</span>
            </div>
            <div class="d-flex align-items-center">
                <div class="muted ml-1 d-flex align-items-center">
                    <a href="{{route('admin.student.show', $student)}}">
                        <span class="d-inline-block">{{ ucwords($student->name) }}</span>
                    </a>
                </div>
                @if (session('fail' . $student->id))
                    <div class="text-danger d-inline-block">{{ session('fail' . $student->id) }}</div>
                @endif
                @if (session('success' . $student->id))
                    <div class="text-success d-inline-block">{{ session('success' . $student->id) }}</div>
                @endif
                <div class="btn-group justify-self-end d-flex align-items-center">
                    @isset($not_confirmed)
                        <form action="{{ route(auth()->user()?->getUserType() . '.student.reg.confirm', $student) }}"
                            method="post" class="mx-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-success">Confirm</button>

                        </form>
                        <form action="{{ route(auth()->user()?->getUserType() . '.student.reg.reject', $student) }}"
                            method="post" class="mx-1">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger">Reject</button>

                        </form>
                    @else
                        <form action="{{ route(auth()->user()?->getUserType() . '.student.reg.reject', $student) }}"
                            method="post" class="mx-1">
                            @if (session('success' . $student->id))
                            @endif
                            @csrf
                            <button class="btn btn-link ml-3 text-danger p-0 px-1">Reject</button>

                        </form>
                    @endisset
                </div>
            </div>

        </div>
    @endforeach
    <div class="mt-5">
        {{$students->links()}}
    </div>


@endsection
