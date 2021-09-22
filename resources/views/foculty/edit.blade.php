@extends('layouts.app')

@section('title', 'Edit Foculty')


@section('content')
<p>
    <a href="{{route('admin.foculty.index')}}" class="text-primary">Foculty</a>
    ><a href="{{route('admin.foculty.show', $foculty)}}" class="text-primary">{{$foculty->name}}</a>
    ><a href="{{route('admin.foculty.edit', $foculty)}}" class="text-primary">Edit</a>
</p>
<x-forms.foculty :foculty="$foculty" />

@endsection