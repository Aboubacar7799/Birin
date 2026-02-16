<?php $__env->startSection('title','Profil'); ?>

<!-- La barre de navigation -->
<?php echo $__env->make('navbar/navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('navbar/mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-4">
                <h3 class="fw-bold"><?php echo e($post->user->name); ?></h3>
                <p><?php echo e($post->description); ?></p>
            </div>
            <div class="">
                <a href="<?php echo e(asset('storage/'.$image->image)); ?>">
                    <img src="<?php echo e(asset('storage'). '/' .$image->image); ?>" class="" width="400" height="400" alt="">
                </a>
            </div>
            
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\instagram\resources\views/posts/affiche_image.blade.php ENDPATH**/ ?>