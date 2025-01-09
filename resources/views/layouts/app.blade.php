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
        <title>@yield('title', 'Vinotrip')</title>
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sejour.css') }}">
        <link rel="stylesheet" href="{{ asset('css/route_de_vins.css') }}">
        <link rel="stylesheet" href="{{ asset('css/politique_de_confidentialite.css') }}">
        <link rel="stylesheet" href="{{ asset('css/nous_contacter.css') }}">
        <link rel="stylesheet" href="{{ asset('css/details.css') }}">
        <link rel="stylesheet" href="{{ asset('css/show.css') }}">
        <link rel="stylesheet" href="{{ asset('css/destination.css') }}">
        <link rel="stylesheet" href="{{ asset('css/panier.css') }}">

        
        <link rel="icon" type="image/x-icon" href="/img/favicon.ico">

    </head>
    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5SSB9H7W"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <header>
            <div class="logo-slogan">
                <a href="/"><img src="{{ asset('img/logo.png') }}" alt="Logo du site" class="logo"></a>
            </div>

            <nav class="nav-links">
                <ul>
                    <li><a href="/sejours">Tous les séjours</a></li>
                    @auth
                    @if(auth()->check() && auth()->user()->role === 'service_vente')
                        <li><a href="/commandesEffectif-affichage">Toutes les commandes</a></li>
                    @endif
                    @endauth
                    @auth
                    @if(auth()->check() && auth()->user()->role === 'dirigeant')
                        <li><a href="/commandesEffectif-affichage">Toutes les commandes</a></li>
                        <li><a href="{{ route('sejours.create') }}">Créer un séjour</a></li>
                        <li><a href="{{ route('sejours.validation') }}">Valider les séjours</a></li> <!-- Lien pour valider les séjours -->
                    @endif
                    @endauth    
                    <li><a href="/destinations">Destinations</a></li>
                    <li><a href="/route_de_vins">Offres spéciales</a></li>
                    <li><a href="/nous_contacter">Contact</a></li>
                    <li><a href="/panier">Voir le panier</a></li>
                    @guest
                        <li><a href="{{ route('inscription.index') }}">Inscription</a></li>
                        <li><a href="{{ route('login') }}">Connexion</a></li>
                    @endguest

                    <!-- Lien pour les utilisateurs connectés -->
                    @auth
                        <li><a href="{{ route('account.show') }}">Voir mon compte</a></li>
                        <!-- Option pour déconnexion -->
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn-log-out">
                                    Déconnexion
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </nav>
        </header>





        <div class="container">
            @yield('content')
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
