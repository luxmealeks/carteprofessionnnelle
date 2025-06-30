@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-people-fill me-2"></i> Liste des Agents Enrôlés</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('agents.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i> Nouvel Agent
            </a>
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="bi bi-upload me-1"></i> Importer
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Photo</th>
                            <th>Matricule</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>CIN</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Fonction</th>
                            <th>Établissement</th>
                            <th>Direction</th>
                            <th>IA</th>
                            <th>Corps</th>
                            <th>Grade</th>
                            <th>Statut Photo</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($agents as $agent)
                        <tr>
                            <!-- Photo -->
                            <td class="text-center">
                                @if($agent->photo)
                                    <img src="{{ asset('storage/'.$agent->photo) }}"
                                         alt="Photo agent"
                                         class="rounded-circle border"
                                         width="50"
                                         height="50"
                                         style="object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px;">
                                        <i class="bi bi-person text-muted" style="font-size: 1.5rem;"></i>
                                    </div>
                                @endif
                            </td>

                            <!-- Données principales -->
                            <td>{{ $agent->matricule }}</td>
                            <td>{{ $agent->prenom }}</td>
                            <td>{{ $agent->nom }}</td>
                            <td>{{ $agent->cin ?? 'N/A' }}</td>
                            <td>{{ $agent->email ?? 'N/A' }}</td>
                            <td>{{ $agent->telephone ?? 'N/A' }}</td>
                            <td>{{ $agent->fonction ?? 'N/A' }}</td>

                            <!-- Relations -->
                            <td>{{ $agent->etablissement->nom ?? 'N/A' }}</td>
                            <td>{{ $agent->direction->nom ?? 'N/A' }}</td>
                            <td>{{ $agent->inspectionAcademique->nom ?? 'N/A' }}</td>
                            <td>{{ $agent->corps->libelle ?? 'N/A' }}</td>
                            <td>{{ $agent->grade->libelle ?? 'N/A' }}</td>

                            <!-- Statut Photo -->
                            <td>
                                @if($agent->statut_photo === 'validee')
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="bi bi-check-circle-fill me-1"></i> Validée
                                    </span>
                                @elseif($agent->statut_photo === 'rejetee')
                                    <span class="badge bg-danger bg-opacity-10 text-danger">
                                        <i class="bi bi-x-circle-fill me-1"></i> Rejetée
                                    </span>
                                    @if($agent->motif_rejet_photo)
                                        <div class="text-muted small mt-1">{{ Str::limit($agent->motif_rejet_photo, 20) }}</div>
                                    @endif
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning">
                                        <i class="bi bi-hourglass-split me-1"></i> En attente
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('agents.show', $agent->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('agents.edit', $agent->id) }}"
                                       class="btn btn-sm btn-outline-secondary"
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($agent->statut_photo === 'en_attente')
                                        <form action="{{ route('agents.validerPhoto', $agent->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-success"
                                                    title="Valider photo">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center py-4 text-muted">
                                <i class="bi bi-people me-2"></i> Aucun agent enregistré
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

           <!-- Avant la pagination -->
</div> <!-- Fermeture précédente de div -->
@if($agents->hasPages())
    <div class="card-footer bg-white border-top">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center py-2">
            <div class="mb-2 mb-md-0">
                <p class="small text-muted mb-0">
                    <span class="fw-medium">{{ $agents->firstItem() }}</span> à
                    <span class="fw-medium">{{ $agents->lastItem() }}</span> sur
                    <span class="fw-medium">{{ $agents->total() }}</span> agents
                </p>
            </div>
            <div class="pagination-wrapper">
                {{ $agents->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
@endif

<!-- Modal d'importation -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <!-- Contenu du modal -->
</div>
        </div>
    </div>
</div>

<!-- Import Modal (identique à votre version originale) -->
<!-- Modal d'importation des agents -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('agents.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel"><i class="bi bi-upload me-2"></i> Importer un fichier Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="fichier" class="form-label">Fichier Excel (.xlsx, .xls, .csv)</label>
                    <input type="file" name="fichier" id="fichier" class="form-control" required accept=".xlsx,.xls,.csv">
                </div>
                <div class="alert alert-info small">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    Assurez-vous que le fichier respecte le format attendu : matricule, prénom, nom, etc.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-cloud-arrow-up me-1"></i> Importer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

<style>
    .table-hover tbody tr {
        transition: background-color 0.2s;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    .table th {
        white-space: nowrap;
        font-size: 0.85rem;
    }
    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }
    .badge {
        padding: 0.35em 0.5em;
        font-size: 0.75rem;
    }
</style>
