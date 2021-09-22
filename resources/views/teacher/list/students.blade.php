@extends('layouts.app')

@section('title', 'Students')

@section('content')
<p>
    @if($foculty)
        <a href="{{ route('teacher.foculty.index') }}" class="text-primary">Foculties</a>
        ><a href="{{ route('teacher.foculty.show', $foculty) }}" class="text-primary">{{$foculty->name}}</a>
        ><a href="{{ route('teacher.student.index') }}?foculty={{$foculty->id}}" class="text-primary">Students</a>
    @else
        <a href="{{route('teacher.student.index')}}" class="text-primary">Students</a>
    @endif
</p>
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="m-2 mb-2">@isset($not_confirmed)
            Unconfirmed Students
            @else
             @if($foculty) <span style="font-size:medium;" class="text-primary">'{{$foculty->name}}' students</span> @endif
            @endisset
        </h2>
    </div>

    @if (!count($students))
        <div class="my-2">

            @isset($not_confirmed)
                No unconfirmed students
                <a href="{{ route('teacher.student.index') }}" class="text-prinary">See Students</a>
            @else
                No students found @if($foculty) in '{{$foculty->name}}' @endif
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
                    <a href="{{route('teacher.student.show', $student)}}">
                        <span class="d-inline-block">{{ ucwords($student->name) }}</span>
                    </a>
                </div>
                @if (session('fail' . $student->id))
                    <div class="text-danger d-inline-block">{{ session('fail' . $student->id) }}</div>
                @endif
                @if (session('success' . $student->id))
                    <div class="text-success d-inline-block">{{ session('success' . $student->id) }}</div>
                @endif
            </div>

        </div>
    @endforeach
    <div class="mt-5">
        {{$students->links()}}
    </div>


@endsection
