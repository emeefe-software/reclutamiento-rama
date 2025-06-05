<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <?php 
                        $user=Auth::user();
                    ?>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ $user->fullname() }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                Salir
                            </a>

                            @if($user->hasRole('admin'))
                                <a class="dropdown-item" href="{{ route('users.index') }}">
                                    Usuarios
                                </a>
                                <a class="dropdown-item" href="{{ route('candidates') }}">
                                    Aspirantes
                                </a>
                                <a class="dropdown-item" href="{{ route('foods.index') }}">
                                    Comidas
                                </a>
                                <a class="dropdown-item" href="{{ route('universities.index') }}">
                                    Universidades
                                </a>
                                <a class="dropdown-item" href="{{ route('careers.index') }}">
                                    Carreras
                                </a>
                                <a class="dropdown-item" href="{{ route('programs.index') }}">
                                    Programas
                                </a>
                                <a class="dropdown-item" href="{{ route('hours.index') }}">
                                    Horarios
                                </a>
                                <a class="dropdown-item" href="{{ route('interviews.index') }}">
                                    Entrevistas
                                </a>
                                <a class="dropdown-item" href="{{ route('settings') }}">
                                    Configuración
                                </a>
                            @elseif($user->hasRole('responsable'))
                                <a class="dropdown-item" href="{{ route('candidates') }}">
                                    Aspirantes
                                </a>
                                <a class="dropdown-item" href="{{ route('universities.index') }}">
                                    Universidades
                                </a>
                                <a class="dropdown-item" href="{{ route('careers.index') }}">
                                    Carreras
                                </a>
                                <a class="dropdown-item" href="{{ route('programs.index') }}">
                                    Programas
                                </a>
                                <a class="dropdown-item" href="{{ route('hours.index') }}">
                                    Horarios
                                </a>
                                <a class="dropdown-item" href="{{ route('interviews.index') }}">
                                    Entrevistas
                                </a>
                            @elseif($user->hasRole('practicing'))
                                <a class="dropdown-item" href="{{ route('user.hours') }}">
                                    Mis horas
                                </a>
                                <a class="dropdown-item" href="{{ route('foods.confirm') }}">
                                    Comida
                                </a>
                            @endif

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>