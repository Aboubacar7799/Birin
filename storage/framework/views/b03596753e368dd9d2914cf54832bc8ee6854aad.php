<?php $__env->startSection('title','Activer Compte par le lien'); ?>

<?php $__env->startSection('content'); ?>
    <h3 class="fw-bold">Salut <?php echo e($name); ?>, confirmation de l'adresse email!</h3>
    <p>
        Voici le code de confirmation pour activer ton compte sur la plate forme BIRIN.
        <br> <h5 class="fw-bold">Activation code: <?php echo e($activation_code); ?></h5>.<br>
        Ou tu suis ce lien pour l'activer votre compte sur BIRIN: <br>
        <a href="<?php echo e(route('app_activation_code_lien',['token' =>$activation_token])); ?>" target="_blank">Confirme votre compte</a>
    </p>

    <p class="text-capitalize text-muted fw-bold text-center"> BIRIN est une plate Réseau Social développé par Fodé Aboubacar Camara.</p>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\instagram\resources\views/mail/confirmation_email.blade.php ENDPATH**/ ?>