@extends('layouts.app')

@section('title', 'Edit Module')

@section('content')
<p>
    <a href="{{route('admin.module.index')}}" class="text-primary">Module</a>
    ><a href="{{route('admin.module.show', $module)}}" class="text-primary">{{$module->name}}</a>
    ><a href="{{route('admin.module.edit', $module)}}" class="text-primary">Edit</a>
</p>
<x-forms.module :foculties="$foculties" :teachers="$teachers" :module="$module" />

@endsection