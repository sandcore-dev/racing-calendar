<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        @yield('nav-title', config('app.name', 'Laravel'))
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                        @auth
                        <li class="{{ Route::currentRouteNamed('admin.season.*') ? 'active' : '' }}">
							<a href="{{ route('admin.season.index') }}">@lang('Season')</a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('admin.race.*') ? 'active' : '' }}">
							<a href="{{ route('admin.race.index') }}">@lang('Race')</a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('admin.circuit.*') ? 'active' : '' }}">
							<a href="{{ route('admin.circuit.index') }}">@lang('Circuit')</a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('admin.country.*') ? 'active' : '' }}">
							<a href="{{ route('admin.country.index') }}">@lang('Country')</a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('admin.location.*') ? 'active' : '' }}">
							<a href="{{ route('admin.location.index') }}">@lang('Location')</a>
                        </li>
                        <li class="{{ Route::currentRouteNamed('admin.template.*') ? 'active' : '' }}">
							<a href="{{ route('admin.template.index') }}">@lang('Template')</a>
                        </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
