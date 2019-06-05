<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-5 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        @guest
            <li class="nav-item">
                <a class="nav-link text-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link text-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                        @if (Auth::user()->hasRole('Department Admin'))
                            {{ Auth::user()->departmentName }} -
                        @elseif (Auth::user()->hasRole('College Admin'))
                            {{ Auth::user()->collegeName }} -
                        @elseif (Auth::user()->hasRole('University Admin'))
                            {{ Auth::user()->institution()->institutionName }} -
                        @endif
                        {{ Auth::user()->name }}</span>
                    {{--                    <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">--}}
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        {{ __('Logout') }}
                    </a>
                </div>

            </li>
    @endguest
    <!-- Nav Item - User Information -->


    </ul>

</nav>
<!-- End of Topbar -->
