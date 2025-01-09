<?php $__env->startSection('content'); ?>
<div class="container-account">
    <h2>Mon Compte</h2>

    <!-- Affichage des messages de succès -->
    <?php if(session('success')): ?>
        <div class="alert-account">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="details-account">
        <!-- Formulaire pour mettre à jour les informations utilisateur -->
        <form action="<?php echo e(route('account.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?> <!-- Utiliser PUT pour une mise à jour -->

            <div class="form-group-account">
                <label for="nomclient">Nom</label>
                <input type="text" id="nomclient" name="nomclient" class="form-control" value="<?php echo e(old('nomclient', $user->nomclient)); ?>" required>
                <?php $__errorArgs = ['nomclient'];
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

            <div class="form-group-account">
                <label for="prenomclient">Prénom</label>
                <input type="text" id="prenomclient" name="prenomclient" class="form-control" value="<?php echo e(old('prenomclient', $user->prenomclient)); ?>" required>
                <?php $__errorArgs = ['prenomclient'];
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

            <div class="form-group-account">
                <label for="mailclient">Email</label>
                <input type="email" id="mailclient" name="mailclient" class="form-control" value="<?php echo e(old('mailclient', $user->mailclient)); ?>" required>
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

            <div class="form-group-account">
                <label for="datenaissance">Date de naissance</label>
                <input type="date" id="datenaissance" name="datenaissance" class="form-control" value="<?php echo e(old('datenaissance', $user->datenaissance ? \Carbon\Carbon::parse($user->datenaissance)->format('Y-m-d') : '')); ?>" required>
                <?php $__errorArgs = ['datenaissance'];
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

            <div class="form-group-account">
                <label for="telclient">Téléphone</label>
                <input type="text" id="telclient" name="telclient" class="form-control" value="<?php echo e(old('telclient', $user->telclient)); ?>" required>
                <?php $__errorArgs = ['telclient'];
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

            <button type="submit" class="btn-account">Sauvegarder les modifications</button>
        </form>
    </div>

    <div class="account-orders">
        <h3 class="account-orders-title">Mes Bons cadeaux
        </h3>

        <!-- Commandes Cadeaux -->
        <div class="orders-section">
            <?php if($commandesCadeaux->isEmpty()): ?>
                <p class="orders-section-empty">Aucune commande cadeau trouvée.</p>
            <?php else: ?>
                <ul class="orders-section-list">
                    <?php $__currentLoopData = $commandesCadeaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="orders-section-item">
                            <strong class="orders-section-item-title">Commande #<?php echo e($commande->numcommande); ?></strong>

                            <?php if(isset($commande->date_commande)): ?>
                                <span class="orders-section-item-date">- <?php echo e(\Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y')); ?></span>
                            <?php else: ?>
                                <span class="orders-section-item-date">- Date non spécifiée</span>
                            <?php endif; ?>
                            <p class="orders-section-item-gift-code">Code cadeau : <?php echo e($commande->code_cadeau); ?></p>
                            <div class="container mt-5">
                                <div class="tooltip-container">
                                    <i class="informations-supplémentaires">ℹ</i>
                                    <div class="tooltip">
                                    Voici le bon cadeau que vous devez garder secret et remettre à son bénéficiaire.
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/account/show.blade.php ENDPATH**/ ?>