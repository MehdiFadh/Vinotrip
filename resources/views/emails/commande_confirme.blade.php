<h1>Votre séjour est confirmé !</h1>

<p>Bonjour {{ $commande->user->name }},</p>

<p>Votre séjour <strong>{{ $commande->sejour->titresejour }}</strong> est confirmé.</p>

<p>Voici les détails :</p>
<ul>
    <li>Adultes : {{ $commande->adultes }}</li>
    <li>Enfants : {{ $commande->enfants }}</li>
    <li>Total : {{ $commande->prix_total }} €</li>
</ul>

<p>Veuillez régler votre séjour en cliquant sur le lien ci-dessous :</p>
<a href="{{ route('paiement.index', ['commande' => $commande->id]) }}">Régler maintenant</a>

<p>Merci pour votre confiance,</p>
<p>L'équipe de réservation</p>
