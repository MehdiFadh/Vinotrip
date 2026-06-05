@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/nous_contacter.css') }}">
@section('content')

@if(session('success'))
        <div class="alert-alert-success">
            {{ session('success') }}
        </div>
    @endif

        <div class="contact-form-container">
        <h1>Nous Contacter</h1>
        <form action="{{ route('contact.formulaire') }}" method="post" class="contact-form">
        @csrf
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required>
            
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>
            
            <label for="message">Message :</label>
            <textarea name="message" id="message" required></textarea>
            
            <button type="submit">Envoyer</button>
                </form>
            </div>


            <!-- <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
            <df-messenger intent="WELCOME" chat-title="Vinotrip" agent-id="7b4ad48a-de71-45d7-b54f-bb72f83c4104" language-code="fr"></df-messenger> -->
@endsection
    
