<?php $__env->startSection('content'); ?>
<div class="container-details-commande">
    <h1 class="titre-commande-details">Détails de la commande : <?php echo e($commande->numcommande); ?></h1>
    <p class="info-commande-details">Date : <?php echo e(\Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y')); ?></p>
    <p class="info-commande-details">Total : <?php echo e($facture->montant_total); ?> €</p>

    <h3 class="sous-titre-commande-details">Détails de la commande</h3>

    <p><strong>Numéro de commande :</strong> <?php echo e($commande->numcommande); ?></p>
    <p><strong>Date de commande :</strong> <?php echo e($commande->date_commande); ?></p>
    <p><strong>Montant total de la facture :</strong> <?php echo e(isset($facture->montant_total) ? number_format($facture->montant_total, 2) : 'Non disponible'); ?> €</p>

    <div class="section-sous-details">
        <h4>Effectifs</h4>
        <table class="table-commande-details">
            <thead class="thead-commande-details">
                <tr>
                    <th>Nom</th>
                    <th>Nombre chambre</th>
                    <th>Nombre adultes</th>
                    <th>Date début</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $effectifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $effectif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($effectif->nom ?? 'Non spécifié'); ?></td>
                        <td><?php echo e($effectif->chambres ?? 0); ?></td>
                        <td><?php echo e($effectif->nb_adultes ?? 0); ?></td>
                        <td><?php echo e($effectif->date ?? 'Non spécifié'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr class="ligne-aucune-donnee">
                        <td colspan="4">Aucun effectif trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="section-sous-details">
        <h4>Cadeaux</h4>
        <table class="table-commande-details">
            <thead class="thead-commande-details">
                <tr>
                    <th>Nom</th>
                    <th>Nombre chambre</th>
                    <th>Nombre adultes</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $cadeaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cadeau): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($cadeau->nom ?? 'Non spécifié'); ?></td>
                        <td><?php echo e($cadeau->chambres ?? 0); ?></td>
                        <td><?php echo e($cadeau->nb_adultes ?? 0); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr class="ligne-aucune-donnee">
                        <td colspan="3">Aucun cadeau trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/commandes/details.blade.php ENDPATH**/ ?>