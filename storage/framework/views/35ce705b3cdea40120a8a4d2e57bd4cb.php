<link rel="stylesheet" href="<?php echo e(asset('css/affichage.css')); ?>">


<?php $__env->startSection('content'); ?>
<div class="container">
<?php if(session('success')): ?>
        <div class="alert-alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <h1 class="text-center mb-4">HISTORIQUE DES COMMANDES</h1>
    <p class="text-center">Vous trouverez ici toutes les commandes passées par les clients.</p>

    <table class="table table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>RÉFÉRENCE DE COMMANDE</th>
                <th>DATE</th>
                <th>PAIEMENT</th>
                <th>ÉTAT</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $commandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('commandes.details', $commande->numcommande)); ?>">
                            <?php echo e($commande->numcommande); ?>

                        </a>
                    </td>
                    <td><?php echo e(\Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y')); ?></td>
                 
                    
                    <td>Stripe</td> <!--A modifier une fois qu'on aura plusieurs moyens de paiement-->
                    <td>
                        <span class="badge <?php echo e($commande->etat_commande ? 'badge-success' : 'badge-danger'); ?>">
                        <?php if($commande->etat_commande == true): ?>
                            Accepté
                        <?php else: ?> 
                            Attente
                        <?php endif; ?>
                        </span>
                    </td>

                    <?php if($commande->etat_commande == false): ?>
                    <td>
                        <form action="<?php echo e(route('commandesEffectif.envoyerMailDisponibilite', $commande->numcommande)); ?>" method="GET">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">Mail vérification disponibilité hotel</button>
                        </form>
                    </td>
                    
                    <td>
                        <form action="<?php echo e(route('commandesEffectif.envoyerReglementsejour', $commande->numcommande)); ?>" method="GET">
                        <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">Mail règlement séjour</button>
                        </form>
                    </td>

                    <td>
                        
                            <form action="<?php echo e(route('commandesEffectif.choisirAutreHotel', $commande->numcommande)); ?>" method="GET">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary">Choisir un autre hôtel</button>
                            </form>
                        
                    </td>

                    <td>
                        <form action="<?php echo e(route('commandeEffectif.RembourserClient', $commande->numcommande)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">Rembouser client</button>
                        </form>
                    </td>

                    <?php endif; ?>

                    <?php if($commande->etat_commande == true): ?>
                    <td>
                        <form action="<?php echo e(route('commandesEffectif.envoyerCarnetRoute', $commande->numcommande)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">Envoyé carnet de route</button>
                        </form>
                    </td>

                    <td>
                        <form action="<?php echo e(route('commandesEffectif.envoyerValidationPartenaire', $commande->numcommande)); ?>" method="GET">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">Mail validation partenaire</button>
                        </form>
                    </td>
                    <?php endif; ?>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/commandesEffectif/affichage.blade.php ENDPATH**/ ?>