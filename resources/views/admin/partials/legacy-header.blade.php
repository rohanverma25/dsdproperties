<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid">

        <!-- Left Side -->
        <div class="d-flex align-items-center">
            <button id="sidebar-toggle" type="button" aria-label="Show or hide sidebar" title="Show/hide sidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h5 class="mb-0 fw-semibold">
                @yield('page-title', 'Admin Dashboard')
            </h5>
        </div>

        <!-- Right Side -->
        <ul class="navbar-nav ms-auto align-items-center">

            <li class="nav-item me-2">
                <button id="pwa-install" type="button">
                    <i class="fa-solid fa-mobile-screen"></i> Install app
                </button>
            </li>


            <!-- Logged in User -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                   role="button" data-bs-toggle="dropdown">
                    <span class="me-2">
                        <i class="fa-solid fa-circle-user"></i>
                        {{ auth()->user()?->name ?: auth()->user()?->email }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            Profile
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>

        </ul>

    </div>
</nav>
