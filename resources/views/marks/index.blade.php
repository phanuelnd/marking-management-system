@extends('layouts.app')

@section('title', 'Marks')

@section('content')
    <p>
        <a href="{{ route(auth()->user()?->getUserType() . '.marks.index') }}" class="text-primary">Marks</a>
        @if (count($students) || $student)
            ><a href="{{ url()->current() }}?students=1" class="text-primary">Students</a>
            @if ($student) ><a href="{{ url()->full() }}&student={{ $student->id }}" class="text-primary">{{ $student->name }}</a> @endif
        @elseif (count($modules) || $module)
            ><a href="{{ url()->current() }}?modules=1" class="text-primary">Modules</a>
            @if ($module) ><a href="{{ url()->full() }}&module={{ $module->id }}" class="text-primary">{{ $module->name }}</a> @endif

        @endif
    </p>
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="text-secondary">View marks </h4>
        @guest('student')
            <a href="{{ route(auth()->user()?->getUserType() . '.marks.create') }}" class="btn btn-primary">New
            marks</a>
        @endguest
    </div>
    @if ($student || $module)
        <div>
            <form action="{{ url()->current() }}" method="GET">
                <label for="semester" class="font-weight-bold d-block">Semester: </label>
                <div class="d-inline-block form-check">
                    <input checkedid="all" class="form-check-input" name="semester" value="" type="radio">
                    <label class="form-check-label" for="all">All</label>
                </div>
                <div class="d-inline-block form-check">
                    <input @if (old('semester') == 'I') checked @endif id="I" name="semester" value="I" class="form-check-input" type="radio">
                    <label class="form-check-label" for="I">I (ONE)</label>
                </div>
                <div class="d-inline-block form-check">
                    <input @if (old('semester') == 'II') checked @endif id="II" name="semester" value="II" class="form-check-input"
                        type="radio">
                    <label class="form-check-label" for="II">II (TWO)</label>
                </div>
                <div class="d-inline-block form-check">
                    <input @if (old('semester') == 'III') checked @endif id="III" name="semester" value="III" class="form-check-input"
                        type="radio">
                    <label class="form-check-label" for="III">III (THREE)</label>
                </div>
                @if (count($students))
                    <input name="students" value="1" class="d-none" />
                @elseif (count($modules))
                    <input name="modules" value="1" class="d-none" />
                @endif

                @if ($student)
                    <input name="student" value="{{ $student?->id }}" class="d-none" />
                @elseif ($module)
                    <input name="module" value="{{ $module?->id }}" class="d-none" />
                @endif

                @error('semester')
                    <small class="text-danger d-block py-1">{{ $message }}</small>
                @enderror
                <button type="submit" class="btn btn-secondary btn-sm mb-1 ml-3 mt-2">Filter</button>
            </form>
        </div>
    @endif

    @if (!$module && !$student)
        <div style="mark-grid">
            {{-- @if (isset($_GET['students']) && !count($students))

            @elseif (isset($_GET['modules']) && !count($modules))
            
            @endif --}}
            @if (!isset($_GET['students']) && !isset($_GET['modules']))
                <ul class="list-group my-2" style="max-width: 300px;">
                    @guest('student')
                        <li class="list-group-item">
                            <a class="btn btn-link" href="{{ url()->current() }}?students=1">Choose a student <svg
                                    style="color: inherit;" width="1em" height="1em" viewBox="0 0 16 16"
                                    class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z" />
                                    <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z" />
                                </svg> </a>
                        </li>
                        <strong class="mx-1">OR</strong>
                    @endguest
                    <li class="list-group-item">
                        <a class="btn btn-link" href="{{ url()->current() }}?modules=1">Choose a module <svg
                                style="color: inherit;" width="1em" height="1em" viewBox="0 0 16 16"
                                class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z" />
                                <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z" />
                            </svg></a>
                    </li>
                </ul>
            @endif
            @if (isset($_GET['students']))
                @if (count($students))
                    {{-- <div class="p-2 mb-4">
                        <form style="max-width: 500px;" action="" class="d-flex justify-content-between align-items-center"
                            method="get">
                            <div style="position: relative;" class="flex-grow-1 form-group d-flex align-items-center">
                                <img style="position: absolute;left: 20px;" src="/icons/search.svg" alt="search icon">
                                <input type="text" placeholder="Search students" name="search"
                                    class="form-control rounded-pill px-4 py-3 pl-5" id="">
                            </div>
                            <button type="submit" class="btn btn-lg ml-2 btn-secondary">Search</button>
                        </form>
                    </div> --}}
                @endif

                <div>
                    {{-- <h4 class="mb-4">Choose student</h4> --}}
                    <ul class="my-2 list-group">
                        @forelse ($students as $student)
                            <li class="list-group-item"><a href="{{ url()->full() }}&student={{ $student->id }}"
                                    class="btn btn-link">{{ $student->name }}</a></li>
                        @empty
                            <p>No students found.
                                @auth('admin')
                                    <a href="{{ route(auth()->user()?->getUserType() . '.student.create') }}" class="btn btn-link">New student</a>
                                @endauth
                        @endforelse
                    </ul>
                    @guest('student')
                        <div class="my-4">{{ $students->links() }}</div>
                    @endguest
                </div>
            @endif
            @if (isset($_GET['modules']))
                <div>
                    <h4 class="mb-4">Choose module</h4>
                    <ul class="my-2 list-group">
                        @forelse ($modules as $module)
                            <li class="list-group-item"><a href="{{ url()->full() }}&module={{ $module->id }}"
                                    class="btn btn-link">{{ $module->name }}</a></li>
                        @empty
                            <p>No modules here yet. <a
                                    href="{{ route(auth()->user()?->getUserType() . '.module.create') }}"
                                    class="btn btn-link">New module</a>
                        @endforelse
                    </ul>
                    <div class="my-4">{{ $modules->links() }}</div>

                </div>
            @endif
        </div>
    @elseif ($student)
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><a @guest('student')
                            href="{{ route(auth()->user()?->getUserType() . '.student.show', $student) }}"
                        @endguest>{{ $student->name }}</a></h4>
            </div>
            @if (count($student->marks))
                <table class="marks-table">
                    <thead>
                        <th>Module</th>
                        <th>Marks</th>
                        <th>Semester</th>
                    </thead>
                    <tbody>
            @endif
            @forelse ($student->marks as $marks)
                <tr>
                    <td>
                        <a href="{{ url()->current() }}?modules=1&module={{ $marks->module->id }}"
                            class="text-primary">
                            <span class="font-weight-bolder">{{ $marks->module->name }}</span>
                        </a>
                    </td>
                    <td><strong>{{ $marks->marks }}</strong></td>
                    <td class="text-center font-weight-bold">{{ $marks->semester }}</td>
                    <td><a href="{{ route(auth()->user()?->getUserType() . '.marks.show', $marks) }}"
                            class="btn btn-sm text-warning btn-primary">More</a></td>
                </tr>
            @empty
                <p class="p-3">Student marks not found. @guest('student') <a
                            href="{{ route(auth()->user()?->getUserType() . '.marks.create') }}?student={{ $student->id }}"
                        class="btn btn-sm btn-primary">Record new marks</a> @endguest </p>
            @endforelse
            @if (count($student->marks))
                </tbody>
                </table>
            @endif
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <a href="{{ route(auth()->user()?->getUserType() . '.module.show', $module) }}"
                        class="___class_+?59___">{{ $module->name }}</a>
                </h4>
            </div>
            @if (count($module->marks))
                <table class="marks-table">
                    <thead>
                        <th>Name</th>
                        <th>Marks</th>
                        <th>Semester</th>
                    </thead>
                    <tbody>
            @endif
            @forelse ($module->marks as $marks)
                @continue(!$marks->student)
                <tr>
                    <td>
                        <a href="{{ url()->current() }}?students=1&student={{ $marks->student->id }}"
                            class="text-primary">
                            <span class="font-weight-bolder">{{ $marks->student->name }}</span>
                        </a>
                    </td>
                    <td><strong>{{ $marks->marks }}</strong></td>
                    <td class="text-center"><strong>{{ $marks->semester }}</strong></td>
                    <td><a href="{{ route(auth()->user()?->getUserType() . '.marks.show', $marks) }}"
                            class="btn btn-sm text-warning btn-primary">More</a></td>
                </tr>
            @empty
                <p class="p-2">Marks not recorded yet. @guest('student') <a
                            href="{{ route(auth()->user()?->getUserType() . '.marks.create') }}?module={{ $module->id }}"
                        class="btn btn-link">Record new marks</a> @endguest</p>
            @endforelse
            @if (count($module->marks))
                </tbody>
                </table>
            @endif
        </div>

    @endif
@endsection
