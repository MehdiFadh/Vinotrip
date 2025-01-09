<?php $__env->startSection('content'); ?>
  <!-- Affichage des messages -->
    <?php if(session('success')): ?>
        <div class="custom-alert success-alert">
            <span class="custom-alert-icon">&#x2714;</span>
            <p class="custom-alert-message"><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="custom-alert error-alert">
            <span class="custom-alert-icon">&#x26A0;</span>
            <p class="custom-alert-message"><?php echo e(session('error')); ?></p>
        </div>
    <?php endif; ?>

    <?php if(session('info')): ?>
        <div class="custom-alert info-alert">
            <span class="custom-alert-icon">&#x1F4AC;</span>
            <p class="custom-alert-message"><?php echo e(session('info')); ?></p>
        </div>
    <?php endif; ?>

    <div class="panier-container">
        <h1 class="panier-title">Votre Panier</h1>
        <?php if(auth()->guard()->check()): ?>
        <a href="<?php echo e(route('commandes.historique')); ?>">Voir l'historique des commandes</a>
        <?php endif; ?>


        <?php if(!empty($panier) && count($panier) > 0 ): ?>
            <div class="panier-item">
                <form method="POST" class="message-form">
                    <?php echo csrf_field(); ?>
                    <label for="message_commande" class="message-label">Message personnalisé :</label>
                    <textarea id="message_commande" name="message_commande" class="message-textarea" placeholder="Ajoutez un message ici (facultatif)"><?php echo e(session('message_commande', '')); ?></textarea>
                </form>
            </div>
            <?php $__currentLoopData = $panier; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="panier-item">
                    <!-- Image -->
                    <img src="<?php echo e(asset('img/img_sejour/' . $item['url_photo_sejour'])); ?>" 
                         alt="<?php echo e($item['titresejour']); ?>" 
                         class="panier-item-image">

                    <!-- Détails du séjour -->
                    <div class="panier-item-details">
                        <h3><?php echo e($item['titresejour']); ?></h3>
                        <p>Prix par adulte : <?php echo e($item['prix_sejour']); ?> €</p>
                        <p>Prix par enfant : <?php echo e($item['prix_sejour']); ?> €</p>
                        <p>Adultes : <?php echo e($item['adultes']); ?></p>
                        <p>Enfants : <?php echo e($item['enfants']); ?></p>
                        <p>Chambres : <?php echo e($item['chambres']); ?></p>
                        <p class="panier-item-price">
                            <strong>Prix total pour ce séjour : <?php echo e($item['prix_total']); ?> €</strong>
                        </p>
                    </div>

                    <!-- Formulaires -->
                    <div>
                        <!-- Formulaire Modification -->
                        <form action="<?php echo e(route('panier.modifier')); ?>" method="POST" class="panier-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="sejour_id" value="<?php echo e($item['sejour_id']); ?>">
                            <label for="adultes">Adultes :</label>
                            <input type="number" name="adultes" value="<?php echo e($item['adultes']); ?>" min="0" class="panier-form-input">

                            <label for="enfants">Enfants :</label>
                            <input type="number" name="enfants" value="<?php echo e($item['enfants']); ?>" min="0" class="panier-form-input">

                            <label for="chambres">Chambres :</label>
                            <input type="number" name="chambres" value="<?php echo e($item['chambres']); ?>" min="0" class="panier-form-input">
                            
                            <?php if(isset($item['mode_cadeau']) && !$item['mode_cadeau']): ?> <!-- Si ce n'est pas un cadeau -->
                                <label for="date_sejour_<?php echo e($item['sejour_id']); ?>">Début du séjour :</label>
                                <input type="date" 
                                    id="date_sejour_<?php echo e($item['sejour_id']); ?>" 
                                    name="date_sejour" 
                                    value="<?php echo e($item['date_sejour'] ?? date('Y-m-d')); ?>"
                                    class="panier-form-input">
                            <?php endif; ?>
                            <button type="submit" class="btn-edit">Modifier</button>
                        </form>

                        <!-- Formulaire Suppression -->
                        <form action="<?php echo e(route('panier.supprimer')); ?>" method="POST" class="panier-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="sejour_id" value="<?php echo e($item['sejour_id']); ?>">
                            <button type="submit" class="btn-suppr">Supprimer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Formulaire Code Réduction -->
            <div class="panier-item">
                <form action="<?php echo e(route('panier.CodeReduction')); ?>" method="POST" class="panier-form">
                    <?php echo csrf_field(); ?>
                    <p>Code de réduction :</p>
                    <input type="text" name="codeReduction" min="0" class="panier-code-reduction">
                    <button type="submit" class="btn-suppr">Ajouter le code de réduction</button>
                </form>
            </div>

            <!-- Affichage du montant total avec réduction si applicable -->
            <?php
                $totalPanier = $total; // Total avant réduction
                $reduction = session('montant_reduction', 0);
                $totalPanierApresReduction = $totalPanier - $reduction;
            ?>

            <!-- Total du panier -->
            <p class="panier-item-price">Total du panier : <?php echo e($total); ?> €</p>

            <?php if($reduction > 0): ?>
                <p class="panier-item-price">Réduction appliquée : <?php echo e($reduction); ?> €</p>
                <?php if($totalPanierApresReduction > 0): ?>
                <p class="panier-item-price">Total après réduction : <?php echo e($totalPanierApresReduction); ?> €</p>
                <?php else: ?>
                <p class="panier-item-price">Total après réduction : 0 €</p>
                <?php endif; ?>
            <?php endif; ?>

            <div class="panier-actions">
            <?php if(auth()->guard()->guest()): ?>
                <p>Merci de vous connecter pour pouvoir continuer vos achats.</p>
                <button onclick="location.href='<?php echo e(route('login')); ?>'" class="btn-edit">Connexion</button>
            <?php endif; ?>
            <?php if(auth()->guard()->check()): ?>
                <form action="<?php echo e(route('commande.preparation')); ?>" method="POST" id="payment-form">
                    <?php echo csrf_field(); ?>
                    <!-- Champ masqué pour le message personnalisé -->
                    <input type="hidden" name="message_commande" id="hidden_message_commande" value="<?php echo e(session('message_commande', '')); ?>">
                    
                    <!-- Bouton de commander -->
                    <button type="submit" class="btn-edit">Commander</button>
                </form>
            <?php endif; ?>
    </div>
        <?php else: ?>
            <!-- Panier vide -->
            <p class="panier-empty-message">Votre panier est vide.</p>
        <?php endif; ?>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const messageTextarea = document.querySelector('#message_commande');
        const hiddenMessageInput = document.querySelector('#hidden_message_commande');

        if (messageTextarea && hiddenMessageInput) {
            // Mettre à jour le champ masqué lorsque l'utilisateur modifie le message
            messageTextarea.addEventListener('input', function () {
                hiddenMessageInput.value = messageTextarea.value;
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/panier.blade.php ENDPATH**/ ?>