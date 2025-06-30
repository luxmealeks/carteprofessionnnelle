@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifier un établissement</h1>

    <form action="{{ route('etablissements.update', $etablissement->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l’établissement</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $etablissement->nom) }}" required>
        </div>

        <div class="mb-3">
            <label for="ia_id" class="form-label">Inspection Académique (IA)</label>
            <select name="ia_id" id="ia_id" class="form-select">
                <option value="">-- Choisir une IA --</option>
                @foreach ($ias as $ia)
                    <option value="{{ $ia->id }}" {{ old('ia_id', $etablissement->ia_id) == $ia->id ? 'selected' : '' }}>
                        {{ $ia->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="ief_id" class="form-label">IEF</label>
            <select name="ief_id" id="ief_id" class="form-select">
                <option value="">-- Choisir une IEF --</option>
                @foreach ($iefs as $ief)
                    <option value="{{ $ief->id }}" {{ old('ief_id', $etablissement->ief_id) == $ief->id ? 'selected' : '' }}>
                        {{ $ief->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
        <a href="{{ route('etablissements.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
