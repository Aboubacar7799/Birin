<nav class="navbar navbar-expand-md navbar-dark bg-secondary shadow-sm d-none d-md-flex" id="navbar" style="border-bottom:2px solid #918e8e;padding-right:10px;">
    <div class="container">

        <a class="navbar-brand" href="{{ route('app_post_index') }}">
            <img src="{{ asset('assets/svg/birin.png') }}" width="50"
                style="border-right:2px solid #333;padding-right:10px;">
            <span style="padding-left:2px;" class="fw-bold">{{ config('app.name') }}</span> </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
            aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse pl-5" id="navbarMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link @if (Request::route()->getName() == 'app_post_index') active @endif"
                        href="{{ route('app_post_index') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link {{ request()->routeIs('app_relations_index') ? 'active' : '' }}"
                        href="{{ route('app_relations_index', ['user' => auth()->user()->id]) }}"> Mes amis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link @if (Request::route()->getName() == 'index') active @endif"
                        href="{{ route('index') }}"> Messages
                        @if ($unreadMessagesCount->sum() > 0)
                            <span
                                class="position-absolute top-5 translate-middle rounded-circle bg-info fobic"></span>
                        @endif
                    </a>
                </li>

                <li class="nav-item ">
                    <a class="nav-link position-relative @if (Request::route()->getName() == 'notifications.index') active @endif"
                        href="{{ route('notifications.index') }}" href="{{ route('notifications.index') }}">
                        Notification <i class="fa-solid fa-bell text-warning"></i>
                        @if ($unreadNotificationsCount > 0)
                            <span
                                class="position-absolute top-5 start-75 translate-middle badge rounded-circle bg-info text-dark">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-item nav-link @if (Request::route()->getName() == 'app_about') active @endif"
                        href="{{ route('app_about') }}">À propos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-item nav-link @if (Request::route()->getName() == 'app_contact_index') active @endif"
                        href="{{ route('app_contact_index') }}"> Contact</a>
                </li>

            </ul>
            <!-- La partie est visible si tu n'es pas connecter, Pour s'enregistrer si tu n'est pas connecter -->
            @guest
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-item nav-link" href="{{ route('login') }}">
                            <span class="text-white fw-bold"> Login </span>&nbsp;
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item nav-link" href="{{ route('register') }}">
                            <span class="text-white fw-bold"> s'inscrire </span>&nbsp;
                        </a>
                    </li>
                </ul>
            @endguest
            {{-- et là si tu est connecté --}}
            @auth
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-item nav-link fw-bold" href="{{ route('app_profil', ['user' => auth()->user()]) }}">
                            Profile &nbsp;
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-item nav-link fw-bold" href="{{ route('app_logout') }}">
                            Deconnexion &nbsp;
                        </a>
                    </li>

                </ul>
            @endauth
        </div>

    </div>
</nav>
