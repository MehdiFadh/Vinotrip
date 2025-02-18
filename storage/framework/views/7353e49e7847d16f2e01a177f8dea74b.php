<?php $__env->startSection('content'); ?>

<script>
    function normalizeText(text) {
        
        return text
            .normalize("NFD") 
            .replace(/[\u0300-\u036f]/g, "") 
            .toLowerCase(); 
    }

    function filterSejours() {
    var searchQuery = normalizeText(document.getElementById('searchBar').value); 
    var destinationFilter = normalizeText(document.getElementById('destinationSelect').value); // Destination filtrée
    var participantFilter = normalizeText(document.getElementById('participantSelect').value); // Catégorie de participant filtrée
    var categorieFilter = normalizeText(document.getElementById('categorieSejourSelect').value); // Catégorie de séjour filtrée

    var sejours = document.querySelectorAll('.sejour-case'); // Toutes les cases de séjour
    var hasVisibleSejour = false; 

    sejours.forEach(function (sejour) {
        // Récupération des champs pour chaque séjour
        var titreSejour = normalizeText(sejour.querySelector('.titreSejour').textContent);
        var destinationSejour = normalizeText(sejour.querySelector('.destination-sejour').textContent);
        var participants = normalizeText(sejour.querySelector('.categorie-participant').textContent);

        // Vérification de correspondance avec les catégories
        var matchesCategorie = categorieFilter === 'all' || 
            sejour.classList.contains('categorie-' + categorieFilter.replace(/\s+/g, '-'));

        // Recherche approximative
        var matchesSearch =
            titreSejour.includes(searchQuery) || 
            destinationSejour.includes(searchQuery) || 
            participants.includes(searchQuery);

        var matchesDestination = destinationFilter === 'all' || destinationSejour.includes(destinationFilter);
        var matchesParticipants = participantFilter === 'all' || participants.includes(participantFilter);

        // Si le séjour correspond, on l'affiche
        if (matchesSearch && matchesDestination && matchesParticipants && matchesCategorie) {
            sejour.style.display = 'block'; 
            hasVisibleSejour = true; 
        } else {
            sejour.style.display = 'none'; 
        }
    });

    // Affiche le message si aucun séjour n'est visible
    var noResultsMessage = document.getElementById('noResultsMessage');
    if (hasVisibleSejour) {
        noResultsMessage.style.display = 'none'; // Cacher le message
    } else {
        noResultsMessage.style.display = 'block'; // Afficher le message
    }
}

</script>

    <div class="filters-container-sejour">
        <div class="container mt-5">
            <div class="tooltip-container">
                <i class="informations-supplémentaires">ℹ</i>
                <div class="tooltip">
                    Merci de valider votre recherche avec le bouton "Rechercher" à droite 
                </div>
            </div>
        </div>
        <form action="#" method="GET">
            <div class="search-bar-container">
                <label for="searchBar"></label>
                <input type="text" id="searchBar" placeholder="Entrez un critère de recherche">
                <!-- Bouton de recherche -->
                
            </div>
        </form>

        <!-- Autres filtres -->
        <select class="btnDestination-sejour" id="destinationSelect" onchange="filterSejours()">
            <option value="all" <?php echo e(isset($selectedDestination) && $selectedDestination == 'all' ? 'selected' : ''); ?>>Toutes les destinations</option>
            <?php $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $destination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($destination->nom_destination_sejour); ?>" 
                    <?php echo e(isset($selectedDestination) && $selectedDestination == $destination->nom_destination_sejour ? 'selected' : ''); ?>>
                    <?php echo e($destination->nom_destination_sejour); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>


        <select class="btnParticipant-sejour" id="participantSelect" onchange="filterSejours()">
            <option value="all">Pour qui ?</option>
            <?php $__currentLoopData = $categorie_participant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($categorie->type_participant); ?>"><?php echo e($categorie->type_participant); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select class="btnCategorie-sejour" id="categorieSejourSelect" onchange="filterSejours()">
            <option value="all">Toutes les catégories</option>
            <?php $__currentLoopData = $categorie_sejour; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($categorie->type_sejour); ?>"><?php echo e($categorie->type_sejour); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button type="button" class="btnRechercher-sejour" id="searchButton" onclick="filterSejours()">Rechercher</button>
    </div>

    <div class="sejour-container-sejour">
        <ul class="sejour-liste-sejour">
            <?php $__currentLoopData = $sejours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sejour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="sejour-case 
                <?php echo e($sejour->destination_sejour['nom_destination_sejour']); ?> 
                <?php $__currentLoopData = $sejour->categorieParticipants ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorieParticipant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($categorieParticipant->type_participant); ?> 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                <?php $__currentLoopData = $sejour->categorieSejours ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorieSejour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    categorie-<?php echo e(strtolower(str_replace(' ', '-', $categorieSejour->type_sejour))); ?> <!-- Remplace les espaces par des tirets et met tout en minuscules -->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">

                <img src="<?php echo e(asset('img/img_sejour/'.$sejour['url_photo_sejour'])); ?>" alt="">
                <h2 class="titreSejour"><?php echo e($sejour['titresejour']); ?></h2>
                <ul class="descriptionSejour">
                    <li class="destination-sejour"><?php echo e($sejour->destination_sejour['nom_destination_sejour']); ?></li>
                    <li class="description-sejour"><?php echo e($sejour['descriptionsejour']); ?></li>
                    <li class="categorie-participant">
                        <strong>Participants :</strong>
                        <?php $__currentLoopData = $sejour->categorieParticipants ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorieParticipant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($categorieParticipant->type_participant); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </li>
                    <li class="categorie-sejour">
                        <strong>Catégories de séjour :</strong>
                        <?php $__currentLoopData = $sejour->categorieSejours ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorieSejour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($categorieSejour->type_sejour); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </li>
                    <li class="prix-sejour">À partir de <?php echo e($sejour['prix_sejour']); ?> €</li>
                    <div class="container mt-5">
                        <div class="tooltip-container">
                            <i class="informations-supplémentaires">ℹ</i>
                            <div class="tooltip">
                                Le prix varie selon le nombre de personnes pour le séjour
                            </div>
                        </div>
                    </div>
                    <li class="avis-sejour">                    
                        <?php if($sejour['moyenne_avis'] == 0): ?>                                
                        <p>Il n'y a pas encore d'avis.</p>
                        <?php else: ?>
                            <div class="etoiles">
                                <?php
                                    $moyenne_avis = $sejour['moyenne_avis'];
                                    $etoiles_pleines = floor($moyenne_avis);
                                    $etoiles_vides = 5 - $etoiles_pleines;
                                ?>
                                <?php for($i = 0; $i < $etoiles_pleines; $i++): ?>
                                    <span class="star filled">★</span>
                                <?php endfor; ?>
                                <?php for($i = 0; $i < $etoiles_vides; $i++): ?>
                                    <span class="star empty">☆</span>
                                <?php endfor; ?>
                            </div>
                            
                            <p>Moyenne des avis : <?php echo e($moyenne_avis); ?> / 5
                            <button class="lien-avis" 
                                    onclick="location.href='<?php echo e(route('sejour.showByRefSejour', ['refsejour' => $sejour->refsejour])); ?>#avis-container'">
                                Lire les avis
                            </button>
                            </p>
                        <?php endif; ?>
                    </li>
                    <li class="nombre-etapes">
                        
                        <?php echo e($sejour->etapes_count); ?> 
                        <strong>jour<?php echo e($sejour->etapes_count > 1 ? 's' : ''); ?></strong>
                        
                        
                        <?php
                            $nbnuits = max(0, $sejour->etapes_count - 1);
                        ?>

                        
                        | <?php echo e($nbnuits); ?> 
                        <strong>nuit<?php echo e($nbnuits > 1 ? 's' : ''); ?></strong>
                    </li>
                </ul>
                <button class="buttonDecouvrirSejour" 
                        onclick="location.href='<?php echo e(route('sejour.showByRefSejour', ['refsejour' => $sejour->refsejour])); ?>'">
                    Découvrir l'offre
                </button>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <div id="noResultsMessage" style="display: none; text-align: center; color: red; font-weight: bold;">
            Aucun séjour ne correspond à votre recherche.
        </div>

    </div>

    <!-- <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger intent="WELCOME" chat-title="Vinotrip" agent-id="7b4ad48a-de71-45d7-b54f-bb72f83c4104" language-code="fr"></df-messenger> -->

    <script>
       
        document.addEventListener("DOMContentLoaded", function () {
            
            const destinationSelect = document.getElementById('destinationSelect');
            const selectedValue = destinationSelect.value;

            
            if (selectedValue !== 'all') {
                filterSejours();
            }
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/sejours.blade.php ENDPATH**/ ?>