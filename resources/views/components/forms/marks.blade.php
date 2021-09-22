@props(['student' => null, 'marks' => null, 'students' => [], 'modules' => [], 'module' => null])

<form class="mx-auto " style="max-width: 400px;"
    action="{{ route(auth()->user()?->getUserType() . '.marks.' . ($marks ? 'update' : 'store'), $marks) }}"
    method="post">
    @csrf
    @if ($marks) @method('PUT') @endif
    @if (session('success'))
        <div class="alert alert-success my-2">{{ session('success') }}</div>
    @endif
    @if (session('fail'))
        <div class="alert alert-danger my-2">{{ session('fail') }}</div>
    @endif
    @if ($student)
        <div class="form-group">
            <input value="{{ (string) $student->id }}" name="student_id" type="hidden"
                class="form-control @error('student_id') border-danger @enderror">
            @error('student_id')
                <small class="text-danger d-block py-1">{{ $message }}</small>
            @enderror
        </div>
    @elseif ($marks)
        <input type="hidden" class="form-control" value="{{ $marks->student->id }}" name="student_id" />
    @endif
    @if ($marks)
        <input type="hidden" value="{{ $marks->module->id }}" name="module_id" />
    @elseif ($module)
        <input type="hidden" value="{{ $module->id }}" name="module_id" />
    @else
        <label for="module_id">Module</label>
        <select name="module_id" id="module_id" class="form-control @error('module_id') border-danger @enderror">
            <option selected>---</option>
            @foreach ($modules as $module)
                <option @if ((old('module_id')) == $module->id) selected @endif value="{{ $module->id }}">{{ $module->name }}</option>
            @endforeach
        </select>
        @error('module_id')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    @endif
    <div class="form-group">
        <label for="marks">Marks</label>
        <input value="{{ old('marks') ?? $marks?->marks }}" name="marks" type="number" id="marks"
            placeholder="Your marks" class="form-control @error('marks') border-danger @enderror">
        @error('marks')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group">
        <label for="semester">Semester</label>
        <select name="semester" id="semester" class="form-control @error('semester') border-danger @enderror">
            <option>---</option>
            <option value="I" @if ((old('semester') ?? $marks?->semester) === 'I') selected @endif>I (ONE)</option>
            <option value="II" @if ((old('semester') ?? $marks?->semester) === 'II') selected @endif>II (TWO)</option>
            <option value="III" @if ((old('semester') ?? $marks?->semester) === 'III') selected @endif>III (THREE)</option>
        </select>
        @error('semester')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    </div>
    <button type="submit" class="btn mt-2 btn-block btn-lg btn-primary">
        {{ $marks ? 'Update Marks' : 'Record Marks' }}</button>
</form>
