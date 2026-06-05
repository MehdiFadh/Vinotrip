<?php $__env->startSection('content'); ?>

<?php echo Whitecube\LaravelCookieConsent\Facades\Cookies::renderView(); ?>

    
    <?php if(session('success')): ?>
        <div class="alert-paiement-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php elseif(session('error')): ?>
        <div class="alert-paiement-erreur">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>


    <video autoplay loop muted>
        <source src="<?php echo e(asset('video/home_video.mp4')); ?>" type="video/mp4">
        Votre navigateur ne supporte pas la lecture de vidéos.
    </video>
    <div class="some-sejours">
        
    <button class="sejBut" onclick="location.href='/sejours';">Tous nos séjours</button>
    </div>
    <div class="welcome-avis">
        <h1>Avis des voyageurs </h1>

        <ul class="liste-avis">
            <?php $__currentLoopData = $avis->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <h2 class="titreAvis"><?php echo e($avie->sejour->titresejour); ?> <span class="noteAvis"><?php echo e($avie['noteavis']); ?>/5</span>
                    <button class="butAvis" onclick="location.href='<?php echo e(route('sejour.showByTitre', ['titresejour' => $avie->sejour->titresejour])); ?>'">Voir le séjour et ses avis</button></h2>
                </li>
                <li class="commAvis"><?php echo e($avie['commentaire']); ?> <span class="nomClient"><?php echo e($avie->client->nomclient); ?></span> <span class="prenomClient"><?php echo e(substr($avie->client->prenomclient, 0, 1)); ?>.</span></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    

    <!-- <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script> -->
    <!-- <df-messenger intent="WELCOME" chat-title="Vinotrip" agent-id="7b4ad48a-de71-45d7-b54f-bb72f83c4104" language-code="fr"></df-messenger> -->


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/s223/vinotrip/resources/views/welcome.blade.php ENDPATH**/ ?>