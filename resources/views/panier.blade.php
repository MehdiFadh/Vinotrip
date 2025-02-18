@extends('layouts.app')

@section('content')
  <!-- Affichage des messages -->
    @if (session('success'))
        <div class="custom-alert success-alert">
            <span class="custom-alert-icon">&#x2714;</span>
            <p class="custom-alert-message">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="custom-alert error-alert">
            <span class="custom-alert-icon">&#x26A0;</span>
            <p class="custom-alert-message">{{ session('error') }}</p>
        </div>
    @endif

    @if (session('info'))
        <div class="custom-alert info-alert">
            <span class="custom-alert-icon">&#x1F4AC;</span>
            <p class="custom-alert-message">{{ session('info') }}</p>
        </div>
    @endif

    <div class="panier-container">
        <h1 class="panier-title">Votre Panier</h1>
        @auth
        <a href="{{route('commandes.historique')}}">Voir l'historique des commandes</a>
        @endauth
       

        @if (!empty($panier) && count($panier) > 0 )
            <div class="panier-item">
                <form method="POST" class="message-form">
                    @csrf
                    <label for="message_commande" class="message-label">Message personnalisé :</label>
                    <textarea id="message_commande" name="message_commande" class="message-textarea" placeholder="Ajoutez un message ici (facultatif)">{{ session('message_commande', '') }}</textarea>
                </form>
            </div>
            @foreach ($panier as $item)
                @if (isset($item['type']) && $item['type'] === 'cheque_cadeau')
                    <!-- Affichage du chèque cadeau -->
                    <div class="panier-item">
                        <div class="panier-item-details">
                            <h3>Chèque Cadeau</h3>
                            <p><strong>Montant :</strong> {{ $item['montant'] }} €</p>
                            <p><strong>Format :</strong> {{ $item['format'] }}</p>
                            @if (!empty($item['offert_par']))
                                <p><strong>Offert par :</strong> {{ $item['offert_par'] }}</p>
                            @endif
                            @if (!empty($item['message']))
                                <p><strong>Message :</strong> {{ $item['message'] }}</p>
                            @endif
                        </div>

                        <!-- Formulaire Suppression -->
                        <form action="{{ route('panier.supprimer') }}" method="POST" class="panier-form">
                            @csrf
                            <input type="hidden" name="sejour_id" value="{{ $loop->index }}">
                            <button type="submit" class="btn-suppr">Supprimer</button>
                        </form>
                    </div>
                @else
                    <!-- Affichage du séjour -->
                    <div class="panier-item">
                        <!-- Image -->
                        <img src="{{ asset('img/img_sejour/' . $item['url_photo_sejour']) }}" 
                             alt="{{ $item['titresejour'] }}" 
                             class="panier-item-image">

                        <!-- Détails du séjour -->
                        <div class="panier-item-details">
                            <h3>{{ $item['titresejour'] }}</h3>
                            <p>Prix par adulte : {{ $item['prix_sejour'] }} €</p>
                            <p>Prix par enfant : {{ $item['prix_sejour'] }} €</p>
                            <p>Adultes : {{ $item['adultes'] }}</p>
                            <p>Enfants : {{ $item['enfants'] }}</p>
                            <p>Chambres : {{ $item['chambres'] }}</p>
                            <p class="panier-item-price">
                                <strong>Prix total pour ce séjour : {{ $item['prix_total']}} €</strong>
                            </p>
                        </div>

                        <!-- Formulaires -->
                        <div>
                            <!-- Formulaire Modification -->
                            <form action="{{ route('panier.modifier') }}" method="POST" class="panier-form">
                                @csrf
                                <input type="hidden" name="sejour_id" value="{{ $item['sejour_id'] }}">
                                <label for="adultes">Adultes :</label>
                                <input type="number" name="adultes" value="{{ $item['adultes'] }}" min="0" class="panier-form-input">

                                <label for="enfants">Enfants :</label>
                                <input type="number" name="enfants" value="{{ $item['enfants'] }}" min="0" class="panier-form-input">

                                <label for="chambres">Chambres :</label>
                                <input type="number" name="chambres" value="{{ $item['chambres'] }}" min="0" class="panier-form-input">
                                
                                @if (isset($item['mode_cadeau']) && !$item['mode_cadeau']) <!-- Si ce n'est pas un cadeau -->
                                    <label for="date_sejour_{{ $item['sejour_id'] }}">Début du séjour :</label>
                                    <input type="date" 
                                        id="date_sejour_{{ $item['sejour_id'] }}" 
                                        name="date_sejour" 
                                        value="{{ $item['date_sejour'] ?? date('Y-m-d') }}"
                                        class="panier-form-input">
                                @endif
                                <button type="submit" class="btn-edit">Modifier</button>
                            </form>

                            <!-- Formulaire Suppression -->
                            <form action="{{ route('panier.supprimer') }}" method="POST" class="panier-form">
                                @csrf
                                <input type="hidden" name="sejour_id" value="{{ $item['sejour_id'] }}">
                                <button type="submit" class="btn-suppr">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Formulaire Code Réduction -->
            <div class="panier-item">
                <form action="{{ route('panier.CodeReduction') }}" method="POST" class="panier-form">
                    @csrf
                    <p>Code de réduction :</p>
                    <input type="text" name="codeReduction" min="0" class="panier-code-reduction">
                    <button type="submit" class="btn-suppr">Ajouter le code de réduction</button>
                </form>
            </div>

            <!-- Affichage du montant total avec réduction si applicable -->
            @php
                $totalPanier = $total; // Total avant réduction
                $reduction = session('montant_reduction', 0);
                $totalPanierApresReduction = $totalPanier - $reduction;
            @endphp

            <!-- Total du panier -->
            <p class="panier-item-price">Total du panier : {{ $total }} €</p>

            @if ($reduction > 0)
                <p class="panier-item-price">Réduction appliquée : {{ $reduction }} €</p>
                @if ($totalPanierApresReduction > 0)
                <p class="panier-item-price">Total après réduction : {{ $totalPanierApresReduction }} €</p>
                @else
                <p class="panier-item-price">Total après réduction : 0 €</p>
                @endif
            @endif

            <div class="panier-actions">
            @guest
                <p>Merci de vous connecter pour pouvoir continuer vos achats.</p>
                <button onclick="location.href='{{ route('login') }}'" class="btn-edit">Connexion</button>
            @endguest
            @auth
                <form action="{{route('commande.preparation')}}" method="POST" id="payment-form">
                    @csrf
                    <!-- Champ masqué pour le message personnalisé -->
                    <input type="hidden" name="message_commande" id="hidden_message_commande" value="{{ session('message_commande', '') }}">
                    
                    <!-- Bouton de commander -->
                    <button type="submit" class="btn-edit">Commander</button>
                </form>
            @endauth
    </div>
        @else
            <!-- Panier vide -->
            <p class="panier-empty-message">Votre panier est vide.</p>
        @endif
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
@endsection
