<link rel="stylesheet" href="<?php echo e(asset('css/choisirHotel.css')); ?>">

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="text-center mb-4">Choisir un autre hôtel</h1>
    <p class="text-center">Choisissez un hôtel disponible pour la commande n° <?php echo e($commandeEffectif->numcommande); ?>.</p>

    <form action="<?php echo e(route('commandesEffectif.envoyerAvisClient', $commandeEffectif->numcommande)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="hotel">Choisir un hôtel :</label>
            <select name="hotel" id="hotel" class="form-control" required>
                <?php $__currentLoopData = $hotelsDisponibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option ><?php echo e($hotel->nom_partenaire); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer la demande d'avis au client</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/commandesEffectif/choisirHotel.blade.php ENDPATH**/ ?>