@extends('./layouts/app')


@section('title', 'Welcome')

@section('content')
    @parent

    <h1 style="font-size: 2.5rem" class="font-weight-bolder big text-uppercase my-3">
        <span class="">Secure, </span>
        <span class="text-primary font-weight-bolder">reliable, </span>
        <span class="text-warning font-weight-bolder">accessible, </span>
        <span class="text-danger font-weight-bolder">manageable </span>
        <span class=""> & </span>
        <span class="text-success font-weight-bolder">Fast.</span>
    </h1>
    <p class="text-muted p-2">Modern way to manage your marks.</p>
    <div class="row my-3">
        <div class="col-md-6">
            
        </div>
        <div class="col-md-6">
            <h1 class="display-1 font-weight-bolder"></h1>
        </div>
    </div>
@endsection

