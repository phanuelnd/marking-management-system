@extends('layouts.admin')

@section('title', ucfirst(auth()->user()?->getUserType()) . ' Dashboard')

@section('scripts')
    <script defer>
        // window.URLSearchParams()
    </script>
@endsection

@section('admin-content')

    {{-- filters --}}
    <form action="{{ url()->current() }}" method="GET" class="d-flex flex-wrap align-items-center flex-row form-inline">
        <div class="form-group mt-2 ml-1">
            {{-- @csrf --}}
            <select id="mod" name="module"
                class="form-control {{ old('module') ? 'border border-success' : '' }} @error('module')
                border-danger @enderror">
                <option value="" class="text-muted" selected>--Module--</option>
                @foreach ($modules as $module)
                    <option @if ($module->id == old('module')) selected @endif value="{{ $module->id }}">{{ $module->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group  mt-2 ml-1">
            <select name="semester" id="sem"
                class="form-control {{ old('semester') ? 'border border-success' : '' }} @error('semester')
                border-danger @enderror">
                <option value="" selected>--semester--</option>
                <option @if ('I' == old('semester')) selected @endif value="I">I</option>
                <option @if ('II' == old('semester')) selected @endif value="II">II</option>
                <option @if ('III' == old('semester')) selected @endif value="III">III</option>
            </select>
        </div>
        @guest('student')
            
        <div class="form-group mt-2 ml-1">
            <select name="foculty" id="sem"
            class="form-control {{ old('foculty') ? 'border border-success' : '' }} @error('foculty')
            border-danger @enderror">
            <option class="text-muted" value="" selected>--Foculty--</option>
            @foreach ($foculties as $foculty)
            <option @if ($foculty->id == old('foculty')) selected @endif value="{{ $foculty->id }}">{{ $foculty->name }}</option>
            @endforeach
        </select>
    </div>
    @else
    <input type="hidden" name="foculty" value="{{auth('student')->user()->foculty->id}}">
    @endguest
        @guest('teacher')

            <div class="form-group mt-2 ml-1">
                <select name="teacher" id="sem"
                    class="form-control {{ old('teacher') ? 'border border-success' : '' }} @error('teacher')
            border-danger @enderror">
                    <option value="" class="text-muted" selected>--Teacher--</option>
                    @foreach ($teachers as $teacher)
                        <option @if ($teacher->id == old('teacher')) selected @endif value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
        @endguest
        <div class="form-group mt-2 ml-1">
            <input value="{{ isset($_GET['min_marks']) ? $_GET['min_marks'] : null }}" name="min_marks" type="number"
                placeholder="min marks"
                class="form-control  {{ old('min_marks') ? 'border border-success' : '' }} @error('min_marks') border-danger @enderror">
        </div>
        <div class="form-group mt-2 ml-1">
            <input value="{{ isset($_GET['max_marks']) ? $_GET['max_marks'] : null }}" name="max_marks" type="number"
                placeholder="max marks"
                class="form-control {{ old('max_marks') ? 'border border-success' : '' }} @error('max_marks') border-danger @enderror">
        </div>

        <div class="w-100 d-flex mt-2 justify-content-start">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="w-100 d-flex mt-2 justify-content-start">
            <button style="justify-self: flex-end;" class="btn px-3 m-1 btn-dark btn-sm align-self-end">Apply</button>
        </div>
    </form>


    {{-- end filters --}}
    {{-- table --}}
    @if (count($marks))
        <table class="marks-table">
            <thead>
                <th>Student</th>
                <th>Foculty</th>
                <th>Module</th>
                <th>Teacher</th>
                <th>Marks</th>
                <th>Semester</th>
            </thead>
            <tbody>
    @endif
    @forelse ($marks as $mark)
        <tr>
            @guest('student')
                
            <td><a href="{{ route(auth()->user()?->getUserType() . '.student.show', [$mark->student]) }}">{{ $mark->student->name }}</a></td>
            @else
            <td><a>{{ $mark->student->name }}</a></td>
            @endguest
            <td><a
                    href="{{ route(auth()->user()?->getUserType() . '.foculty.show', $mark->student->foculty) }}">{{ $mark->student->foculty->name }}</a>
            </td>
            <td><a href="{{ route(auth()->user()?->getUserType() . '.module.show', $mark->module) }}">{{ $mark->module?->name }}</a></td>
            <td>
                @auth('admin')
                    
                <a
                href="{{ route(auth()->user()?->getUserType() . '.teacher.show', $mark->module?->teacher) }}">{{ $mark->module?->teacher->name }}</a>
                @endauth
                @auth('teacher')
                <a>{{ $mark->module?->teacher->name }}</a>
                @endauth
            </td>
            <td><a href="{{ route(auth()->user()?->getUserType() . '.marks.show', $mark) }}">{{ $mark->marks }}</a></td>
            <td>{{ $mark->semester }}</td>
        </tr>
    @empty
        <p class="my-3">No marks found.</p>
        @guest('student')
        <a href="{{ route(auth()->user()?->getUserType() . '.marks.create') }}" class="btn btn-sm btn-primary">Record marks</a>
        @endguest
    @endforelse
    @if (count($marks))
        </tbody>
        </table>
    @endif
    {{-- end table --}}
@endsection
