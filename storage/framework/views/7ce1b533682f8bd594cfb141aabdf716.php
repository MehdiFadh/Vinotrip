    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <!-- Google Tag Manager -->
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5SSB9H7W');</script>
        <!--End Google Tag Manager -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $__env->yieldContent('title', 'Vinotrip'); ?></title>
        <link rel="stylesheet" href="<?php echo e(asset('css/main.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/welcome.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/sejour.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/route_de_vins.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/politique_de_confidentialite.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/nous_contacter.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/details.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/show.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/destination.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/panier.css')); ?>">

        
        <link rel="icon" type="image/x-icon" href="/img/favicon.ico">

    </head>
    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5SSB9H7W"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
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
                    <?php if(auth()->check() && auth()->user()->role === 'dirigeant'): ?>
                        <li><a href="/commandesEffectif-affichage">Toutes les commandes</a></li>
                        <li><a href="<?php echo e(route('sejours.create')); ?>">Créer un séjour</a></li>
                        <li><a href="<?php echo e(route('sejours.validation')); ?>">Valider les séjours</a></li> <!-- Lien pour valider les séjours -->
                    <?php endif; ?>
                    <?php endif; ?>    
                    <li><a href="/destinations">Destinations</a></li>
                    <li><a href="/route_de_vins">Offres spéciales</a></li>
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
window.axeptioSettings = {
  clientId: "677e97040fca84a2d93ec2a4",
  cookiesVersion: "vinotrip sae-fr-EU",
  googleConsentMode: {
    default: {
      analytics_storage: "denied",
      ad_storage: "denied",
      ad_user_data: "denied",
      ad_personalization: "denied",
      wait_for_update: 500
    }
  }
};
 
(function(d, s) {
  var t = d.getElementsByTagName(s)[0], e = d.createElement(s);
  e.async = true; e.src = "//static.axept.io/sdk.js";
  t.parentNode.insertBefore(e, t);
})(document, "script");
</script>
        <footer>
            <br>
                <div class="rubrique-droit">
                    <a href="/conditions_vente">Conditions de Vente</a>
                    <a href="/conditions_utilisation">Conditions d'Utilisation<br></a>
                    <a href="/politique_de_confidentialite">Politique de Confidentialité<br></a>
                    <a href="/mentions_legales">Mentions Légales</a>
                </div>
            </br>
        </footer>
    </body>     
</html>
<?php /**PATH /home/s223/vinotrip/resources/views/layouts/app.blade.php ENDPATH**/ ?>