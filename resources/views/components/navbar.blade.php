<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="{{ url('/') }}">
            Sahrehub
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
            <img src="{{ asset('logo.png') }}" style="width: 100%; aspect-ratio: 1/1;" alt="">
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img style="object-fit: cover;" src="{{ asset('profile') }}/{{ Auth::user()->photo ?? 'avatar.png' }}" alt="profile" />
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    @if (Auth::check())
                        <a class="dropdown-item" href="{{ url('profil') }}?id={{ Auth::id() }}">
                            <i class="bi bi-person-circle text-primary"></i>
                            Profil
                        </a>
                        <a href="{{ url('logout') }}" class="dropdown-item">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </a>
                    @else
                        <a href="{{ url('login') }}" class="dropdown-item">
                            <i class="ti-power-off text-primary"></i>
                            Login
                        </a>
                    @endif
                </div>
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
