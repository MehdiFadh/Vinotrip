@extends('layouts.app')

@section('content')
<div class="container-verification">
    <h2>Vérification de votre compte</h2>

    @if(session('error'))
        <div class="alert-verification error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('verification.verify')}}">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">

        <!-- Champ pour le code de vérification e-mail -->
        <div class="form-group-verification">
            <label for="email_code">Code de vérification (e-mail)</label>
            <input type="text" name="email_code" id="email_code" class="form-control" required>
        </div>

        <!-- Champ pour le code de vérification SMS -->
        <!--<div class="form-group-verification">
            <label for="sms_code">Code de vérification (SMS)</label>
            <input type="text" name="sms_code" id="sms_code" class="form-control" required>
        </div>-->

        <button type="submit" class="btn-verification">Vérifier</button>
    </form>
</div>
<!-- 
<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger intent="WELCOME" chat-title="Vinotrip" agent-id="7b4ad48a-de71-45d7-b54f-bb72f83c4104" language-code="fr"></df-messenger> -->
@endsection