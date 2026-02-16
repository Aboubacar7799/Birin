<?php $__env->startSection('title','Initialisation du Password'); ?>

<?php $__env->startSection('content'); ?>
    <h3 class="fw-bold">Salut <?php echo e($name); ?>, Initialisation du mot de passe!</h3>
    <p>
        On t'as envoyé une requête de changement du mot de passe.
        Si tu n'es pas à l'origine de cette requête, informe nous pour la securité de ton compte
        <br> Si tu es à l'origine, click sur ce lien pour l'initialisation de ton mot de passe<br>
        <a href="<?php echo e(route('app_change_password',['token' =>$activation_token])); ?>" target="_blank">Initialise ton mot de passe</a>
    </p>

    <p class="text-capitalize text-muted fw-bold text-center">BIRIN est une plate Réseau Social développé par Fodé Aboubacar Camara.</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\instagram\resources\views/mail/initial_pwd.blade.php ENDPATH**/ ?>