@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h2 class="mb-0">
                <i class="bi bi-printer me-2"></i>
                Générer un lot pour {{ $ia->nom }} ({{ $ia->region }})
            </h2>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('lots.traiterGeneration', $ia->id) }}" id="generationForm">
                @csrf
                <input type="hidden" name="inspection_academique_id" value="{{ $ia->id }}">

                <div class="mb-3">
                    <label for="lot_label">Nom du lot *</label>
                    <input type="text" name="lot_label" id="lot_label" required
                           class="form-control" value="{{ old('lot_label', 'LOT-'.strtoupper(Str::slug($ia->nom)).'-'.date('ymd')) }}">
                </div>

                <div class="mb-3">
                    <label>Choisir les agents *</label>
                    @foreach($agents as $agent)
                    <tr>
                        <td>{{ $agent->nom_complet }}</td>
                        <td>{{ $agent->etablissement->nom }}</td>
                        <td>{{ $agent->photo_validee ? 'Validé' : 'Non validé' }}</td>
                        <td>{{ $agent->lot ? 'Déjà dans lot '.$agent->lot->numero : 'Disponible' }}</td>
                    </tr>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-success">Générer le PDF</button>
            </form>


        </div>

        <div class="mb-3">
            <label>Agents disponibles ({{ $agents->count() }})</label>

            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>Nom</th>
                        <th>Établissement</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agents as $agent)
                    <tr>
                        <td>
                            <input type="checkbox"
                                   name="agents[]"
                                   value="{{ $agent->id }}"
                                   class="agent-checkbox"
                                   @if($agent->lot) disabled @endif>
                        </td>
                        <td>{{ $agent->nom_complet }}</td>
                        <td>{{ $agent->etablissement->nom }}</td>
                        <td>
                            @if($agent->lot)
                                <span class="badge bg-warning">Déjà dans lot</span>
                            @else
                                <span class="badge bg-success">Disponible</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sélection/désélection globale
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.agent-checkbox:not(:disabled)').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Validation du formulaire
    document.getElementById('generationForm').addEventListener('submit', function(e) {
        const checked = document.querySelectorAll('.agent-checkbox:checked').length;
        if(checked === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un agent');
            return false;
        }
    });
});
/* document.addEventListener('DOMContentLoaded', function() {
    // Sélection/désélection de tous les agents
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.agent-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Validation avant soumission
    document.getElementById('generationForm').addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.agent-checkbox:checked');
        if(checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un agent');
            return false;
        }

        // Désactiver le bouton pour éviter les doubles clics
        document.getElementById('generateBtn').disabled = true;
        document.getElementById('generateBtn').innerHTML =
            '<i class="bi bi-hourglass me-1"></i> Génération en cours...';
    });
}); */
</script>
@endpush
