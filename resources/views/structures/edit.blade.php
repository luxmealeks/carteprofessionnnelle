@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Modifier la structure</h2>

    <form action="{{ route('structures.update', $structure) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $structure->nom) }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" name="type" class="form-control" value="{{ old('type', $structure->type) }}">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('structures.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
