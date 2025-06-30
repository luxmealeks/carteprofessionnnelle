@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">
        Génération des cartes pour l'Inspection d'Académie :
        <strong>{{ $ia->nom ?? 'Non spécifié' }}</strong>
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Erreur :</strong> {{ $errors->first() }}
        </div>
    @endif

    @if($agents->isEmpty())
        <div class="alert alert-info">
            Aucun agent avec une photo validée trouvé pour cette inspection.
        </div>
    @else
    <form method="POST" action="{{ route('lots.imprimer', $ia->id) }}">
        @csrf

        <!-- Champ caché pour l'ID de l'inspection -->
        <input type="hidden" name="ia_id" value="{{ $ia->id }}">

        <!-- Champ pour le nom du lot -->
        <div class="mb-3">
            <label for="lot_label" class="form-label">Nom du lot <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="lot_label" name="lot_label"
                   placeholder="Ex : IA-Tambacounda-Lot-001" required>
        </div>

        <!-- Liste des agents -->
        <div class="mb-3">
            <label class="form-label">Agents à inclure ({{ $agents->count() }} agents)</label>
            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                @foreach($agents as $agent)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="agents[]" value="{{ $agent->id }}"
                               id="agent{{ $agent->id }}" checked>
                        <label class="form-check-label" for="agent{{ $agent->id }}">
                            {{ $agent->nom_complet }} — {{ $agent->matricule }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-printer-fill me-1"></i> Générer le PDF des cartes
        </button>
    </form>

    @endif
</div>
@endsection
