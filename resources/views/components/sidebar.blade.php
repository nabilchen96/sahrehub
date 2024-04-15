<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">
                <i class="bi bi-house-door menu-icon mr-2 mb-1"></i>
                <span class="menu-title">Home</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/eksplor') }}">
                <i class="bi bi-compass menu-icon mr-2 mb-1"></i>
                <span class="menu-title">Eksplor</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('create-post') }}">
                <i class="bi bi-plus-square menu-icon mr-2 mb-1"></i>
                <span class="menu-title">Buat Post</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/like-activity') }}">
                <i class="bi bi-stopwatch menu-icon mr-2 mb-1"></i>
                <span class="menu-title">Aktivitas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/profil') }}?id={{ Auth::id() }}">
                <i class="bi bi-person-circle menu-icon mr-2 mb-1"></i>
                <span class="menu-title">Profil</span>
            </a>
        </li>
        {{-- <li class="nav-item px-3 d-lg-none d-xl-none">
            <hr>
            <p style="font-size: 18px;" class="mb-3 mt-4"><b>Populer 🔥</b></p>
            <p><a href="">#ngakakkocak</a></p>
            <p><a href="">#populer</a></p>
            <p><a href="">#menyalaabangku</a></p>
            <p><a href="">#meme</a></p>
            <p><a href="">#gilobabi</a></p>
        </li> --}}
    </ul>
</nav>
