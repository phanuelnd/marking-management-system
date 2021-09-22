@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="row mt-3">
        <div class="col-6 my-auto">
            <div class="d-flex justify-content-end flex-column align-items-end">
                <h1 class="font-weight-bolder w-100">MarkIt Registration</h1>
                <small class="d-block w-100 text-left">Student marks in one place.</small>
            </div>
        </div>
        <div class="col-6 d-flex my-auto justify-content-start flex-column align-items-start">
            <div>
                <div class="card-header">
                    <h2 style="text-align: center;" class="card-title">{{ ucwords($url . ' registration') }}</h2>
                </div>
                <form class="mx-auto" style="max-width: 400px;" action="{{ route('auth.' . $url . '.register') }}"
                    method="post">
                    @csrf
                    @if (session('success'))
                        <div class="alert alert-success my-2">{{ session('success') }}</div>
                    @endif
                    @if (session('fail'))
                        <div class="alert alert-danger my-2">{{ session('fail') }}</div>
                    @endif
                    <div class="form-group">
                        <label for="name">Names</label>
                        <input value="{{ old('name') }}" name="name" type="text" id="name" placeholder="Your name"
                            class="form-control @error('name') border-danger @enderror">
                        @error('name')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="{{ old('email') }}" name="email" type="text" id="email" placeholder="email"
                            class="form-control @error('email') border-danger @enderror">
                        @error('email')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password</label>
                        <input name="password" type="password" id="pwd" placeholder="password"
                            class="form-control @error('password') border-danger @enderror">
                        @error('password')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pwd2">Re-enter Password</label>
                        <input name="password_confirmation" type="password" id="pwd2" placeholder="Re-enter your password"
                            class="form-control @error('password_confirmation') border-danger @enderror">
                        @error('password_confirmation')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    @if ($url === 'student')
                        <div class="form-group">
                            <label for="index">Index Number</label>
                            <input value="{{ old('index_number') }}" name="index_number" type="text" id="index"
                                placeholder="Your index number" class="form-control @error('name') border-danger @enderror">
                            @error('index_number')
                                <small class="text-danger d-block py-1">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="foculty_id">Foculty</label>
                            <select value="{{ old('foculty_id') }}" name="foculty_id" id="foculty_id"
                                class="form-control @error('name') border-danger @enderror">
                                <option selected>Foculty</option>
                                @foreach ($foculties as $foculty)
                                    <option value="{{ $foculty->id }}">{{ $foculty->name }}</option>
                                @endforeach
                            </select>
                            @error('foculty_id')
                                <small class="text-danger d-block py-1">{{ $message }}</small>
                            @enderror
                        </div>
                    @endif
                    <button type="submit" class="btn mt-2 btn-block btn-lg btn-primary">Register</button>
                    <a href="{{ route('auth.' . $url . '.login') }}" class="btn btn-success btn-block my-2">Login</a>
                </form>
            </div>
        </div>
    </div>
@endsection
