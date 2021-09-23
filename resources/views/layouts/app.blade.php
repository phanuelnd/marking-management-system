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
        <a href="/" class="navbar-brand logo mx-2">UR-Marking</a>
        <ul class="navbar-nav">
            @auth
                <li class="nav-item"><a href="{{ route(auth()->user()?->getUserType() . '.dashboard') }}" class="nav-link">Dashboard</a></li>
                @endauth
                @auth('student')
                <li class="nav-item"><a href="{{ route(auth()->user()?->getUserType() . '.marks.index') }}" class="nav-link">My marks</a></li>
                {{-- <li class="nav-item"><a href="{{ route(auth()->user()?->getUserType() . '.marks.index') }}" class="nav-link align-self-center font-weight-bold mt-2 btn-sm py-1">See Marks</a></li> --}}
            @endauth
        </ul>
        <ul class="navbar-nav @auth
            
        @endauth">
            @auth('admin')
                {{-- <x-nav.admin-dropdown /> --}}
            @endauth
            @auth('teacher')
                {{-- <x-nav.teacher-dropdown /> --}}
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
                            <a href="{{ route(auth()->user()?->getUserType() . '.account') }}" class="text-decoration-none btn btn-block btn-outline-primary">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M13 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM3.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                  </svg> Account</a>
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
                <a href="{{ url()->previous() }}" class="text-uppercase float-right btn-outline-dark btn-sm">Back</a>
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
                        <li class="nav-item"><a href="#" class="nav-link"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-list-nested" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.5 11.5A.5.5 0 0 1 5 11h10a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm-2-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm-2-4A.5.5 0 0 1 1 3h10a.5.5 0 0 1 0 1H1a.5.5 0 0 1-.5-.5z"/>
                          </svg> Programs</a></li>
                        <li class="nav-item"><a href="#" class="nav-link"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-phone" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M11 1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                            <path fill-rule="evenodd" d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                          </svg> E-learning</a></li>
                        <li class="nav-item"><a href="#" class="nav-link"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-book" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3.214 1.072C4.813.752 6.916.71 8.354 2.146A.5.5 0 0 1 8.5 2.5v11a.5.5 0 0 1-.854.354c-.843-.844-2.115-1.059-3.47-.92-1.344.14-2.66.617-3.452 1.013A.5.5 0 0 1 0 13.5v-11a.5.5 0 0 1 .276-.447L.5 2.5l-.224-.447.002-.001.004-.002.013-.006a5.017 5.017 0 0 1 .22-.103 12.958 12.958 0 0 1 2.7-.869zM1 2.82v9.908c.846-.343 1.944-.672 3.074-.788 1.143-.118 2.387-.023 3.426.56V2.718c-1.063-.929-2.631-.956-4.09-.664A11.958 11.958 0 0 0 1 2.82z"/>
                            <path fill-rule="evenodd" d="M12.786 1.072C11.188.752 9.084.71 7.646 2.146A.5.5 0 0 0 7.5 2.5v11a.5.5 0 0 0 .854.354c.843-.844 2.115-1.059 3.47-.92 1.344.14 2.66.617 3.452 1.013A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.276-.447L15.5 2.5l.224-.447-.002-.001-.004-.002-.013-.006-.047-.023a12.582 12.582 0 0 0-.799-.34 12.96 12.96 0 0 0-2.073-.609zM15 2.82v9.908c-.846-.343-1.944-.672-3.074-.788-1.143-.118-2.387-.023-3.426.56V2.718c1.063-.929 2.631-.956 4.09-.664A11.956 11.956 0 0 1 15 2.82z"/>
                          </svg> Library</a></li>
                        <li class="nav-item"><a href="#" class="nav-link"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-post" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 1h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H4z"/>
                            <path d="M4 5.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-7z"/>
                            <path fill-rule="evenodd" d="M4 3.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                          </svg> Blog</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-4">
                    <h4>Contact</h4>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="#" class="nav-link"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-telephone" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3.925 1.745a.636.636 0 0 0-.951-.059l-.97.97c-.453.453-.62 1.095-.421 1.658A16.47 16.47 0 0 0 5.49 10.51a16.471 16.471 0 0 0 6.196 3.907c.563.198 1.205.032 1.658-.421l.97-.97a.636.636 0 0 0-.06-.951l-2.162-1.682a.636.636 0 0 0-.544-.115l-2.052.513a1.636 1.636 0 0 1-1.554-.43L5.64 8.058a1.636 1.636 0 0 1-.43-1.554l.513-2.052a.636.636 0 0 0-.115-.544L3.925 1.745zM2.267.98a1.636 1.636 0 0 1 2.448.153l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z"/>
                          </svg>+2507865768</a></li>
                        <li class="nav-item"><a href="#" class="nav-link"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-inbox-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3.81 4.063A1.5 1.5 0 0 1 4.98 3.5h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1-.78.624l-3.7-4.624a.5.5 0 0 0-.39-.188H4.98a.5.5 0 0 0-.39.188L.89 9.312a.5.5 0 1 1-.78-.624l3.7-4.625z"/>
                            <path fill-rule="evenodd" d="M.125 8.67A.5.5 0 0 1 .5 8.5h5A.5.5 0 0 1 6 9c0 .828.625 2 2 2s2-1.172 2-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .496.562l-.39 3.124a1.5 1.5 0 0 1-1.489 1.314H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393z"/>
                          </svg>admin@ur.rw</a></a></li>
                        <li class="nav-item"><a href="#" class="nav-link"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-map" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M15.817.613A.5.5 0 0 1 16 1v13a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 14.51l-4.902.98A.5.5 0 0 1 0 15V2a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0l4.902.98 4.902-.98a.5.5 0 0 1 .415.103zM10 2.41l-4-.8v11.98l4 .8V2.41zm1 11.98l4-.8V1.61l-4 .8v11.98zm-6-.8V1.61l-4 .8v11.98l4-.8z"/>
                          </svg>Huye, Rwanda</a></a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-4">
                    <h4>Social media</h4>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <div>
                                <a href="#" class="nav-link">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 12.796L11.481 8 6 3.204v9.592zm.659.753l5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
                                      </svg>
                                    Facebook
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div>
                                <a href="#" class="nav-link">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 12.796L11.481 8 6 3.204v9.592zm.659.753l5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
                                      </svg>
                                    Instagram
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div>
                                <a href="#" class="nav-lin">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 12.796L11.481 8 6 3.204v9.592zm.659.753l5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
                                      </svg>
                                    Twitter
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <div>
                                <a href="#" class="nav-link">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-caret-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 12.796L11.481 8 6 3.204v9.592zm.659.753l5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
                                      </svg>
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
