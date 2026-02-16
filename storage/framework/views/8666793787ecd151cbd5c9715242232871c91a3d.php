<?php if(Session::has('success')): ?>
    <div class="alert alert-success text-center fw-bold" role="alert">
        <?php echo e(Session::get('success')); ?>

    </div>
<?php endif; ?>

<?php if(Session::has('danger')): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?php echo e(Session::get('danger')); ?>

    </div>
<?php endif; ?>

<?php if(Session::has('email')): ?>
    <div class="alert alert-danger text-center" role="alert">
        <?php echo e(Session::get('email')); ?>

    </div>
<?php endif; ?>

<?php if(Session::has('warning')): ?>
    <div class="alert alert-warning text-center" role="alert">
        <?php echo e(Session::get('warning')); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\instagram\resources\views/alerts/alert-message.blade.php ENDPATH**/ ?>