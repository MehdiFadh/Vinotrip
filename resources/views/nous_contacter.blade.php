@extends('layouts.app')

@section('content')

        <div class="contact-form-container">
        <h1>Nous Contacter</h1>
        <form action="#" method="post" class="contact-form">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required placeholder="Votre nom">
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required placeholder="Votre email">
            </div>
            <div class="form-group">
                <label for="sujet">Sujet :</label>
                <select id="sujet" name="sujet">
                    <option value="question">Question</option>
                    <option value="demande">Demande</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Message :</label>
                <textarea id="message" name="message" required placeholder="Votre message"></textarea>
            </div>
            <button type="submit" class="btn-submit">Envoyer</button>
        </form>
    </div>
@endsection
    
