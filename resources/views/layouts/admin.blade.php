@extends('layouts.app')

@section('title', 'Admin ')

@section('content')

    <div class="row">
        {{-- <div class="col-sm-4 d-flex flex-column">

            <ul class="list-group my-2 rounded-lg">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="#" class="___class_+?7___">Students</a>
                    <button data-toggle="modal" data-target="#studentModal" class="btn btn-primary btn-sm small">new</button>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="#" class="___class_+?10___">Teachers</a>
                    <button data-toggle="modal" data-target="#teacherModal" class="btn btn-primary btn-sm small">new</button>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="#" class="___class_+?13___">Modules</a>
                    <button data-toggle="modal" data-target="#moduleModal" class="btn btn-primary btn-sm small">new</button>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="#" class="___class_+?16___">Marks</a>
                    <button data-toggle="modal" data-target="#marksModal" class="btn btn-primary btn-sm small">new</button>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="#" class="___class_+?16___">Foculty</a>
                    <button data-toggle="modal" data-target="#focultyModal" class="btn btn-primary btn-sm small">new</button>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="#" class="___class_+?19___">Registrations</a>
                </li>
            </ul>
        </div> --}}
        <div class="col-sm-12">
            {{-- <div class="leftbar-search p-2">
                <form action="" class="d-flex justify-content-between align-items-center" method="GET">
                    <div style="position: relative;" class="flex-grow-1 form-group d-flex align-items-center">
                        <img style="position: absolute;left: 20px;" src="/icons/search.svg" alt="search icon">
                        <input type="text" placeholder="Students, modules or teachers" name="search"
                            class="form-control rounded-pill px-4 py-3 pl-5" id="">
                    </div>
                    <button type="submit" class="btn btn-lg ml-2 btn-outline-secondary">Search</button>
                </form>
                
            </div> --}}
        @section('admin-content')

        @show
    </div>
</div>

@endsection
