<?php $__env->startSection('content'); ?>
<div class="container-inscription">
    <h2>Connexion</h2>

    <!-- Affichage des messages de succès ou d'erreur -->
    <?php if(session('error')): ?>
        <div class="alert-inscription">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login.submit')); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-group-inscription">
            <label for="mailclient">Adresse e-mail</label>
            <input type="email" name="mailclient" id="mailclient" class="form-control" value="<?php echo e(old('mailclient')); ?>" required>
            <?php $__errorArgs = ['mailclient'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group-inscription">
            <label for="mot_de_passe_client">Mot de passe</label>
            <input type="password" name="mot_de_passe_client" id="mot_de_passe_client" class="form-control" required>
            <?php $__errorArgs = ['mot_de_passe_client'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <button type="submit" class="btn-inscription">Se connecter</button>
    </form>

    <div class="link-connexion">
        <p>Pas encore inscrit ? <a href="<?php echo e(route('inscription.index')); ?>">Créez un compte.</a></p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/auth/login.blade.php ENDPATH**/ ?>