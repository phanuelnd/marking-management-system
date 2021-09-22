@extends('layouts.app')

@section('title', 'Record marks')


@section('content')
    <p>
        <a href="{{ route(auth()->user()?->getUserType() . '.marks.index') }}" class="text-primary">Marks</a>
        ><a href="{{ route(auth()->user()?->getUserType() . '.marks.create') }}" class="text-primary">Create</a>
        @if(count($students) || $student)
            ><a href="{{ url()->current()}}?students=1" class="text-primary">Students</a>
            @if($student) ><a href="{{ url()->full() }}&student={{$student->id}}" class="text-primary">{{$student->name}}</a> @endif
        @endif

    </p>

    {{-- <p>
        @if ($teacher)
            <a href="{{ route(auth()->user()?->getUserType() . '.teacher.index') }}" class="text-primary">Teachers</a>
            ><a href="{{ route(auth()->user()?->getUserType() . '.teacher.show', $teacher) }}" class="text-primary">{{$teacher->name}}</a>
            ><a href="{{ route(auth()->user()?->getUserType() . '.module.index') }}?teacher={{$teacher->id}}" class="text-primary">Modules</a>
        @elseif($foculty)
            <a href="{{ route(auth()->user()?->getUserType() . '.foculty.index') }}" class="text-primary">Foculties</a>
            ><a href="{{ route(auth()->user()?->getUserType() . '.foculty.show', $foculty) }}" class="text-primary">{{$foculty->name}}</a>
            ><a href="{{ route(auth()->user()?->getUserType() . '.module.index') }}?foculty={{$foculty->id}}" class="text-primary">Modules</a>
        @else
            <a href="{{ route(auth()->user()?->getUserType() . '.module.index') }}" class="text-primary">Modules</a>
        @endif
    </p> --}}

    @if ($student)
        <div>
        <h4 class="text-center m-2">Record marks for <a href="{{route(auth()->user()?->getUserType() . '.student.show', $student)}}" class="btn btn-link">{{ $student->name }}</a></h4>
            @if(count($modules))
                <x-forms.marks :student='$student' :modules="$modules" />
            @else
                <p class="text-danger text-center">
                    <a href="{{ route(auth()->user()?->getUserType() . '.foculty.show', $student->foculty)}}">
                        {{$student->foculty->name}}
                    </a>
                    <span class="pl-2">does not have any modules to record marks for.</span>
                </p>
            @endif
        </div>
    @else
         @if(count($students))
         <h5 class="mt-2 mb-4">
            Choose student to record marks for.
            {{-- <strong class="text-primary">OR</strong>
            <a class="btn btn-primary " href="{{url()->current()}}?modules=1">Choose a module instead ?</a> --}}
         </h5> 
         
         @endif
        @forelse ($students as $std)
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{ route(auth()->user()?->getUserType() . '.marks.create') }}?student={{ $std->id }}"
                        class="btn btn-link">{{ $std->name }}</a>
                </li>
            </ul>
        @empty
            <p>No students are available.
                @auth('admin')
                    
                <a href="{{ route(auth()->user()?->getUserType() . '.student.create') }}" class="ml-2 btn btn-link">Register new</a>
                @endauth
            </p>
        @endforelse
    @endif

@endsection
