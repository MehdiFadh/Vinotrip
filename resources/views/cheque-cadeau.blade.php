@extends('layouts.app')

@section('content')
<div class="container">
<link rel="stylesheet" href="{{ asset('css/cheque-cadeau.css') }}">
        <h2>Chèque Cadeau</h2>
        <p>Offrez un cadeau unique adapté aux envies de vos proches en leur permettant de choisir leur destination parmi une grande variété de séjours et d'expériences. Le chèque cadeau est valable pendant 18 mois et est entièrement flexible.</p>
        
        <div class="etapes">
            <h3>Étapes de Commande</h3>
            <form action="{{ route('panier.ajouter.article') }}" method="POST">
                <input type="hidden" name="type" value="cheque_cadeau">

                <div class="formulaire-groupe">
                    <label for="montant">1 - Choisissez le montant du chèque cadeau à offrir :</label>
                    <select id="montant" name="montant" required>
                        <option value="50">50€</option>
                        <option value="100">100€</option>
                        <option value="150">150€</option>
                        <option value="200">200€</option>
                        <option value="250">250€</option>
                        <option value="300">300€</option>
                        <option value="350">350€</option>
                        <option value="400">400€</option>
                        <option value="450">450€</option>
                        <option value="500">500€</option>
                        <option value="600">600€</option>
                        <option value="700">700€</option>
                        <option value="800">800€</option>
                        <option value="900">900€</option>
                        <option value="1000">1000€</option>
                    </select>
                </div>

                <div class="formulaire-groupe">
                    <label>2 - Sélectionnez votre format cadeau (1) :</label>
                    <div class="radio-option">
                        <input type="radio" id="e-coffret" name="format" value="e-coffret" checked>
                        <label for="e-coffret">e-coffret - envoi immédiat par email - GRATUIT</label>
                    </div>
                </div>

                <div class="formulaire-groupe">
                    <label>3 - Personnalisez votre chèque cadeau (facultatif) :</label>
                    <div class="section-personnalisation">
                        <button type="button" class="btn" id="bouton-oui">Oui</button>
                        <button type="button" class="btn" id="bouton-non">Non</button>
                    </div>
                    <div id="champs-personnalisation" style="display: none;">
                        <div class="formulaire-groupe">
                            <label for="offert-par">Cadeau offert par :</label>
                            <input type="text" id="offert-par" name="offert_par" maxlength="80" placeholder="Votre nom">
                        </div>
                        <div class="formulaire-groupe">
                            <label for="message">Message personnalisé :</label>
                            <textarea id="message" name="message" maxlength="500" placeholder="Ajoutez un message personnalisé"></textarea>
                            <span class="texte-gris">0/500</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn">Offrir</button>
            </form>
            
        </div>
    </div>

    <script>
        const boutonOui = document.getElementById('bouton-oui');
        const boutonNon = document.getElementById('bouton-non');
        const champsPersonnalisation = document.getElementById('champs-personnalisation');

        boutonOui.addEventListener('click', () => {
            champsPersonnalisation.style.display = 'block';
        });

        boutonNon.addEventListener('click', () => {
            champsPersonnalisation.style.display = 'none';
        });
    </script>
    @endsection