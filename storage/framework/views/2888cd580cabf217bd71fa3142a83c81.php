<?php $__env->startSection('content'); ?>
<div class="container-commande-historique">
    <h1 class="titre-commande-historique text-center mb-4">HISTORIQUE DE VOS COMMANDES</h1>
    <p class="description-commande-historique text-center">
        Vous trouverez ici vos commandes passées depuis la création de votre compte.
    </p>

    <table class="tableau-commande-historique table table-bordered text-center">
        <thead class="en-tete-tableau-commande">
            <tr>
                <th>RÉFÉRENCE DE COMMANDE</th>
                <th>DATE</th>
                <th>PRIX TOTAL</th>
                <th>PAIEMENT</th>
                <th>ÉTAT</th>
                <th>FACTURE</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $commandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('commandes.details', $commande->numcommande)); ?>" class="lien-details-commande">
                            <?php echo e($commande->numcommande); ?>

                        </a>
                    </td>
                    <td><?php echo e(\Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y')); ?></td>
                    <td><?php echo e($commande->montant_total); ?> €</td>
                    <td>Stripe</td>
                    <td>
                        <?php if(is_null($commande->etat_commande)): ?>
                        <form action="<?php echo e(route('checkout.session')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <!-- Champ caché pour transmettre le numéro de commande -->
                            <input type="hidden" name="numcommande" value="<?php echo e($commande->numcommande); ?>">
                            <button type="submit">Procéder au paiement</button>
                        </form>
                        <?php elseif($commande->etat_commande): ?>
                            <span class="badge badge-commande-acceptee">Paiement accepté</span>
                        <?php else: ?>
                            <span class="badge badge-commande-en-attente">Commande annulée</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($commande->facture_pdf): ?>
                            <a href="<?php echo e(asset('storage/' . $commande->facture_pdf)); ?>" class="bouton-facture-pdf" target="_blank">
                                <i class="fas fa-file-pdf"></i> PDF
                            </a>
                        <?php else: ?>
                            
                            <div class="container mt-5">
                                <span class="texte-commande-sans-facture">Pas de facture</span>
                                <div class="tooltip-container">
                                    <i class="informations-supplémentaires">ℹ</i>
                                    <div class="tooltip">
                                        La facture n'est pas disponible. Merci de nous contacter pour tout renseignement.                                    
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6">Aucune commande trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/commandes/historique.blade.php ENDPATH**/ ?>