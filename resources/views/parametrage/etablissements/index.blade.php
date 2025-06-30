@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-building me-2"></i>Liste des établissements
        </h1>
        <a href="{{ route('etablissements.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Ajouter
        </a>
    </div>

    <!-- Filtres -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('etablissements.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="inspection_academique_id" class="form-label">Inspection Académique</label>
                        <select name="inspection_academique_id" id="inspection_academique_id" class="form-select">
                            <option value="">Toutes les IA</option>
                            @foreach($ias as $ia)
                                <option value="{{ $ia->id }}"
                                    {{ request('inspection_academique_id') == $ia->id ? 'selected' : '' }}>
                                    {{ $ia->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="ief_id" class="form-label">IEF</label>
                        <select name="ief_id" id="ief_id" class="form-select">
                            <option value="">Tous les IEF</option>
                            @if(request('inspection_academique_id'))
                                @foreach($iefs->where('inspection_academique_id', request('inspection_academique_id')) as $ief)
                                    <option value="{{ $ief->id }}"
                                        {{ request('ief_id') == $ief->id ? 'selected' : '' }}>
                                        {{ $ief->nom }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-funnel me-1"></i> Filtrer
                        </button>
                        <a href="{{ route('etablissements.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Inspection Académique</th>
                            <th>IEF</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($etablissements as $etab)
                        <tr>
                            <td>{{ $etab->nom }}</td>
                            <td>
                                @if($etab->inspectionAcademique)
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        {{ $etab->inspectionAcademique->nom }}
                                    </span>
                                @else
                                    <span class="text-muted">Non affecté</span>
                                @endif
                            </td>
                            <td>
                                @if($etab->ief)
                                    <span class="badge bg-light text-dark">
                                        {{ $etab->ief->nom }}
                                    </span>
                                @else
                                    <span class="text-muted">Non affecté</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('etablissements.edit', $etab->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('etablissements.destroy', $etab->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="tooltip"
                                                title="Supprimer"
                                                onclick="return confirm('Confirmer la suppression ?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="bi bi-building text-muted" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">Aucun établissement trouvé</p>
                                @if(request()->any())
                                    <a href="{{ route('etablissements.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                        Réinitialiser les filtres
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($etablissements->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            Affichage de {{ $etablissements->firstItem() }} à {{ $etablissements->lastItem() }} sur {{ $etablissements->total() }}
                        </div>
                        <div>
                            {{ $etablissements->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dynamique des IEF en fonction de l'IA sélectionnée
    const iaSelect = document.getElementById('inspection_academique_id');
    const iefSelect = document.getElementById('ief_id');

    iaSelect.addEventListener('change', function() {
        const iaId = this.value;
        iefSelect.innerHTML = '<option value="">Tous les IEF</option>';

        if(iaId) {
            fetch(`/api/iefs-by-ia/${iaId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(ief => {
                        const option = document.createElement('option');
                        option.value = ief.id;
                        option.textContent = ief.nom;
                        iefSelect.appendChild(option);
                    });
                });
        }
    });
});
</script>
@endpush
@endsection
