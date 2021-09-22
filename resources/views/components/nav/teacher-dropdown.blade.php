<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle btn text-pink" href="#" data-toggle="dropdown">
        <span style="font-size: .8rem;" class="text-capitalize position-relative text-small">
            <span>Explore</span>
        </span>
    </a>
    <div class="dropdown-menu" style="transform: translateX(-50%);max-width: 100vw;">
        <div class="drowpdown-wrapper d-md-flex">
            <div class="dropdown-menu-md-left">
                <h4 class="dropdown-header">Students</h4>
                <a class="dropdown-item btn btn-sm btn-outline-primary"
                    href="{{ route(auth()->user()?->getUserType() . '.student.index') }}">
                    <span style="font-size: .8rem;" class="text-capitalize text-small">All students</span>
                </a>

                <h4 class="dropdown-header">Modules</h4>
                <a class="dropdown-item btn btn-sm btn-outline-primary"
                    href="{{ route(auth()->user()?->getUserType() . '.module.index') }}">
                    <span style="font-size: .8rem;" class="text-capitalize text-small">All modules</span>
                </a>

                <div class="dropdown-divider"></div>

            </div>
            <div class="dropdown-menu-md-right">
                <h4 class="dropdown-header">Foculties</h4>
                <a class="dropdown-item btn btn-sm btn-outline-primary"
                    href="{{ route(auth()->user()?->getUserType() . '.foculty.index') }}">
                    <span style="font-size: .8rem;" class="text-capitalize text-small">All foculties</span>
                </a>

                <div class="dropdown-divider"></div>
                <h4 class="dropdown-header">Marks</h4>
                <a class="dropdown-item btn btn-sm btn-outline-primary"
                    href="{{ route(auth()->user()?->getUserType() . '.marks.index') }}">
                    <span style="font-size: .8rem;" class="text-capitalize text-small">All marks</span>
                </a>
                <a class="dropdown-item btn btn-sm btn-outline-primary"
                    href="{{ route(auth()->user()?->getUserType() . '.marks.create') }}">
                    <span style="font-size: .8rem;" class="text-capitalize text-small">New marks</span>
                </a>
            </div>
        </div>
    </div>
    </div>
</li>
<li class="nav-item"></li>
<div class="d-flex position-absolute">

</div>
