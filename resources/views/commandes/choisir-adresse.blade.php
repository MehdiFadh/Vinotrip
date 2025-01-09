@extends('layouts.app')

@section('content')

<style>
    .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h1, h2 {
    color: #333;
}

hr {
    border: 1px solid #ddd;
}

.form-check-label strong {
    color: #007bff;
}

.form-choix-adresse .form-check {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 10px;
    background-color: #fff;
}

.form-choix-adresse .form-check:hover {
    background-color: #f1f1f1;
}

.btn {
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
}

.btn-primary {
    background-color: #007bff;
    border: none;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-success {
    background-color: #28a745;
    border: none;
}

.btn-success:hover {
    background-color: #218838;
}

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875em;
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

input.form-control {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

input.form-control:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 3px rgba(0, 123, 255, 0.25);
}

</style>
<div class="container">
    <h1 class="text-center mb-4">Choisissez une adresse</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="mb-3">Adresses existantes</h2>
    @if ($adresses->isEmpty())
        <p class="text-muted">Aucune adresse enregistrée.</p>
    @else
        <form action="{{ route('enregistrement.commande') }}" method="POST" class="form-choix-adresse">
            @csrf
            <div class="form-group">
                @foreach ($adresses as $adresse)
                    <div class="form-check mb-2">
                        <input 
                            type="radio" 
                            name="adresse_id" 
                            value="{{ $adresse->code_adresse_client }}" 
                            class="form-check-input" 
                            required
                        >
                        <label class="form-check-label">
                            <strong>{{ $adresse->nom_adresse_client }}</strong><br>
                            {{ $adresse->rue_client }}, {{ $adresse->ville_client }} ({{ $adresse->pays_client }})
                        </label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Utiliser cette adresse</button>
        </form>
    @endif

    <hr class="my-5">

    <h2 class="mb-3">Ajouter une nouvelle adresse</h2>
    <form action="{{ route('commande.adresse') }}" method="POST" class="form-ajout-adresse">
        @csrf
        <div class="form-group">
            <label for="nom_adresse_client">Nom de l'adresse</label>
            <input 
                type="text" 
                id="nom_adresse_client" 
                name="nom_adresse_client" 
                class="form-control @error('nom_adresse_client') is-invalid @enderror" 
                value="{{ old('nom_adresse_client') }}" 
                required
            >
            @error('nom_adresse_client')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="ligne1">Rue</label>
            <input 
                type="text" 
                id="ligne1" 
                name="ligne1" 
                class="form-control @error('ligne1') is-invalid @enderror" 
                value="{{ old('ligne1') }}" 
                required
            >
            @error('ligne1')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="ville">Ville</label>
            <input 
                type="text" 
                id="ville" 
                name="ville" 
                class="form-control @error('ville') is-invalid @enderror" 
                value="{{ old('ville') }}" 
                required
            >
            @error('ville')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="code_postal">Code postal</label>
            <input 
                type="text" 
                id="code_postal" 
                name="code_postal" 
                class="form-control @error('code_postal') is-invalid @enderror" 
                value="{{ old('code_postal') }}" 
                required
            >
            @error('code_postal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="pays">Pays</label>
            <input 
                type="text" 
                id="pays" 
                name="pays" 
                class="form-control @error('pays') is-invalid @enderror" 
                value="{{ old('pays') }}" 
                required
            >
            @error('pays')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success">Ajouter l'adresse</button>
    </form>
</div>
@endsection
