<?php $__env->startSection('content'); ?>

<div class="sejour-detail-container">
    <h1><?php echo e($sejour->titresejour); ?></h1>
    <img src="<?php echo e(asset('img/img_sejour/'.$sejour->url_photo_sejour)); ?>" alt="<?php echo e($sejour->titresejour); ?>">
    <p class="descr"><strong>Description :</strong> <?php echo e($sejour->descriptionsejour); ?></p>

    <div class="etapes-container">
        <?php if(isset($etapes) && $etapes->count() > 0): ?>
            <h3>Étapes de ce séjour :</h3>
            <ul>
                <?php $__currentLoopData = $etapes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $etape): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="etape-item">

                        <!-- Titre et description de l'étape -->
                        <strong class="etape-title"><?php echo e($etape->titre_etape . $etape->description_etape); ?></strong>
                        <div class="etape-image-container">
                            <img class="img-etape" src="<?php echo e(asset('img/img_sejour/img_etape/' . $etape->url_photo_etape)); ?>" alt="Image de l'étape">
                        </div>

                        <!-- Vérification des partenaires associés -->
                        <?php if($etape->elementEtapes->count() > 0): ?>
                            <ul class="partenaire-list">
                            <?php $__currentLoopData = $etape->elementEtapes->sortBy(fn($element) => $element->idelement_etape ?? ''); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($element->partenaire): ?>
                                    <li class="partenaire-item">
                                        <div class="partenaire-info">
                                            <!--<strong class="partenaire-name"><?php echo e($element->partenaire->nom_partenaire); ?></strong>-->
                                            <p class="partenaire-description"><?php echo e($element->description); ?></p>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
        <p class="no-details">Pas plus de détails</p>
        <?php endif; ?>

                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <p>Aucune étape trouvée pour ce séjour.</p>
        <?php endif; ?>
    </div>

    <div class="hotels-container">
        <?php if($hotels && $hotels->count() > 0): ?>
            <h3>Hébergements disponibles :</h3>
            <ul>
                <?php $__currentLoopData = $hotels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hotel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <strong><?php echo e($hotel->nom_partenaire); ?></strong><br>
                        <img class="img-etape" src="<?php echo e(asset('img/img_partenaire/' . $hotel->img_partenaire)); ?>">

                        <button onclick="location.href='<?php echo e(route('hotel.details', [$hotel->id_partenaire])); ?>'">
                            Voir les détails
                        </button>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <p>Aucun hébergement disponible pour ce séjour.</p>
        <?php endif; ?>
    </div>

    <div class="hotels-container">
        <?php if($caves && $caves->count() > 0): ?>
            <h3>Domaines disponibles :</h3>
            <ul>
                <?php $__currentLoopData = $caves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <strong><?php echo e($cave->nom_partenaire); ?></strong><br>
                        <img class="img-etape" src="<?php echo e(asset('img/img_partenaire/' . $cave->img_partenaire)); ?>">

                        <button onclick="location.href='<?php echo e(route('cave.details', [$cave->id_partenaire])); ?>'">
                            Voir les détails
                        </button>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php else: ?>
            <p>Aucun domaine disponible pour ce séjour.</p>
        <?php endif; ?>
    </div>

    <form action="<?php echo e(route('panier.ajouter.cadeau')); ?>" method="POST" id="panier-form">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="sejour_id" value="<?php echo e($sejour->refsejour); ?>">
        <input type="hidden" name="mode_cadeau" id="mode_cadeau" value="0">

        <br><label for="adultes">Nombre d'adultes :</label>
        <input type="number" name="adultes" id="adultes" min="1" value="1">

        <br><label for="enfants">Nombre d'enfants :</label>
        <input type="number" name="enfants" id="enfants" min="0" value="0">

        <br><label for="chambres">Nombre de chambres :</label>
        <input type="number" name="chambres" id="chambres" min="1" value="1">

        <div class="container mt-5">
            <div class="tooltip-container">
                <i class="informations-supplémentaires">ℹ</i>
                <div class="tooltip">
                    Le nombre de personnes pour le séjour est limité à 10 (adultes + enfants). Merci de nous contacter pour des séjours avec plus de 10 personnes.
                </div>
            </div>
        </div>

        <button type="button" onclick="activerModeCadeau()">OFFRIR</button>
    </form>

    <script>
         function activerModeCadeau() {
            // Met la valeur du mode cadeau
            document.getElementById('mode_cadeau').value = 1;
            document.getElementById('panier-form').submit(); // Soumettre le formulaire
        }
    </script>

    <a id='reserver' href="<?php echo e(route('sejour.effectif.details', $sejour->refsejour)); ?>">
       RESERVER
    </a>
   

    <!-- Affichage des avis des clients -->
    <h2>Avis des clients :</h2>

    <?php if($sejour->avis->isEmpty()): ?>
        <p>Aucun avis pour ce séjour pour le moment.</p>
    <?php else: ?>
        <div class="avis-container" id="avis-container"> <!-- Nouvelle div pour les avis -->
            <?php $__currentLoopData = $sejour->avis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="avis">
                    <p><strong>Note : <?php echo e($avis['noteavis']); ?> / 5</strong></p>
                    <p><?php echo e($avis->commentaire); ?></p>
                    <p><em>Posté par : <?php echo e($avis->client->nomclient); ?> <?php echo e(substr($avis->client->prenomclient, 0, 1)); ?>. le <?php echo e($avis->dateavis->format('d/m/Y')); ?></em></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/sejour/show.blade.php ENDPATH**/ ?>