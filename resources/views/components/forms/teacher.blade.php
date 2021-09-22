@props(['url' => 'teacher', 'teacher' => null])

<form class="mx-auto  {{ $attributes }}" style="max-width: 400px;" @auth
        action="{{ route('admin.teacher.' . ($teacher ? 'update' : 'store'), $teacher) }}" @endauth @guest
    action="{{ route('auth.' . $url . '.register') }}" @endguest method="post">
    @csrf
    @if ($teacher)
        @method('PUT')
    @endif
    @if (session('success'))
        <div class="alert alert-success my-2">{{ session('success') }}</div>
    @endif
    @if (session('fail'))
        <div class="alert alert-danger my-2">{{ session('fail') }}</div>
    @endif
    <div class="form-group">
        <label for="name">Names</label>
        <input value="{{ old('name') ?? $teacher?->name }}" name="name" type="text" id="name" placeholder="Teacher name"
            class="form-control @error('name') border-danger @enderror">
        @error('name')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    </div>
    @if (!$teacher)
        <div class="form-group">
            <label for="email">Email</label>
            <input value="{{ old('email') ?? $teacher?->email }}" name="email" type="text" id="email"
                placeholder="email" class="form-control @error('email') border-danger @enderror">
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
    @endif
    <button type="submit" class="btn mt-2 btn-block btn-lg btn-primary">
        {{ $teacher ? 'Update Teacher' : 'Register Teacher' }}
    </button>
</form>
