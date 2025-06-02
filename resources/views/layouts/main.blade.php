<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OMDb App')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .movie-card {
            transition: transform 0.2s ease-in-out;
        }

        .movie-card:hover {
            transform: scale(1.02);
        }

        .poster-img {
            height: 400px;
            object-fit: cover;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('titles.index') }}">🎬 OMDb</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button"
                            data-bs-toggle="dropdown">
                            🌐 {{ strtoupper(app()->getLocale()) }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item"
                                    href="{{ route('lang.switch', 'en') }}">{{ __('messages.nav.english') }}</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('lang.switch', 'id') }}">{{ __('messages.nav.indonesian') }}</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('titles.*') ? 'active' : '' }}"
                            href="{{ route('titles.index') }}">{{ __('messages.nav.dashboard') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}"
                            href="{{ route('favorites.index') }}">{{ __('messages.nav.favorites') }}</a>
                    </li>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light ms-3">
                            {{ __('messages.nav.logout') }}
                        </button>
                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>
