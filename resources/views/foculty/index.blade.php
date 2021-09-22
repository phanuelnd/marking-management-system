@extends('layouts.app')

@section('title', 'Foculties')

@section('content')

<p>
    @guest('student')
    <a href="{{ route(auth()->user()?->getUserType() . '.foculty.index') }}" class="text-primary">Foculties</a>
    @endguest
</p>

<div class="d-flex justify-content-between align-items-center">
    <h2 class="my-3">Foculties</h2>
    @auth('admin')
    <a href="{{route(auth()->user()?->getUserType() . '.foculty.create')}}" class="btn btn-primary">New foculty</a>
    @endauth
</div>

    <ul class="list-group list-unstyled" style="max-width: 500px;">
        @forelse ($foculties as $foculty)
            <li class="list-group-item">
                <a href="{{ route(auth()->user()?->getUserType() . '.foculty.show', $foculty) }}">{{ $foculty->name }}</a>
            </li>
        @empty
            <p>No foculties yet.
                <a href="{{ route(auth()->user()?->getUserType() . '.foculty.create') }}" class="btn btn-link">Create new</a>

            </p>
        @endforelse
    </ul>
@endsection
