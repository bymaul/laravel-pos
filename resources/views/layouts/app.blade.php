<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/DataTables/css/datatables.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-all.min.css') }}">
</head>

@stack('css')

<body id="page-top">
    <div id="wrapper">

        @include('layouts.navigation')

        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3"
                            id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                        aria-expanded="false" data-bs-toggle="dropdown" href="#"><span
                                            class="d-none d-lg-inline me-2 text-gray-600 small">{{ Auth::user()->name }}</span><img
                                            class="border rounded-circle img-profile"
                                            src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('assets/img/default.jpg') }}"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user fa-sm fa-fw me-3 text-gray-400"></i>Profil</a>
                                        <hr class="dropdown-divider">
                                        <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                            @csrf
                                            <a class="dropdown-item" href="#" onclick="$('#logoutForm').submit()">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-3 text-gray-400"></i>
                                                Logout
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <main>
                    {{ $slot }}
                </main>
            </div>
            <footer class="bg-white sticky-footer mt-3">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Lepas Rindu {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
        </div>
    </div>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/DataTables/js/datatables.min.js') }}"></script>

    @stack('scripts')

</body>

</html>
