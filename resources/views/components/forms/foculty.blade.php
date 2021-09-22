@props(['foculty' => null])

<form class="mx-auto  {{ $attributes }}" style="max-width: 400px;" action="{{ 
route( auth()->user()?->getUserType().'.foculty.' . ($foculty ? 'update' : 'store'), $foculty) 
}}"
    method="post">
    @csrf
    @if($foculty) @method('PUT') @endif
    @if (session('success'))
        <div class="alert alert-success my-2">{{ session('success') }}</div>
    @endif
    @if (session('fail'))
        <div class="alert alert-danger my-2">{{ session('fail') }}</div>
    @endif
    <div class="form-group mb-2">
        <label for="name">Foculty Name</label>
        <input value="{{ old('name') ?? $foculty?->name }}" name="name" type="text" id="name" placeholder="Name"
            class="form-control @error('name') border-danger @enderror">
        @error('name')
            <small class="text-danger d-block py-1">{{ $message }}</small>
        @enderror
    </div>
    <button type="submit" class="btn mt-2 btn-block btn-lg btn-primary">{{!$foculty ? 'SUBMIT' : 'UPDATE'}}</button>
</form>
