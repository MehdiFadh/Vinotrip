    <!DOCTYPE html>
    <html lang="fr">
    <head>
    <?php echo Whitecube\LaravelCookieConsent\Facades\Cookies::renderScripts(); ?>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $__env->yieldContent('title', 'Vinotrip'); ?></title>
        <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/welcome.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/sejour.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/politique_de_confidentialite.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/details.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/show.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/destination.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/panier.css')); ?>">
       


        
        <link rel="icon" type="image/x-icon" href="/img/favicon.ico">

    </head>
    <body>
    

        <header>
            <div class="logo-slogan">
                <a href="/"><img src="<?php echo e(asset('img/logo.png')); ?>" alt="Logo du site" class="logo"></a>
            </div>

            <nav class="nav-links">
                <ul>
                    <li><a href="/sejours">Tous les séjours</a></li>
                    <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->check() && auth()->user()->role === 'service_vente'): ?>
                        <li><a href="/commandesEffectif-affichage">Toutes les commandes</a></li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->check() && auth()->user()->role === 'service_marketing'): ?>
                        <li><a href="<?php echo e(route('sejours.en_attente2')); ?>">Séjours à compléter</a></li>                   
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->check() && auth()->user()->role === 'dirigeant'): ?>
                        <li><a href="/commandesEffectif-affichage">Toutes les commandes</a></li>
                        <li><a href="<?php echo e(route('rapport.ventes')); ?>">Rapport</a></li>
                        <li><a href="<?php echo e(route('sejours.create')); ?>">Créer un séjour</a></li>
                        <li><a href="<?php echo e(route('sejours.validation')); ?>">Valider les séjours</a></li> <!-- Lien pour valider les séjours -->
                    <?php endif; ?>
                    <?php endif; ?>    
                    <li><a href="/destinations">Destinations</a></li>
                    <li class="dropdown">
                        <a href="/route_de_vins" class="dropbtn">Offres spéciales</a>
                        <div class="dropdown-content">
                            <a href="/route_de_vins">Route des vins</a>
                            <a href="<?php echo e(route('cheque-cadeau')); ?>">Chèque cadeau</a>
                        </div>
                    </li>

                    <li><a href="/nous_contacter">Contact</a></li>
                    <li><a href="/panier">Voir le panier</a></li>
                    <?php if(auth()->guard()->guest()): ?>
                        <li><a href="<?php echo e(route('inscription.index')); ?>">Inscription</a></li>
                        <li><a href="<?php echo e(route('login')); ?>">Connexion</a></li>
                    <?php endif; ?>

                    <!-- Lien pour les utilisateurs connectés -->
                    <?php if(auth()->guard()->check()): ?>
                        <li><a href="<?php echo e(route('account.show')); ?>">Voir mon compte</a></li>
                        <!-- Option pour déconnexion -->
                        <li>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-log-out">
                                    Déconnexion
                                </button>
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>

        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        

        <script>
            (function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="UX3qPsw2RO57pER0Du12v";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
        </script>
    
        <footer>
            <br>
                <div class="rubrique-droit">
                    <a href="/guide-utilisateur">Besoin d'aide ?</a>
                    <a href="/conditions_vente">Conditions de Vente</a>
                    <a href="/conditions_utilisation">Conditions d'Utilisation<br></a>
                    <a href="/politique_de_confidentialite">Politique de Confidentialité<br></a>
                    <a href="/mentions_legales">Mentions Légales</a>
                </div>
            </br>
        </footer>

        <script src="https://cdn.pulse.io/pulse.js"></script>
    </body>     
</html>
<?php /**PATH /home/s223/vinotrip/resources/views/layouts/app.blade.php ENDPATH**/ ?>