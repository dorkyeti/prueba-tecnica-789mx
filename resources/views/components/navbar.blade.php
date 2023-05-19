<nav class="navbar navbar-expand sticky-top navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('favicon.ico') }}" />
        {{ config('app.name') }}
    </a>

    @auth
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                @can('ver todos')
                    <li class="nav-item {{ routeIsActive('home') }}">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                @endcan

                @can('ver usuarios')
                    <li class="nav-item {{ routeIsActive('users') }}">
                        <a class="nav-link" href="{{ route('users') }}">Usuarios</a>
                    </li>
                @endcan

            </ul>
            <span class="navbar-text">
                <i class="fa fa-user"></i> {{ auth()->user()->name }}
            </span>
            <a class="nav-link" href="{{ route('logout') }}">Cerrar sesión</a>
        </div>
    @endauth
</nav>
