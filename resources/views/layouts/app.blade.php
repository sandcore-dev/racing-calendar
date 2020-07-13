<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="@yield('image')"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light border-bottom mb-3">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    @yield('nav-title', config('app.name', 'Laravel'))
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item {{ Route::currentRouteNamed('admin.season.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.season.index') }}">@lang('Season')</a>
                            </li>
                            <li class="nav-item {{ Route::currentRouteNamed('admin.race.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.race.index') }}">@lang('Race')</a>
                            </li>
                            <li class="nav-item {{ Route::currentRouteNamed('admin.circuit.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.circuit.index') }}">@lang('Circuit')</a>
                            </li>
                            <li class="nav-item {{ Route::currentRouteNamed('admin.country.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.country.index') }}">@lang('Country')</a>
                            </li>
                            <li class="nav-item {{ Route::currentRouteNamed('admin.location.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.location.index') }}">@lang('Location')</a>
                            </li>
                            <li class="nav-item {{ Route::currentRouteNamed('admin.template.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.template.index') }}">@lang('Template')</a>
                            </li>
                        @endauth
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        @endguest

                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
</body>
</html>
