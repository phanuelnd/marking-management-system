<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/btp5/css/bootstrap.min.css">
    <script src="/btp5/js/bootstrap.js" defer></script>
    @section('assets')
    @show
    <title>@yield('title') | Markit</title>
</head>

<body>
    <nav class="navbar sticky-top bg-light px-md-5 flex-sm-column flex-md-row navbar-light navbar-expand-sm justify-content-between">
        <a href="/" class="navbar-brand logo font-weight-bolder mx-2">Markit</a>
        <ul class="navbar-nav">
            @auth
                <li class="nav-item"><a href="{{ route(auth()->user()?->getUserType() . '.dashboard') }}" class="nav-link">Dashboard</a></li>
            @endauth
        </ul>
        <ul class="navbar-nav @auth
            
        @endauth">
            @auth('admin')
                <x-nav.admin-dropdown />
            @endauth
            @auth('teacher')
                <x-nav.teacher-dropdown />
            @endauth
            @guest('teacher')
                @guest('student')
                    @guest
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                Login As
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('auth.student.login') }}">Student</a>
                                <a class="dropdown-item" href="{{ route('auth.teacher.login') }}">Teacher</a>
                                <a class="dropdown-item" href="{{ route('auth.admin.login') }}">Admin</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                Register As
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('auth.student.register') }}">Student</a>
                                <a class="dropdown-item" href="{{ route('auth.teacher.register') }}">Teacher</a>
                            </div>
                        </li>
                    @endguest
                @endguest
            @endguest
            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{ auth()->user()->name }}</a>
                    <div  style="max-width: fit-content;" class="dropdown-menu">
                        <div class="dropdwon-item d-flex mb-1 px-3">
                            <a href="#" class="text-decoration-none btn btn-block btn-outline-primary">
                                <img src="/icons/person.svg" alt=""> Account</a>
                        </div>
                        <div class="dropdwon-item px-3">
                            <form class="p-0 d-block" action="{{ route(auth()->user()?->getUserType() . '.logout') }}"
                                method="post">
                                @csrf
                                <button class="nav-link btn btn-warning  btn-block btn-sm text-dark" type="submit">Logout</button>
                            </form>
                        </div>
                    </div>
                </li>
            @endauth
        </ul>
    </nav>
    <main>
        @if (url()->full() !== url()->previous())
        @endif
        <div class="container">
            @auth
                
            <p class="m-2">
                <a href="{{ url()->previous() }}" class="text-uppercase float-right btn-dark btn-sm">Back</a>
            </p>
                @endauth
            @section('content')
            @show
        </div>

    </main>
    <footer>
        <nav class="navbar navbar-dark px-md-5 bg-dark text-light footer-nav">
            <div class="row container align-items-start">
                <div class="col-sm-6 col-md-4">
                    <h4>Services</h4>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="#" class="nav-link"> <img src="/icons/list-nested.svg"
                                    alt="" class="svg mr-1"> Programs</a></li>
                        <li class="nav-item"><a href="#" class="nav-link"> <img src="/icons/phone.svg"
                                    alt="" class="svg mr-1"> E-learning</a></li>
                        <li class="nav-item"><a href="#" class="nav-link"> <img src="/icons/book.svg" alt=""
                                    class="svg mr-1"> Library</a></li>
                        <li class="nav-item"><a href="#" class="nav-link"> <img src="/icons/file-post.svg"
                                    alt="" class="svg mr-1"> Blog</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-4">
                    <h4>Contact</h4>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="#" class="nav-link"><img src="/icons/telephone.svg"
                                    alt="" class="svg mr-1">+2507865768</a></li>
                        <li class="nav-item"><a href="#" class="nav-link"><img src="/icons/inbox-fill.svg"
                                    alt="" class="svg mr-1">admin@ur.rw</a></a></li>
                        <li class="nav-item"><a href="#" class="nav-link"><img src="/icons/map.svg" alt=""
                                    class="svg mr-1">Huye, Rwanda</a></a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-4">
                    <h4>Social media</h4>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <div>
                                <a href="#" class="nav-link">
                                    <img src="/icons/caret-right.svg" alt="" class="d-inlin-block svg mr-1">
                                    Facebook
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div>
                                <a href="#" class="nav-link">
                                    <img src="/icons/caret-right.svg" alt="" class="d-inlin-block svg mr-1">
                                    Instagram
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div>
                                <a href="#" class="nav-lin">
                                    <img src="/icons/caret-right.svg" alt="" class="d-inlin-block svg mr-1">
                                    Twitter
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div>
                                <a href="#" class="nav-link">
                                    <img src="/icons/caret-right.svg" alt="" class="d-inlin-block svg mr-1">
                                    LinkedIn
                                </a>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
        <p class="bg-dark w-100 m-0 text-muted font-weight-bold font-monospace text-center pb-2">&copy; University of
            Rwanda (UR) 1962-2021</p>
    </footer>

</body>

</html>
