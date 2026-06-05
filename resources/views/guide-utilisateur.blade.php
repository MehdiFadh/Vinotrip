@extends('layouts.app')

@section('content')

    
<link rel="stylesheet" href="{{ asset('css/guide-utilisateur.css') }}">


<section>
    <h1>Bonjour et binevenue sur le guide utilisateur de notre site web !</h1>

    <h2 id="1-page-accueil">1. Page d'Accueil</h2>
    <div class="step">
        <img src="{{ asset('img/guide-utilisateur/accueil.png') }}" alt="Page d'accueil">

        <p>Lorsque vous accédez à la page d'accueil, vous êtes accueilli par une vidéo présentant notre entreprise.<br><br>
           Dans la zone entourée en rouge, vous avez les différentes pages accessibles pour la réservation de séjour, la page pour nous contacter, voir son panier, s'inscrire et se connecter.<br><br>
           Dans la zone entourée en bleu, un chatbot est disponible pour répondre à vos questions urgentes.<br><br>
           Dans la zone entourée en vert, vous trouverez plusieurs avis clients sur différents séjours. En cliquant sur "Voir le séjour et ses avis", vous accédez à la page dédiée au séjour.<br><br>
           Dans la zone entourée en jaune, vous avez les différentes pages telles que ce guide utilisateur ainsi que les conditions de vente, les conditions d'utilisation, la politique de confidentialité et les mentions légales.
    </p>
    </div>

    <h2>2. Explorer les Offres</h2>
    <div class="step">
        <p>Les offres sont affichées sous forme de cartes (en vert). Chaque carte affiche une offre de séjour avec une description, un prix de départ ett la moyenne des avis clients. Cliquez sur "Découvrir l'offre" affiche les détails du séjour.</p>
        <img src="{{ asset('img/guide-utilisateur/sejours.jpeg') }}" alt="Explorer les offres">
        <p> Tout les séjours sont affichés sur cette page, il suffit de défiler vers le bas pour les voir. <br>
            Cepedant des filtres et un champ de recherche libre vous permettent d'affiner vos recherches.<br>
            Sur la page de recherche, vous pouvez filtrer par destination, catégorie de séjour, et type de participants. <br>
            Par exemple, choisissez "Bordeaux" et "Famille" pour voir les options adaptées à votre recherche.<br>
            Les i entourés vous affichent des explications (aides) dans les pages lorsque vous les survolez avec votre souris.</p>
    </div>

    <h2>3. Détails séjours</h2>
    <div class="step">
    <p>Lorsque vous appuyez sur "Découvrir le séjour", vous tombez sur une page présentant les étapes et sous-étapes du séjour. </p>
    <img src="{{ asset('img/guide-utilisateur/detail-sejour1.jpeg') }}" alt="Description séjour">
    <h3>Consulter les Détails des étapes du Séjour</h2>
    
    <p>La page de présentation affiche une image du séjour ainsi qu'une description introductive. Les étapes sont organisées par jour, avec des sous-étapes détaillant chaque activité.</p>
    <img src="{{ asset('img/guide-utilisateur/detail-sejour2.jpeg') }}" alt="Jour 2 - Du vin au naturel">
        <p>Par exemple, "Jour 2 - Du vin au naturel" vous permettra de découvrir les vins bio et les producteurs locaux, tout en explorant la nature environnante.</p>
    </div>

    <h3> Voir les Hébergements Disponibles</h2>
    <div class="step">
        <p>
            Chaque séjour inclut plusieurs options d'hébergement.<br>
            Vous pouvez consulter les images des établissements disponibles et lire leurs descriptions.<br>
            Pour en savoir plus sur chaque option, cliquez sur le bouton "Voir les détails".<br>

        </p>
        <img src="{{ asset('img/guide-utilisateur/detail-sejour4.jpeg') }}" alt="Hébergement à La Dryade">
        <p>
            Par exemple, en cliquant sur "Détails" à côté de "La Dryade", vous accédez aux informations complètes sur l'hébergement.<br><br>
            Vous trouverez également un lien direct vers le site du partenaire pour plus de détails.
        </p>
    </div>

    <h3>Ajouter à son panier et réserver</h2>
    <div class="step">
    <p>Une fois que vous avez sélectionné votre séjour et votre hébergement, personnalisez votre réservation en indiquant le nombre de participants et les dates. .<br><br>
        Cliquez sur "Réserver" pour finaliser vos dates, ou sur "Offrir" pour offrir le séjour à quelqu'un.<br><br>
        Les deux options ajouteront le séjour à votre panier pour que vous puissiez procéder à la validation de votre commande.
    </p>
    <img src="{{ asset('img/guide-utilisateur/detail-sejour5.jpeg') }}" alt="Réservation">
        <h3>Voir les Avis Clients</h2>
        <p>Après avoir sélectionné votre séjour, vous pourrez accéder à votre panier pour finaliser votre réservation.</p>
        <p>Chaque séjour est accompagné d'avis de clients ayant déjà réalisé le séjour. Ces retours peuvent vous aider à faire un choix éclairé avant de réserver.</p>
        <p>Les avis des clients précédents reflètent leurs expériences et vous donnent un aperçu des activités proposées, vous aidant ainsi à mieux préparer votre séjour.</p>
    </div>
    

    <h2>4. Page des Destinations</h2>
    <div class="step">
        <p>Accédez à la page des destinations pour explorer les régions viticoles comme Bordeaux, Beaujolais, et d'autres. Cliquez sur "Voir les séjours" pour découvrir toutes les offres dans cette région.</p>
        <img src="{{ asset('img/guide-utilisateur/destinations.png') }}" alt="Destinations">
        <p>
            La liste complète des destinations disponibles sur notre site est affichée.<br><br>
            Sélectionnez la destination de votre choix en cliquant sur "Voir les séjours".<br><br><br>
        </p>
        <p>Une fois votre destination choisie, vous serez redirigé vers la page des séjours disponibles pour cette destination.</p>
        <img src="{{ asset('img/guide-utilisateur/destination_detail.png') }}" alt="Destinations détails">
        <p>
            La liste complète des séjours disponibles pour cette destination s'affiche.<br><br>
            Un système de recherche similaire à celui de la page "Tous les séjours" est disponible pour affiner vos choix.<br><br>
            Vous pouvez également cliquer sur "Découvrir l'offre" pour accéder à la page détaillée de chaque séjour.<br><br>
        </p>

    </div>

    <h2>5. Description des Routes des vins</h2>
    <div class="step">
        <p>Depuis les offres spéciales, dans l'en-tête, vous avez accès aux routes des vins et à la page d'achat de chèques cadeau. <br>
            Chaque route des vins est décrite en détail pour vous aider à choisir celui qui correspond le mieux à vos attentes. <br>
            Ces routes vous offrent des découvertes exceptionnelles du vin, des caves et des vignobles.</p>
        <img src="{{ asset('img/guide-utilisateur/route_de_vins.png') }}" alt="Route des vins">
        <p>
            Une présentation du concept des routes de vins est disponible pour vous en introduction.<br><br>
            Ensuite, vous trouverez une présentation des différentes routes des vins proposées sur notre site.<br><br>
            Pour plus d'informations sur une route, cliquez sur "Découvrir l'offre".<br><br><br>
        </p>
        <p>Après avoir cliqué sur "Découvrir l'offre", une nouvelle page s'ouvre avec les détails de l'itinéraire sélectionné.</p>
        <img src="{{ asset('img/guide-utilisateur/detail_route_vin.png') }}" alt="Route des vins">
        <p>
            Vous trouverez le titre et la description de la route des vins.<br><br>
            Une liste complète des séjours disponibles sur la route des vins est également présente. Cliquez sur "Découvrir l'offre" pour accéder aux détails de chaque séjour.
        </p>



    </div>

    <h2>6. Contactez-nous</h2>
    <div class="step">
        <img src="{{ asset('img/guide-utilisateur/contact.png') }}" alt="Formulaire de contact">
        <p>Si vous avez des questions ou besoin d'assistance, vous pouvez nous contacter via le formulaire de contact sur le site.<br><br>
        Dans la case "Nom", indiquez votre nom et prénom. Saisissez votre adresse email dans la case "Email", puis écrivez votre message dans la case "Message".
        </p>

    </div>

    <h2>7. Inscription et Connexion</h2>
    <div class="step">
        <p>Pour accéder à plus de fonctionnalités, vous pouvez créer un compte. Entrez vos informations dans le formulaire d'inscription. Si vous avez déjà un compte, connectez-vous directement.</p>
        <img src="{{ asset('img/guide-utilisateur/inscription.jpeg') }}" alt="Formulaire d'inscription">
        <p>
        Pour vous inscrire, remplissez les champs ci-dessous avec vos informations personnelles.<br><br>
        Dans la case "Nom", entrez votre nom de famille.<br><br>
        Dans la case "Prénom", saisissez votre prénom.<br><br>
        Renseignez votre adresse e-mail dans le champ "Adresse e-mail".<br><br>
        Entrez votre numéro de téléphone dans le champ prévu à cet effet.<br><br>
        Choisissez un mot de passe sécurisé et entrez-le dans la case "Mot de passe".<br><br>
        Confirmez votre mot de passe en le saisissant à nouveau dans la dernière case.<br><br>
        Une fois toutes les informations remplies, cliquez sur le bouton "S'inscrire" pour finaliser votre inscription.<br><br>
        Si vous avez déjà un compte, cliquez sur "Connectez-vous ici" pour accéder à votre espace personnel.
        </p>
        <p>Après avoir appuyé sur "S'inscrire", une fenêtre va s'ouvrir</p>
        <img src="{{ asset('img/guide-utilisateur/inscription2.png') }}" alt="Formulaire d'inscription">
        <p>
            Un code de vérification vous a été envoyé par e-mail.<br><br>
            Saisissez le code reçu dans le champ "Code de vérification (e-mail)".<br><br>
            Une fois le code entré, cliquez sur le bouton "Vérifier" pour valider votre compte.<br><br>
            Si vous n’avez pas reçu le code, vérifiez votre dossier de courrier indésirable ou demandez un nouvel envoi.
        </p>
    </div>

    <h2>8. Connexion à votre Compte</h2>
    <div class="step">
        <p>Une fois inscrit, vous pouvez vous connecter avec votre email et mot de passe. Cela vous permettra de gérer vos réservations et offres personnalisées.</p>
        <img src="{{ asset('img/guide-utilisateur/connexion.jpeg') }}" alt="Connexion">
        <p>
        Pour vous connecter, entrez votre adresse e-mail dans le champ "Adresse e-mail".<br><br>
        Saisissez ensuite votre mot de passe dans le champ "Mot de passe".<br><br>
        Une fois les informations remplies, cliquez sur le bouton "Se connecter" pour accéder à votre compte.<br><br>
        Si vous n'avez pas encore de compte, cliquez sur "Créez un compte" pour vous inscrire.
        </p>
    </div>

    <h2>9. Panier - Commander </h2>
    <div class="step">
        <h3>Page du Panier</h2>
        <div >
            <p>Vous voyez le panier avec deux séjours : un séjour effectif et un séjour cadeau. Vous pouvez passer la commande en cliquant sur le bouton <strong>Commander</strong>. <br>
             Ce bouton est visible uniquement si vous êtes connecté. Si vous n'êtes pas connecté, un bouton <strong>Se connecter</strong> sera présent au bas du panier. <br>
             Vous pouvez également modifier les détails de chaque élément dans le panier en utilisant les champs de saisie. Pour enregistrer chaque modification, <br>
             il faut appuyer sur le bouton <strong>Modifier</strong> correspondant au séjour modifié. Le bouton <strong>Supprimer</strong> retire le séjour du panier.</p>
             <p><strong>Vous ne pouvez pas ajouter deux séjours identiques sur le même panier.</strong></p>
            <img src="{{ asset('img/guide-utilisateur/panier2.jpeg') }}" alt="Page du Panier">
        </div>

        <h3>Sélectionner une Adresse</h2>
        <div>
            <p>Après avoir cliqué sur <strong>Commander</strong>, vous devez choisir une adresse de facturation. Vous avez deux options : soit sélectionner une adresse existante, <br>
            soit ajouter une nouvelle adresse. Une fois l'adresse choisie, votre panier sera vidé et vous pourrez consulter votre commande dans l'historique des commandes, accessible depuis le panier.</p>
            <img src="{{ asset('img/guide-utilisateur/choix-adresse.jpeg') }}" alt="Sélectionner une adresse">
            <p><strong>Une fois la commande est passée, seul un membre de service vente peut l'annuler. </strong></p>
        </div>

        <h3>Historique des Commandes</h2>
        <div>
            <p>Le panier se vide après que vous ayez passé votre commande. Et vous pouvez le consulter dans l'historique de commande.  </p>
            <img src="{{ asset('img/guide-utilisateur/panier.jpeg') }}" alt="Page du Panier">
            <p>Une fois la commande passée, vous pouvez consulter l’historique de vos commandes dans la section correspondante depuis le panier. <br>
                Si certains séjours sont encore en attente de paiement, vous pourrez les payer ici. Vous pouvez également télécharger <br>
                les factures des commandes déjà payées en cliquant sur le bouton <strong>Générer Facture PDF</strong>.</p>
            <img src="{{ asset('img/guide-utilisateur/historique_commande.jpeg') }}" alt="Historique des commandes">
            <p>Pour payer une commande, vous devez d'abord attendre la validation du service de vente. Une fois le paiement disponible, <br>
                vous pourrez procéder au règlement depuis l'historique des commandes, comme montré ci-dessous :</p> 
            <img src="{{ asset('img/guide-utilisateur/histo-paiement.jpeg') }}" alt="Historique des commandes">
            <p>Le paiement est géré par un service externe, Stripe, qui prend en charge la transaction. Une fois la transaction effectuée, <br>
                l'état de la commande est mis à jour en "Effectué".</p>
            <img src="{{ asset('img/guide-utilisateur/stripe.jpeg') }}" alt="Stripe">
        </div>
    </div>
</section>
<!-- 
<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger intent="WELCOME" chat-title="Vinotrip" agent-id="7b4ad48a-de71-45d7-b54f-bb72f83c4104" language-code="fr"></df-messenger> -->


@endsection
