@extends('layouts.app')

@section('title', 'Account')


@section('content')
    <div class="d-flex align-items-center justify-content-between">

        <h4>
            <div class="ml-1">
                {{ auth()->user()->name }}
            </div>
        </h4>

        {{-- <div class="position-relative mr-4 justify-self-end">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-badge" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M12 1H4a1 1 0 0 0-1 1v11.755S4 12 8 12s5 1.755 5 1.755V2a1 1 0 0 0-1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
            <path fill-rule="evenodd" d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM6 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5z"/>
        </svg>
        <span class="text-light small rounded-pill bg-warning p-2 py-1">{{auth()->user()?->getUserType()}}</span>
    </div> --}}
    </div>

    <div class="row">
        <div class="col-md-6">
            <h6 class="text-muted my-3 mt-4">Actions</h6>
            <ul class="list-group" style="max-width: 300px">
                <li class="list-group-item">
                    <a href="{{ url()->current() }}?personal=1" class="list-group-item-action">
                        Change personal info
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z" />
                            <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z" />
                        </svg>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="{{ url()->current() }}?email=1" class="list-group-item-action">
                        Change email
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z" />
                            <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z" />
                        </svg>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="{{ url()->current() }}?password=1" class="list-group-item-action">
                        Change password
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z" />
                            <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            @if (session('success'))
                <div class="alert alert-success my-1">{{ session('success') }}</div>
            @elseif (session('fail'))
                <div class="alert alert-danger my-1">{{ session('fail') }}</div>
            @endif
            @if (isset($_GET['email']))
                <h5>Update e-mail</h5>
                <form action="{{ route(auth()->user()?->getUserType() . '.account.email') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input class="form-control @error('email') border-danger @enderror" id="email"
                            type="email" placeholder="New email.." name="email" value="{{ auth()->user()->email }}">
                        @error('email')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <button class="btn btn-primary mt-3">Update Email</button>
                </form>
            @elseif (isset($_GET['personal']))
                <h5>Update Personal info</h5>
                <form action="{{ route(auth()->user()?->getUserType() . '.account.personal') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control @error('name') border-danger @enderror" id="name" type="text"
                            placeholder="New name.." name="name" value="{{ auth()->user()->name }}">
                        @error('name')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input class="form-control @error('phone') border-danger @enderror" id="phone" type="text"
                            placeholder="New phone.." name="phone" value="{{ auth()->user()->phone }}">
                        @error('phone')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <button class="btn btn-primary mt-3">Update Info</button>
                </form>
            @elseif (isset($_GET['password']))
                <h5>Update Password</h5>
                <form action="{{ route(auth()->user()?->getUserType() . '.account.password') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input class="form-control @error('current_password') border-danger @enderror" id="current_password"
                            type="password" placeholder="Current password.." name="current_password">
                        @error('current_password')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input class="form-control @error('password') border-danger @enderror" id="password" type="password"
                            placeholder="New password.." name="password">
                        @error('password')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">New Password Confirm</label>
                        <input class="form-control @error('password_confirmation') border-danger @enderror"
                            id="password_confirmation" type="password" placeholder="New Password Confirmation.."
                            name="password_confirmation">
                        @error('password_confirmation')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <button class="btn btn-primary mt-3">Update Password</button>
                </form>
            @else
                <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                    <p class="m-4 text-muted">Choose what to change.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
