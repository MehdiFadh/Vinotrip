@extends('layouts.app')

@section('content')

<div class="container">
        <h1>Mon Profil</h1>

        <form action="{{ route('client.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $client->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $client->email) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>

@endsection