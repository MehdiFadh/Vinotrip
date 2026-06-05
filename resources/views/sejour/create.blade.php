@extends('layouts.app')

@section('title', 'Créer un nouveau séjour')

@section('content')
<div class="form-container-sejour-creation my-5">
    <h1 class="form-title-sejour-creation text-center mb-4">Créer un nouveau séjour</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('sejours.store') }}" method="POST" class="sejour-form-create">
        @csrf
        <div class="form-group-sejour-create">
            <label for="idtheme" class="form-label-sejour-create">ID Thème</label>
            <input type="number" name="idtheme" id="idtheme" class="form-control-sejour-create" value="{{ old('idtheme') }}" required>
            @error('idtheme')
                <div class="text-danger error-message-sejour-create">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-sejour-create">
            <label for="num_destination_sejour" class="form-label-sejour-create">Numéro Destination</label>
            <input type="number" name="num_destination_sejour" id="num_destination_sejour" class="form-control-sejour-create" value="{{ old('num_destination_sejour') }}" required>
            @error('num_destination_sejour')
                <div class="text-danger error-message-sejour-create">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-sejour-create">
            <label for="titresejour" class="form-label-sejour-create">Titre du Séjour</label>
            <input type="text" name="titresejour" id="titresejour" class="form-control-sejour-create" value="{{ old('titresejour') }}" required>
            @error('titresejour')
                <div class="text-danger error-message-sejour-create">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-sejour-create">
            <label for="descriptionsejour" class="form-label-sejour-create">Description</label>
            <textarea name="descriptionsejour" id="descriptionsejour" class="form-control-sejour-create" rows="4" required>{{ old('descriptionsejour') }}</textarea>
            @error('descriptionsejour')
                <div class="text-danger error-message-sejour-create">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-sejour-create">
            <label for="prix_sejour" class="form-label-sejour-create">Prix (€)</label>
            <input type="number" step="0.01" name="prix_sejour" id="prix_sejour" class="form-control-sejour-create" value="{{ old('prix_sejour') }}" required>
            @error('prix_sejour')
                <div class="text-danger error-message-sejour-create">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group-sejour-create">
            <label for="url_photo_sejour" class="form-label-sejour-create">URL de la Photo (facultatif)</label>
            <input type="text" name="url_photo_sejour" id="url_photo_sejour" class="form-control-sejour-create" value="{{ old('url_photo_sejour') }}">
            @error('url_photo_sejour')
                <div class="text-danger error-message-sejour-create">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit-sejour-create">Créer le séjour</button>
    </form>
</div>

@endsection
