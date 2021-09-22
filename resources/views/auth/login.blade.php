@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="row mt-3">
        <div class="col-6 my-auto">
            <div class="d-flex justify-content-end flex-column align-items-end">
                <h1 class="font-weight-bolder w-100">Marking Login</h1>
                <small class="d-block w-100 text-left">Join marks online management system.</small>
            </div>
        </div>
        <div class="col-6 d-flex my-auto justify-content-start flex-column align-items-start">
            <div class="___class_+?6___">
                <div class="card-header">
                    <h2 style="text-align: center;" class="card-title">{{ ucwords($url . ' login') }}</h2>
                </div>
                <form class="mx-auto p-2" style="width: 300px;" action="{{ route('auth.' . $url . '.login') }}"
                    method="post">
                    @csrf
                    @if (session('success'))
                        <div class="alert alert-success my-2">{{ session('success') }}</div>
                    @endif
                    @if (session('fail'))
                        <div class="alert alert-danger my-2">{{ session('fail') }}</div>
                    @endif
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input value="{{ old('email') }}" name="email" type="text" id="email" placeholder="Enter email"
                            class="form-control py-2 @error('email') border-danger @enderror">
                        @error('email')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password</label>
                        <input name="password" type="password" id="pwd" placeholder="Enter password"
                            class="form-control py-2 @error('password') border-danger @enderror">
                        @error('password')
                            <small class="text-danger d-block py-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-check mt-1">
                        <label for="rmb" class="form-chek-label">
                            <input type="checkbox" name="remember_me" id="rmb" class="form-check-input">
                            <span>Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="btn mt-2 btn-block btn-lg btn-primary">Login</button>
                    @if ($url !== 'admin')
                        <a href="{{ route('auth.' . $url . '.register') }}"
                            class="btn btn-success btn-block my-2">Register</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

@endsection
