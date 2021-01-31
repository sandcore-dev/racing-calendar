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
                            <li class="nav-item {{ Route::currentRouteNamed('admin.championship.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('admin.championship.index') }}">@lang('Championship')</a>
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
                        <?php $otherChampionships = \App\Models\Championship::others()->get(); ?>
                            @if($otherChampionships->count())
                                <li class="dropdown-divider d-md-none"></li>
                            @endif
                        @foreach($otherChampionships as $otherChampionship)
                            <li class="nav-item d-md-none">
                                <a class="nav-link" href="{{ route('index', ['championship' => $otherChampionship]) }}" target="_blank">
                                    {{ $otherChampionship->name }}
                                </a>
                            </li>
                        @endforeach
                            <li class="dropdown-divider d-md-none"></li>
                            <li class="nav-item d-md-none">
                                @guest
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                @else
                                    <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                             document.getElementById('logout-form2').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                @endguest
                            </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown d-none d-md-inline">
                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                @guest
                                    @lang('Racing series')
                                @else
                                    {{ Auth::user()->name }}
                                @endguest
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @foreach(\App\Models\Championship::others()->get() as $otherChampionship)
                                    <a class="dropdown-item" href="{{ route('index', ['championship' => $otherChampionship]) }}" target="_blank">
                                        {{ $otherChampionship->name }}
                                    </a>
                                @endforeach
                                <div class="dropdown-divider"></div>
                                @guest
                                    <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form2').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                @endguest
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>
</body>
</html>
