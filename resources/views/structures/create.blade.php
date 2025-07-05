@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Ajouter une structure</h2>

    <form action="{{ route('structures.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type (ex: direction, service)</label>
            <input type="text" name="type" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('structures.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
