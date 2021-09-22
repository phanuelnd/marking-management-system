@props(['url' => 'student', 'foculties' => [], 'student' => null, 'foculty' => null])

<form class="mx-auto  {{ $attributes }}" style="max-width: 400px;" @auth
    action="{{ !$student ? route('admin.student.store') : route('admin.student.update', $student) }}" @endauth
    @guest action="{{ route('auth.' . $url . '.register') }}" @endguest method="post">
    @csrf
    @if ($student) @method('PUT') @endif
    @if (session('success'))
        <div class="alert alert-success my-2">{{ session('success') }}</div>
    @endif
    @if (session('fail'))
        <div class="alert alert-danger my-2">{{ session('fail') }}</div>
    @endif
    <div class="form-group">
        <label for="name">Names</label>
        <input value="{{ old('name') ?? $student?->name }}" name="name" type="text" id="name" placeholder="Name"
            class="form-control @error('name') border-danger @enderror">
        @error('name')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    </div>
    @if (!$student)
        <div class="form-group">
            <label for="email">Email</label>
            <input value="{{ old('email') ?? $student?->email }}" name="email" type="text" id="email"
                placeholder="Email" class="form-control @error('email') border-danger @enderror">
            @error('email')
                <small class="text-danger d-block py-1">{{ $message }}</small>
            @enderror
        </div>
    @endif
    <div class="form-group">
        <label for="phone">Phone</label>
        <input value="{{ old('phone') ?? (string) $student?->phone }}" name="phone" type="text" id="phone"
            placeholder="Phone" class="form-control @error('phone') border-danger @enderror">
        @error('phone')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    </div>
    @if (!$student)

        <div class="form-group">
            <label for="pwd">Password</label>
            <input name="password" type="password" id="pwd" placeholder="Password"
                class="form-control @error('password') border-danger @enderror">
            @error('password')
                <small class="text-danger d-block py-1">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="pwd2">Re-enter Password</label>
            <input name="password_confirmation" type="password" id="pwd2" placeholder="Re-enter password"
                class="form-control @error('password_confirmation') border-danger @enderror">
            @error('password_confirmation')
                <small class="text-danger d-block py-1">{{ $message }}</small>
            @enderror
        </div>
    @endif
    <div class="form-group">
        <label for="index">Index Number</label>
        <input value="{{ old('index_number') ?? $student?->index_number }}" name="index_number" type="text"
            id="index" placeholder="Index number" class="form-control @error('name') border-danger @enderror">
        @error('index_number')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    </div>
        @if(!$foculty)
    <div class="form-group">
        <label for="foculty_id">Foculty</label>
        <select name="foculty_id" id="foculty_id" class="form-control @error('name') border-danger @enderror">
            <option selected>Foculty</option>
            @foreach ($foculties as $foculty)
                <option @if ($foculty->id == (old('foculty_id') ?? $student?->foculty_id)) selected @endif value="{{ $foculty->id }}">{{ $foculty->name }}</option>
            @endforeach
        </select>
        @error('foculty_id')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    </div>
    @else
    <input name="foculty_id" type="hidden" value="{{$foculty->id}}" />
    @endif
    <button type="submit"
        class="btn mt-2 btn-block btn-lg btn-primary">{{ !$student ? 'Register' : 'Edit Student' }}</button>
</form>
