@props(['teachers' => [], 'foculties' => [], 'module' => null, 'foculty' => null, 'teacher' => null])

<form class="mx-auto  {{ $attributes }}" style="max-width: 400px;"
    action="{{ route(auth()->user()?->getUserType() . '.module.' . ($module ? 'update' : 'store'),$module) }}" method="post">
    @csrf
    @if ($module)
        @method('PUT')
    @endif
    @if (session('success'))
        <div class="alert alert-success my-2">{{ session('success') }}</div>
    @endif
    @if (session('fail'))
        <div class="alert alert-danger my-2">{{ session('fail') }}</div>
    @endif
    <div class="form-group">
        <label for="name">Module name</label>
        <input value="{{ old('name') ?? $module?->name }}" name="name" type="text" id="name" placeholder="module name"
            class="form-control @error('name') border-danger @enderror">
        @error('name')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    </div>
    @if(!$foculty)
    <div class="form-group">
        <label for="foculty_id">Foculty</label>
        <select name="foculty_id" id="foculty_id"
            class="form-control @error('foculty_id') border-danger @enderror">
            <option selected>---</option>
            @foreach ($foculties as $foculty)
                <option @if ((old('foculty_id') ?? $module?->foculty_id ) == $foculty->id) selected @endif value="{{ $foculty->id }}">{{ $foculty->name }}</option>
            @endforeach
        </select>
        @error('foculty_id')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    </div>
    @else
    <input name="foculty_id" value="{{$foculty->id}}" type="hidden" />
    @endif
    <div class="form-group">
        <label for="teacher_id">Teacher</label>
        <select name="teacher_id" id="teacher_id" placeholder="teacher_id"
            class="form-control @error('teacher_id') border-danger @enderror">
            <option>---</option>
            @foreach ($teachers as $teacher)
                <option @if ((old('teacher_id') ?? $module?->teacher_id )== $teacher->id) selected @endif value="{{ $teacher->id }}">{{ $teacher->name }}</option>
            @endforeach
        </select>
        @error('teacher_id')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    </div>
    <button type="submit" class="btn mt-2 btn-block btn-lg btn-primary">
        {{$module ? 'UPDATE MODULE' : 'CREATE MODULE'}}
    </button>
</form>
