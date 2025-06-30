@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-people-fill me-2 text-primary"></i>Gestion des Agents
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Agents</li>
                </ol>
            </nav>
        </div>

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
    @include('partials.alerts')

    @if(request()->anyFilled(['search', 'statut', 'affectation', 'sort']))
<div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
    <strong>Filtres actifs :</strong>
    @foreach(request()->all() as $key => $value)
        @if(in_array($key, ['search', 'statut', 'affectation', 'sort']) && !empty($value))
            <span class="badge bg-primary me-1">
                {{ $key }}: {{ $value }}
            </span>
        @endif
    @endforeach
    <a href="{{ route('agents.index') }}" class="btn btn-sm btn-outline-light ms-2">
        <i class="bi bi-x-lg"></i> Réinitialiser
    </a>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

    <!-- Filters Section -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body py-3">
            <form action="{{ route('agents.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label small text-muted">Recherche</label>
                        <div class="input-group">
                            <input type="text" name="search" id="search" class="form-control form-control-sm"
                                   placeholder="Nom, matricule..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="statut" class="form-label small text-muted">Statut</label>
                        <select name="statut" id="statut" class="form-select form-select-sm">
                            <option value="">Tous</option>
                            <option value="validee" {{ request('statut') == 'validee' ? 'selected' : '' }}>Validés</option>
                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="rejetee" {{ request('statut') == 'rejetee' ? 'selected' : '' }}>Rejetés</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="affectation" class="form-label small text-muted">Affectation</label>
                        <select name="affectation" id="affectation" class="form-select form-select-sm">
                            <option value="">Toutes</option>
                            @foreach($etablissements as $etablissement)
                                <option value="etablissement_{{ $etablissement->id }}" {{ request('affectation') == 'etablissement_'.$etablissement->id ? 'selected' : '' }}>
                                    {{ $etablissement->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="sort" class="form-label small text-muted">Trier par</label>
                        <select name="sort" id="sort" class="form-select form-select-sm">
                            <option value="nom_asc" {{ request('sort') == 'nom_asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                            <option value="nom_desc" {{ request('sort') == 'nom_desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                            <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Plus anciens</option>
                            <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Plus récents</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-sm btn-primary me-2">
                            <i class="bi bi-funnel me-1"></i> Filtrer
                        </button>
                        <a href="{{ route('agents.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Agents Table -->
    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-body p-0">
            <!-- Agents Table -->
<div class="card shadow-sm border-0 overflow-hidden">
    <div class="card-body p-0">
        <!-- Message aucun résultat -->
        @if($agents->isEmpty() && request()->anyFilled(['search', 'statut', 'affectation']))
        <div class="alert alert-warning m-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            Aucun agent ne correspond à vos critères de recherche.
            <a href="{{ route('agents.index') }}" class="alert-link">Réinitialiser les filtres</a>
        </div>
        @endif


    </div>
</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60" class="text-center">Photo</th>
                            <th>Matricule</th>
                            <th>Nom & Prénom</th>
                            <th>CIN</th>
                            <th>Contact</th>
                            <th>Fonction</th>
                            <th>Corps</th>
                            <th>Grade</th>
                            <th>Affectation</th>
                            <th>Statut</th>
                            <th width="140" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agents as $agent)
                        <tr>
                            <!-- Photo -->
                            <td class="text-center">
                                <div class="avatar-wrapper">
                                    @if($agent->photo)
                                        <img src="{{ asset('storage/'.$agent->photo) }}"
                                             alt="Photo de {{ $agent->prenom }} {{ $agent->nom }}"
                                             class="avatar-img"
                                             data-bs-toggle="modal"
                                             data-bs-target="#photoModal{{ $agent->id }}">
                                    @else
                                        <div class="avatar-placeholder">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Identification -->
                            <td>
                                <span class="fw-semibold">{{ $agent->matricule }}</span>
                            </td>

                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-semibold">{{ $agent->nom }}</span>
                                    <small class="text-muted">{{ $agent->prenom }}</small>
                                </div>
                            </td>

                            <td>{{ $agent->cin ?? 'N/A' }}</td>

                            <!-- Contact -->
                            <td>
                                <div class="d-flex flex-column">
                                    @if($agent->email)
                                        <a href="mailto:{{ $agent->email }}" class="text-primary text-decoration-none">
                                            <small><i class="bi bi-envelope me-1"></i>{{ $agent->email }}</small>
                                        </a>
                                    @endif
                                    @if($agent->telephone)
                                        <small><i class="bi bi-telephone me-1"></i>{{ $agent->telephone }}</small>
                                    @endif
                                </div>
                            </td>

                            <!-- Fonction -->
                            <td>
                                <span class="d-block">{{ $agent->fonction ?? 'N/A' }}</span>
                                <small class="text-muted">
                                    {{ $agent->corps->nom ?? '' }} {{ $agent->grade->nom ?? '' }}
                                </small>
                            </td>
                            <!-- Corps -->
                            <td>{{ $agent->corps->nom ?? 'N/A' }}</td>

                            <!-- Grade -->
                            <td>{{ $agent->grade->nom ?? 'N/A' }}</td>


                            <!-- Affectation -->
                            <td>
                                <div class="d-flex flex-column">
                                    <span>{{ $agent->etablissement->nom ?? $agent->direction->nom ?? 'N/A' }}</span>
                                    <small class="text-muted">{{ $agent->inspectionAcademique->nom ?? '' }}</small>
                                </div>
                            </td>

                            <!-- Statut -->
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
                                        <div class="text-muted small mt-1" data-bs-toggle="tooltip" title="{{ $agent->motif_rejet_photo }}">
                                            {{ Str::limit($agent->motif_rejet_photo, 20) }}
                                        </div>
                                    @endif
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning">
                                        <i class="bi bi-hourglass-split me-1"></i> En attente
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('agents.show', $agent->id) }}"
                                       class="btn btn-icon btn-sm btn-outline-primary"
                                       data-bs-toggle="tooltip"
                                       title="Voir détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('agents.edit', $agent->id) }}"
                                       class="btn btn-icon btn-sm btn-outline-secondary"
                                       data-bs-toggle="tooltip"
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($agent->statut_photo === 'en_attente')
                                        <form action="{{ route('agents.validerPhoto', $agent->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-icon btn-sm btn-outline-success"
                                                    data-bs-toggle="tooltip"
                                                    title="Valider photo">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($agent->statut_photo === 'validee')
                                        <a href="{{ route('agents.generateCard', $agent->id) }}"
                                           class="btn btn-icon btn-sm btn-outline-info"
                                           data-bs-toggle="tooltip"
                                           title="Générer la carte">
                                            <i class="bi bi-person-badge"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Photo Modal -->
                        <div class="modal fade" id="photoModal{{ $agent->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Photo de {{ $agent->prenom }} {{ $agent->nom }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('storage/'.$agent->photo) }}"
                                             class="img-fluid rounded"
                                             alt="Photo de {{ $agent->prenom }} {{ $agent->nom }}">
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ asset('storage/'.$agent->photo) }}"
                                           download="photo_{{ $agent->matricule }}.jpg"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download me-1"></i> Télécharger
                                        </a>
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-people fs-1 text-muted mb-3"></i>
                                    <h5 class="text-muted">Aucun agent trouvé</h5>
                                    <a href="{{ route('agents.create') }}" class="btn btn-primary mt-2">
                                        <i class="bi bi-person-plus me-1"></i> Ajouter un agent
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($agents->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center py-2">
                        <div class="mb-2 mb-md-0">
                            <p class="small text-muted mb-0">
                                Affichage de <span class="fw-semibold">{{ $agents->firstItem() }}</span> à
                                <span class="fw-semibold">{{ $agents->lastItem() }}</span> sur
                                <span class="fw-semibold">{{ $agents->total() }}</span> agents
                            </p>
                        </div>
                        <div>
                            {{ $agents->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('agents.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="bi bi-upload me-2"></i> Importer des agents
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="fichier" class="form-label">Fichier Excel</label>
                    <input type="file" name="fichier" id="fichier" class="form-control" required
                           accept=".xlsx,.xls,.csv" data-accept=".xlsx,.xls,.csv">
                    <div class="form-text">Formats acceptés: .xlsx, .xls, .csv</div>
                </div>
                <div class="alert alert-info small mb-0">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    Téléchargez notre <a href="{{ asset('templates/import_agents.xlsx') }}" class="alert-link">modèle Excel</a>
                    pour garantir un import correct.
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

@push('styles')
<style>
    /* Table styling */
    .table {
        --bs-table-hover-bg: rgba(13, 110, 253, 0.03);
        margin-bottom: 0;
    }

    .table th {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
        background-color: #f8fafc;
        border-bottom-width: 1px;
    }

    .table td {
        font-size: 0.875rem;
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }

    /* Avatar styling */
    .avatar-wrapper {
        width: 40px;
        height: 40px;
        margin: 0 auto;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .avatar-wrapper:hover {
        transform: scale(1.1);
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 1px solid #dee2e6;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 50%;
        color: #6c757d;
        font-size: 1.25rem;
    }

    /* Badge styling */
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
        padding: 0.35em 0.65em;
    }

    /* Action buttons */
    .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .table-responsive {
            border: 0;
        }

        .table thead {
            display: none;
        }

        .table tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }

        .table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid #f8f9fa;
        }

        .table td::before {
            content: attr(data-label);
            font-weight: 600;
            margin-right: 1rem;
            color: #495057;
            font-size: 0.8rem;
        }

        .table td:last-child {
            border-bottom: 0;
        }

        .avatar-wrapper {
            margin: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Activer les tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Validation du fichier d'import
        document.getElementById('fichier').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const acceptedTypes = this.getAttribute('data-accept').split(',');

            if (file && !acceptedTypes.some(type => file.name.endsWith(type))) {
                alert('Veuillez sélectionner un fichier Excel (.xlsx, .xls) ou CSV');
                this.value = '';
            }
        });

        // Confirmation pour les actions sensibles
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cet agent ?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endpush
