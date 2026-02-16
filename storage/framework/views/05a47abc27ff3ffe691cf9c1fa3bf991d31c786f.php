

<?php $__env->startSection('title','Mes Relations'); ?>

<!-- La barre de navigation -->
<?php echo $__env->make('navbar/navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('navbar/mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5" id="app">
    <ul class="nav nav-tabs" id="followTab" role="tablist">
        
        <li class="nav-item">
            <button class="nav-link <?php echo e($tab === 'discover' ? 'active' : ''); ?> " id="discover-tab" data-bs-toggle="tab" data-bs-target="#discover">
                Découvrir (<?php echo e($allUsers->count()); ?>)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link <?php echo e($tab === 'followers' ? 'active' : ''); ?>" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers">
                Abonnés (<?php echo e($user->profil->followers->count()); ?>)
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link <?php echo e($tab === 'following' ? 'active' : ''); ?>" id="following-tab" data-bs-toggle="tab" data-bs-target="#following">
                Suivis (<?php echo e($user->following->count()); ?>)
            </button>
        </li>

    </ul>

    <div class="tab-content mt-3">

        
        <div class="tab-pane fade <?php echo e($tab === 'discover' ? 'show active' : ''); ?>" id="discover">
            <h5 class="my-3">Suggestions pour vous</h5>
            <?php $__currentLoopData = $allUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registeredUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                    <a href="<?php echo e(route('app_profil',['user' =>$registeredUser->id])); ?>" class="text-decoration-none">
                        <div class="d-flex align-items-center">
                            
                            <img src="<?php echo e($registeredUser->profil ? $registeredUser->profil->getImage() : 'https://ui-avatars.com/api/?name=' . urlencode($registeredUser->name)); ?>" 
                                width="45" height="45" class="rounded-circle me-3">
                            
                            <div>
                                <span class="fw-bold d-block"><?php echo e($registeredUser->name); ?></span>
                                <small class="text-muted">Inscrit <?php echo e($registeredUser->created_at->diffForHumans()); ?></small>
                            </div>
                        </div>
                    </a>

                    
                    <?php if($registeredUser->profil): ?>
                        <followbutton
                            profil-id="<?php echo e($registeredUser->profil->id); ?>" 
                            follows="<?php echo e(auth()->user()->following->contains($registeredUser->profil->id)); ?>" />
                    <?php else: ?>
                        <span class="badge bg-light text-dark">Profil incomplet</span>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="tab-pane fade show <?php echo e($tab === 'followers' ? 'show active' : ''); ?>" id="followers">
            <?php $__currentLoopData = $user->profil->followers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $follower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="d-flex align-items-center justify-content-between mb-3 p-2 border-bottom">
                <a href="<?php echo e(route('app_profil',['user' =>$follower->id])); ?>" class="text-decoration-none">
                <div class="d-flex align-items-center">
                    <img src="<?php echo e($follower->profil->getImage()); ?>" class="rounded-circle me-3" width="50" height="50">
                    <span class="fw-bold"><?php echo e($follower->name); ?></span>
                </div>
                
                </a>
                <followbutton profil-id="<?php echo e($follower->profil->id); ?>" follows="<?php echo e(auth()->user()->following->contains($follower->profil->id)); ?>" />
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="tab-pane fade <?php echo e($tab === 'following' ? 'show active' : ''); ?>" id="following">
            <?php $__currentLoopData = $user->following; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $followedProfil): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="d-flex align-items-center justify-content-between mb-3 p-2 border-bottom">
                <a href="<?php echo e(route('app_profil',['user' =>$followedProfil->user->id])); ?>" class="text-decoration-none">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo e($followedProfil->user->profil ? $followedProfil->getImage() : 'avatars/default1.jpg'); ?>" class="rounded-circle me-3" width="50" height="50">
                        <span class="fw-bold"><?php echo e($followedProfil->user->name); ?></span>
                    </div>
                </a>
                <followbutton profil-id="<?php echo e($followedProfil->id); ?>" follows="true" />
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\instagram\resources\views/profil/relations.blade.php ENDPATH**/ ?>