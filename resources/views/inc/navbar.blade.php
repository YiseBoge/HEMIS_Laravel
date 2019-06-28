<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-5 static-top shadow">

    @guest
        <a class="btn btn-primary btn-circle text-white shadow-sm" href="/" data-toggle="tooltip" title="Home">
            <i class="fa fa-home"></i>
        </a>
@else
    <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>
        <span class="small">
            Current :
            <span class="mx-2 text-left text-primary">
                {{ Auth::user()->currentInstance }}
            </span>
        </span>
@endguest


<!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        @guest
            <li class="nav-item btn btn-primary btn-circle shadow-sm">
                <a class="nav-link text-white" href="{{ route('login') }}" data-toggle="tooltip" title="Login"><i
                            class="fas fa-sign-in-alt mx-3"></i>
                    {{--                    {{ __('Login') }}--}}
                </a>
            </li>
            {{--            @if (Route::has('register'))--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a class="nav-link text-primary" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
            {{--                </li>--}}
            {{--            @endif--}}
        @else
            <li class="nav-item">
                <a class="nav-link">
                    <span class="mr-2 d-none d-lg-inline text-primary small">
                        @if (Auth::user()->hasRole('Department Admin'))
                            {{ Auth::user()->institution()->institutionName }} <i
                                    class="fas fa-chevron-right mx-2 text-gray-400"></i> {{ Auth::user()->collegeName }}
                            <i class="fas fa-chevron-right mx-2 text-gray-400"></i> {{ Auth::user()->departmentName }}
                            <i class="fas fa-angle-double-right mx-2 text-gray-400"></i>
                        @elseif (Auth::user()->hasAnyRole(['College Admin', 'College Super Admin']))
                            {{ Auth::user()->institution()->institutionName }} <i
                                    class="fas fa-chevron-right mx-2 text-gray-400"></i> {{ Auth::user()->collegeName }}
                            <i class="fas fa-angle-double-right mx-2 text-gray-400"></i>
                        @elseif (Auth::user()->hasRole('University Admin'))
                            {{ Auth::user()->institution()->institutionName }} <i
                                    class="fas fa-angle-double-right mx-2 text-gray-400"></i>
                        @endif
                        {{ Auth::user()->name }}
                    </span>
                </a>
            </li>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                    {{--                    <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">--}}
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user-circle fa-fw mr-2 text-primary"></i>
                        Profile
                    </a>
                    <hr class="dropdown-divider"/>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-fw mr-2 text-primary"></i>
                        {{ __('Logout') }}
                    </a>
                </div>

            </li>
    @endguest
    <!-- Nav Item - User Information -->


    </ul>

</nav>
<!-- End of Topbar -->
