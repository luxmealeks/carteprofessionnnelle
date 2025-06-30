@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Ajouter un établissement</h1>

    <form action="{{ route('etablissements.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l’établissement</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ia_id" class="form-label">Inspection Académique (IA)</label>
            <select name="ia_id" id="ia_id" class="form-select" required>
                <option value="">-- Sélectionnez --</option>
                @foreach ($ias as $ia)
                    <option value="{{ $ia->id }}">{{ $ia->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="ief_id" class="form-label">Inspection de l’Éducation et de la Formation (IEF) (optionnel)</label>
            <select name="ief_id" id="ief_id" class="form-select">
                <option value="">-- Aucun --</option>
                @foreach ($iefs as $ief)
                    <option value="{{ $ief->id }}">{{ $ief->nom }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('etablissements.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
