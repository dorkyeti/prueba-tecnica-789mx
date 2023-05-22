<nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center"
    data-nav="brand-center">
    <div class="navbar-header d-xl-block d-none">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <span class="brand-logo">
                        <img src="{{ asset('favicon.ico') }}" />
                    </span>
                    <h2 class="brand-text mb-0">{{ config('app.name') }}</h2>
                </a>
            </li>
        </ul>
    </div>
    <div class="navbar-container d-flex content">
        {{-- Menu Derecho --}}
        <ul class="nav navbar-nav align-items-center ml-auto">
            {{-- User --}}
            <li class="nav-item dropdown dropdown-user">
                {{-- User display --}}
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{-- Nombre del usuario y rol --}}
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">
                            {{ auth()->user()?->name }}
                        </span>
                        <span class="user-status">
                            {{ auth()->user()?->roles->first()->name }}
                        </span>
                    </div>
                    {{-- Fin nombre de usuario y rol --}}
                    {{-- Avatar del usuario --}}
                    <span class="avatar">
                        <img class="round"
                            src="{{ 'https://source.boringavatars.com/marble/120/' . auth()->user()?->name . '?colors=264653,2a9d8f,e9c46a,f4a261,e76f51' }}"
                            alt="avatar" height="40" width="40">
                        <span class="avatar-status-online"></span>
                    </span>
                    {{-- Fin del avatar del usuario --}}
                </a>
                {{-- Fin User display --}}

                {{-- Opciones del usuario --}}
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="mr-50" data-feather="power"></i>
                        Cerrar sesión
                    </a>
                </div>
                {{-- Fin de opciones del usuario --}}
            </li>
            {{-- Fin User --}}
        </ul>
        {{-- Fin menu derecho --}}
    </div>
</nav>
