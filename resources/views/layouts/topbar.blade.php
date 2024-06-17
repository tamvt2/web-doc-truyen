@if(Request::is('admin*'))
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
@else
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow p-lr">
@endif
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    @if(!Request::is('admin*'))
        <div class="hover-box">
            <i class="fa fa-list" aria-hidden="true"></i>
            <span>Thể loại</span>
            <div class="box">
                @if (isset($genres) && !empty($genres))
                    @foreach($genres as $genre)
                        <a class="coll" href="/the-loai/{{ $genre->slug }}">{{ $genre->name }}</a>
                    @endforeach
                @endif
            </div>
        </div>
        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" method="GET" action="/tim-kiem">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." name="search"
                    aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    @endif

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            @if( auth()->check() )
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span id="profile" data-id="{{ auth()->id() }}" class="mr-2 d-none d-lg-inline text-gray-600 small">
                        {{ auth()->user()->name }}
                    </span>
                    <img class="img-profile rounded-circle"
                    src="/img/undraw_profile.svg">
                </a>
            @else
                <div class="mx-5">
                    <a href="{{ url('login') }}">Login</a> |
                    <a href="{{ url('register') }}">Register</a>
                </div>
            @endif
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <form method="POST" id="logout-form" action="{{ url('logout') }}">
                    @csrf
                </form>
                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>

</nav>
