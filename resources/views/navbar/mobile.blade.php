{{-- navbar/mobile.blade.php --}}
<nav class="d-md-none bg-white border-top">
    <div class="d-flex justify-content-around align-items-center py-2">
        <a class="navbar-brand" href="{{ route('app_post_index') }}">
            <img src="{{ asset('assets/svg/birin.png') }}" width="50"
                style="border-right:2px solid #333;padding-right:10px;">
            <span style="padding-left:2px;" class="fw-bold">{{ config('app.name') }}</span> </a>

        {{-- Home --}}
        <a href="{{ route('app_post_index') }}">
            <i class="fa-solid fa-house text-secondary"></i>
        </a>

        {{-- Amis --}}
        <a href="{{ route('app_relations_index', ['user' => auth()->user()->id]) }}">
            <i class="fa-solid fa-user-group text-secondary"></i>
        </a>

        {{-- Messages --}}
        <a href="{{ route('index') }}" class="position-relative">
            <i class="fa-solid fa-comment text-secondary"></i>
            @if ($unreadMessagesCount->sum() > 0)
                <span class="position-absolute top-5 translate-middle rounded-circle bg-info fobic"></span>
            @endif
        </a>

        {{-- Notifications --}}
        <a href="{{ route('notifications.index') }}" class="position-relative">
            <i class="fa-solid fa-bell text-secondary"></i>
            @if ($unreadNotificationsCount > 0)
                <span
                    class="position-absolute top-5 start-75 translate-middle badge rounded-circle bg-info text-dark">{{ $unreadNotificationsCount }}</span>
            @endif

        </a>

        {{-- Menu --}}
        <button data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <img
                src="{{ asset('assets/svg/menu.svg') }}"
                class="img-fluid"
                alt=""
                width="20"
                height="30"
            />
            
        </button>

    </div>
</nav>


<div class="offcanvas offcanvas-end" id="mobileMenu">
    <div class="offcanvas-header">
        <h5>Menu</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <a href="{{ route('app_profil', ['user' => auth()->user()]) }}"
            class="d-block mb-3 text-decoration-none dropdown-item">
            <i class="fa-solid fa-user"></i> Profil
        </a>

        <a href="{{ route('app_about') }}" class="d-block mb-3 text-decoration-none dropdown-item">
            <i class="fa-solid fa-circle-info"></i> <span>A propos</span>
        </a>

        <a href="{{ route('app_contact_index') }}" class="d-block mb-3 text-decoration-none dropdown-item">
            <i class="fa-solid fa-envelope"></i> Contact
        </a>

        <hr>

        <a class="d-block mb-3 text-decoration-none" href="{{ route('app_logout') }}">
            <i class="fa-solid fa-right-from-bracket"></i> Déconnexion &nbsp;
        </a>
    </div>

    <footer class="footer mt-5 py-3">
        <div class="container">
            <div class="row text-center text-md-start align-items-center">

                <div class="col-12 col-md-6 mb-2 mb-md-0">
                    BIRIN © {{ date('Y') }} | Développé par l'équipe Heluxix
                </div>

                <div class="col-12 col-md-6 text-md-end">
                    Version 1.0
                </div>

            </div>
        </div>
    </footer>
    <style>
        .footer {
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 0.9rem;
            border-top: 1px solid #eaeaea;
        }
    </style>

</div>
