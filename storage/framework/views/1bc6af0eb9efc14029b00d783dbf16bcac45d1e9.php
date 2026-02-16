<nav class="navbar navbar-expand-md navbar-dark bg-secondary shadow-sm d-none d-md-flex" id="navbar" style="border-bottom:2px solid #918e8e;padding-right:10px;">
    <div class="container">

        <a class="navbar-brand" href="<?php echo e(route('app_post_index')); ?>">
            <img src="<?php echo e(asset('assets/svg/birin.png')); ?>" width="50"
                style="border-right:2px solid #333;padding-right:10px;">
            <span style="padding-left:2px;" class="fw-bold"><?php echo e(config('app.name')); ?></span> </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
            aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse pl-5" id="navbarMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php if(Request::route()->getName() == 'app_post_index'): ?> active <?php endif; ?>"
                        href="<?php echo e(route('app_post_index')); ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link <?php echo e(request()->routeIs('app_relations_index') ? 'active' : ''); ?>"
                        href="<?php echo e(route('app_relations_index', ['user' => auth()->user()->id])); ?>"> Mes amis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link <?php if(Request::route()->getName() == 'index'): ?> active <?php endif; ?>"
                        href="<?php echo e(route('index')); ?>"> Messages
                        <?php if($unreadMessagesCount->sum() > 0): ?>
                            <span
                                class="position-absolute top-5 translate-middle rounded-circle bg-info fobic"></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="nav-item ">
                    <a class="nav-link position-relative <?php if(Request::route()->getName() == 'notifications.index'): ?> active <?php endif; ?>"
                        href="<?php echo e(route('notifications.index')); ?>" href="<?php echo e(route('notifications.index')); ?>">
                        Notification <i class="fa-solid fa-bell text-warning"></i>
                        <?php if($unreadNotificationsCount > 0): ?>
                            <span
                                class="position-absolute top-5 start-75 translate-middle badge rounded-circle bg-info text-dark"><?php echo e($unreadNotificationsCount); ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-item nav-link <?php if(Request::route()->getName() == 'app_about'): ?> active <?php endif; ?>"
                        href="<?php echo e(route('app_about')); ?>">À propos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-item nav-link <?php if(Request::route()->getName() == 'app_contact_index'): ?> active <?php endif; ?>"
                        href="<?php echo e(route('app_contact_index')); ?>"> Contact</a>
                </li>

            </ul>
            <!-- La partie est visible si tu n'es pas connecter, Pour s'enregistrer si tu n'est pas connecter -->
            <?php if(auth()->guard()->guest()): ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-item nav-link" href="<?php echo e(route('login')); ?>">
                            <span class="text-white fw-bold"> Login </span>&nbsp;
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-item nav-link" href="<?php echo e(route('register')); ?>">
                            <span class="text-white fw-bold"> s'inscrire </span>&nbsp;
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
            
            <?php if(auth()->guard()->check()): ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-item nav-link fw-bold" href="<?php echo e(route('app_profil', ['user' => auth()->user()])); ?>">
                            Profile &nbsp;
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-item nav-link fw-bold" href="<?php echo e(route('app_logout')); ?>">
                            Deconnexion &nbsp;
                        </a>
                    </li>

                </ul>
            <?php endif; ?>
        </div>

    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\instagram\resources\views/navbar/navbar.blade.php ENDPATH**/ ?>