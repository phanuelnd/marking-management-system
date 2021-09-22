@extends('layouts.app')

@section('title', 'Add foculty')


@section('content')
<p>
    <a href="{{ route('admin.foculty.index') }}" class="text-primary">Foculties</a>
    ><a href="{{ route('admin.foculty.create') }}" class="text-primary">Create</a>
</p>
<h1 class="text-center m-2">Add foculty</h1>
<x-forms.foculty />

@endsection