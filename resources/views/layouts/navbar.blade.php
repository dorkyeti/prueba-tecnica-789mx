<div class="horizontal-menu-wrapper">
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-dark navbar-shadow menu-border"
        role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
        <div class="navbar-container main-menu-content" data-menu="menu-container">
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                {{-- <li class="nav-item {{ routeIsActive('home') }}">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i data-feather="home"></i>
                        <span>
                            Inicio
                        </span>
                    </a>
                </li> --}}
                @can('ver todos')
                    <li class="nav-item {{ routeIsActive('todos') }}">
                        <a class="nav-link" href="{{ route('todos') }}">
                            <i data-feather="check-square"></i>
                            <span>
                                ToDos
                            </span>
                        </a>
                    </li>
                @endcan
                @can('ver usuarios')
                    <li class="nav-item {{ routeIsActive('users') }}">
                        <a class="nav-link" href="{{ route('users') }}">
                            <i data-feather="user"></i>
                            <span>
                                Usuarios
                            </span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
