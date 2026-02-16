<?php $__env->startSection('title', 'Profile'); ?>

<link rel="stylesheet" href="<?php echo e(asset('assets/javaUser/profil.css')); ?>">

<?php echo $__env->make('navbar/navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('navbar/mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('layout/model_suppresion', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <div class="container mt-4">
        
        <div class="row align-items-center">

            
           <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                <div class="profile-avatar mx-auto
                    <?php echo e($user->isOnline() ? 'online' : 'offline'); ?>">
                    <img src="<?php echo e($user->profil->getImage()); ?>" alt="Photo de profil" class="profile-img">
                </div>
            </div>


            
            <div class="col-12 col-md-8" id="app">

                
                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2">

                    <h4 class="fw-bolder mb-0 nameUser"><?php echo e($user->name); ?></h4>

                        <?php if($user->id === auth()->id()): ?>
                            <div class="dropdown mb-3 ms-auto">
                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                    <img src="<?php echo e(asset('assets/svg/menu_3P.png')); ?>" class="img-fluid" alt="" width="30" height="30"/>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo e(route('app_account_delete_page')); ?>" class="dropdown-item">
                                            Supprimer mon compte
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; ?>

                    <div class="d-flex gap-2">
                        <?php if($user->id !== auth()->id()): ?>
                        <a href="<?php echo e(route('app_conversations_show', $user->id)); ?>" class="btn btn-secondary btn-sm">
                          <i class="fa-solid fa-comment"></i> <span>Message</span>  
                        </a>
                            
                        <?php endif; ?>

                        <followbutton profil-id="<?php echo e($user->profil->id); ?>" follows="<?php echo e($follows); ?>"
                            auth-profil-id="<?php echo e(auth()->user()->profil->id); ?>" />
                    </div>

                </div>

                
                <div class="d-flex justify-content-start gap-4 mt-3 flex-wrap">

                    <div>
                        <a href="#publication" class="text-decoration-none">
                            <span class="fw-bold"><?php echo e($postCount); ?></span> publications
                        </a>
                    </div>

                    <div>
                        <a href="<?php echo e(route('app_relations_index', [
                            'user' => $user->id,
                            'tab' => 'followers',
                        ])); ?>"
                            class="text-decoration-none">
                            <span class="fw-bold"><?php echo e($followsCount); ?></span> abonnés
                        </a>
                    </div>

                    <div>
                        <a href="<?php echo e(route('app_relations_index', [
                            'user' => $user->id,
                            'tab' => 'following',
                        ])); ?>"
                            class="text-decoration-none">
                            <span class="fw-bold"><?php echo e($followingCount); ?></span> suivis
                        </a>
                    </div>

                </div>

                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $user->profil)): ?>
                    <div class="mt-3">
                        <a href="<?php echo e(route('app_profil_edit', ['user' => $user->id])); ?>"
                            class="btn btn-outline-secondary btn-sm">
                            Modifier mon profil
                        </a>
                    </div>
                <?php endif; ?>

                
                <div class="mt-3">
                    <div class="fw-bolder">Biographie</div>
                    <div><?php echo e($user->profil->description); ?></div>

                    <?php if($user->profil->lien): ?>
                        <a href="<?php echo e($user->profil->lien); ?>" target="_blank">
                            <?php echo e($user->profil->lien); ?>

                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $user->profil)): ?>
                        <div class="mt-2">
                            <a class="btn btn-outline-primary btn-sm" href="<?php echo e(route('app_post_create')); ?>">
                                Créer une publication
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <hr class="my-4">

        
        <?php if(Session::has('success')): ?>
            <div class="alert alert-success text-center fw-bold" role="alert">
                <?php echo e(Session::get('success')); ?>

            </div>
        <?php endif; ?>
        <div class="container mt-4" id="publication">
        <?php $__empty_1 = true; $__currentLoopData = $user->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="row justify-content-center mb-4">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm rounded-3" id="post-<?php echo e($post->id); ?>">
                        
                        <div class="card-body pb-2">
                            <div class="d-flex align-items-center">
                                <a href="<?php echo e(route('app_profil', ['user' => $post->user])); ?>"
                                    class="d-flex align-items-center text-decoration-none text-dark">
                                    <img src="<?php echo e($post->user->profil->getImage()); ?>" class="rounded-circle me-2"
                                        width="45" height="45">
                                    <div>
                                        <strong><?php echo e($post->user->name); ?></strong><br>
                                        <small class="text-muted">
                                            <?php echo e($post->created_at->diffForHumans()); ?>

                                        </small>
                                    </div>
                                </a>
                                 <?php if($post->user_id === auth()->id()): ?>
                                    <div class="dropdown mb-3 ms-auto">
                                        <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                            <img
                                                src="<?php echo e(asset('assets/svg/menu_3P.png')); ?>"
                                                class="img-fluid"
                                                alt=""
                                                width="30"
                                                height="30"
                                            />
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $post)): ?>
                                                    <a href="#" 
                                                    class="dropdown-item delete-post-btn"
                                                    data-id="<?php echo e($post->id); ?>">
                                                    Supprimer
                                                    </a>
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <p class="mt-3 mb-2">
                                <?php echo e($post->description); ?>

                            </p>
                        </div>
                        <?php
                            $count = $post->images->count();
                            $class = match ($count) {
                            1 => 'images-1',
                            2 => 'images-2',
                            3 => 'images-3',
                            4 => 'images-4',
                            default => 'images-multiple'
                            }
                         ?>
                        <div class="postImages <?php echo e($class); ?>">
                            <?php $__currentLoopData = $post->images->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="image-wrapper position-relative">
                                <a href="<?php echo e(route('app_affiche_image', ['post' => $post->id,'image' => $image->id])); ?>" class="">
                                    <img src="<?php echo e(asset('storage/' . $image->image)); ?>" class="img-fluid w-100 h-100">
                                </a>
                                <?php if($count > 4 && $key === 3): ?>
                                    <div class="overlay">
                                        +<?php echo e($count - 4); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="px-3 py-2 text-muted small d-flex justify-content-between">
                            <div id="counts-<?php echo e($post->id); ?>">
                                <div>
                                    <?php echo e($post->likes->count()); ?> likes
                                </div>
                                👍 <?php echo e($post->likes->where('type', 'like')->count()); ?>

                                ❤️ <?php echo e($post->likes->where('type', 'love')->count()); ?>

                                😢 <?php echo e($post->likes->where('type', 'sad')->count()); ?>

                                😡 <?php echo e($post->likes->where('type', 'angry')->count()); ?>

                                😮 <?php echo e($post->likes->where('type', 'wow')->count()); ?>

                            </div>
                            <div>
                                <?php echo e($post->comments->count()); ?> commentaires
                            </div>
                        </div>
                        <div class="d-flex justify-content-between px-3 py-2 border-top">
                            
                            <div class="reaction-wrapper" data-post="<?php echo e($post->id); ?>">
                                <?php
                                    $reaction = $post->userLike()?-> type;
                                ?>
                                <button type="button" class="btn btn-light btn-sm" id="btn-<?php echo e($post->id); ?>">
                                    <?php switch($reaction):
                                        case ('love'): ?> ❤️ J'adore <?php break; ?>
                                        <?php case ('sad'): ?> 😢 Triste <?php break; ?>
                                        <?php case ('angry'): ?> 😡 Furieux <?php break; ?>
                                        <?php case ('wow'): ?> 😮 Wouah <?php break; ?>
                                        <?php default: ?> 👍 J’aime
                                    <?php endswitch; ?>
                                </button>
                                <div class="reaction-options">
                                    <?php $__currentLoopData = ['like' => '👍', 'love' => '❤️', 'sad' => '😢', 'angry' => '😡', 'wow' => '😮']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $emoji): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span onclick="sendReaction('<?php echo e($type); ?>', <?php echo e($post->id); ?>)">
                                            <?php echo e($emoji); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            
                            <a href="<?php echo e(route('posts.comments', $post->id)); ?>" class="btn btn-light btn-sm"
                                data-post-id="<?php echo e($post->id); ?>">
                                💬 Commenter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center text-muted p-3">
                Bienvenue parmi nous sur la plateforme <strong class="text-danger">BIRIN</strong> <br>
                Pour accéder aux publications des utilisateurs, vous devez les suivre. <br>
                Explorez les profils dans onglet <strong class="text-info">"Mes amis"</strong> puis <strong class="text-info">"Découvrir"</strong>, cliquez sur <strong class="text-info">S'abonner</strong> pour voir leurs contenus dans votre fil d'actualité.
            </div>
        <?php endif; ?>
    </div>
    </div>
    <script>
        window.REACTION_URL = "<?php echo e(route('reaction.ajax')); ?>"
    </script>
    <script src="<?php echo e(asset('assets/javaUser/post.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\instagram\resources\views/profil/profil.blade.php ENDPATH**/ ?>