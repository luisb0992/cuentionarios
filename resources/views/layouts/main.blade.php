<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- meta --}}
    @include('sections.header.meta')

    {{-- titulo y subtitulo --}}
    <title>{{ config('app.name') }} | @yield('subtitle')</title>

    {{-- fonts --}}
    @include('sections.header.css')
    @yield('css')
</head>

<body>
    <header>
        <nav class="navbar navbar-dark bg-dark shadow-sm navbar-expand-md">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- Left Side Of Navbar --}}
                    <ul class="navbar-nav me-auto"></ul>

                    {{-- Right Side Of Navbar --}}
                    <ul class="navbar-nav ms-auto">

                        {{-- invitado --}}
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="fas fa-user-alt"></i>
                                        {{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                </li>
                            @endif

                            {{-- logueado --}}
                        @else

                            {{-- Fases --}}
                            <li class="nav-item dropdown">
                                <a id="phases" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ __('Fases') }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="phases">
                                    <a class="dropdown-item" href="{{ route('phases.index') }}">
                                        {{ __('Listado de fases') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('phases.create') }}">
                                        {{ __('Crear fase') }}
                                    </a>
                                </div>
                            </li>
                            {{-- /Fases --}}

                            {{-- usuario --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            {{-- /usuario --}}

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="min-height">
        @yield('content')
    </main>

    {{-- rutas de ziggy --}}
    @routes

    <footer class="text-muted py-5 bg-white">
        <div class="container">
            <p class="float-end mb-1">
                <a href="#" class="text-primary text-decoration-none">
                    <i class="fas fa-arrow-up"></i> @lang('Subir')
                </a>
            </p>
            <p class="mb-1">
                @lang('Desarrollado por <a href=":url">:name</a>', [
                'url' => 'https://project4design.com/',
                'name' => 'P4D'
                ])
            </p>
            <p class="mb-0">
                @lang(':name - &copy; Todos los derechos reservados.', [
                'name' => config('app.name')
                ])
            </p>
        </div>
    </footer>
</body>
@include('sections.body.scripts')
@yield('scripts')

</html>
