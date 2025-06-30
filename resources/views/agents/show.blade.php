@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-1">
                <i class="bi bi-person-badge me-2 text-primary"></i>Fiche Agent
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('agents.index') }}">Agents</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $agent->prenom }} {{ $agent->nom }}</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil-square me-1"></i> Modifier
            </a>
            <a href="{{ route('agents.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Colonne Photo -->
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    @if($agent->photo)
                        <img src="{{ asset('storage/' . $agent->photo) }}"
                             class="img-fluid rounded-circle mb-3 border"
                             alt="Photo de {{ $agent->prenom }} {{ $agent->nom }}"
                             style="width: 180px; height: 180px; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light rounded-circle mb-3"
                             style="width: 180px; height: 180px; margin: 0 auto;">
                            <i class="bi bi-person text-muted" style="font-size: 3rem;"></i>
                        </div>
                    @endif

                    <h4 class="mb-1">{{ $agent->prenom }} {{ $agent->nom }}</h4>
                    <p class="text-muted mb-2">{{ $agent->matricule }}</p>

                    <div class="mb-3">
                        @if($agent->statut_photo === 'validee')
                            <span class="badge bg-success bg-opacity-10 text-success py-2 px-3">
                                <i class="bi bi-check-circle-fill me-1"></i> Photo validée
                            </span>
                        @elseif($agent->statut_photo === 'rejetee')
                            <span class="badge bg-danger bg-opacity-10 text-danger py-2 px-3">
                                <i class="bi bi-x-circle-fill me-1"></i> Photo rejetée
                            </span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning py-2 px-3">
                                <i class="bi bi-hourglass-split me-1"></i> En attente
                            </span>
                        @endif
                    </div>

                    @if($agent->statut_photo === 'rejetee' && $agent->motif_rejet_photo)
                        <div class="alert alert-danger small mb-0">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            <strong>Motif de rejet :</strong> {{ $agent->motif_rejet_photo }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Colonne Informations -->
        <div class="col-md-8 col-lg-9">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2 text-primary"></i>Informations personnelles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Matricule</label>
                            <p class="mb-0">{{ $agent->matricule }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">CIN</label>
                            <p class="mb-0">{{ $agent->cin ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Nom</label>
                            <p class="mb-0">{{ $agent->nom }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Prénom</label>
                            <p class="mb-0">{{ $agent->prenom }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Date de naissance</label>
                            <p class="mb-0">{{ $agent->date_naissance ? $agent->date_naissance->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Email</label>
                            <p class="mb-0">
                                @if($agent->email)
                                    <a href="mailto:{{ $agent->email }}" class="text-decoration-none">{{ $agent->email }}</a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Téléphone</label>
                            <p class="mb-0">
                                @if($agent->telephone)
                                    <a href="tel:{{ $agent->telephone }}" class="text-decoration-none">{{ $agent->telephone }}</a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="small text-muted mb-1">Adresse</label>
                            <p class="mb-0">{{ $agent->adresse ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">
                        <i class="bi bi-briefcase me-2 text-primary"></i>Informations professionnelles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Fonction</label>
                            <p class="mb-0">{{ $agent->fonction ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Service central (IDEN)</label>
                            <p class="mb-0">{{ $agent->iden ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Établissement</label>
                            <p class="mb-0">{{ $agent->etablissement->nom ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Direction</label>
                            <p class="mb-0">{{ $agent->direction->nom ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Inspection Académique</label>
                            <p class="mb-0">{{ $agent->inspectionAcademique->nom ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Corps</label>
                            <p class="mb-0">{{ $agent->corps->nom ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">Grade</label>
                            <p class="mb-0">{{ $agent->grade->nom ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions supplémentaires -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            @if($agent->statut_photo === 'validee')
                <a href="{{ route('agents.generateCard', $agent->id) }}" class="btn btn-primary me-2">
                    <i class="bi bi-person-badge me-1"></i> Générer la carte
                </a>
            @endif

            @if($agent->statut_photo === 'en_attente')
                <form action="{{ route('agents.validerPhoto', $agent->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success me-2">
                        <i class="bi bi-check-circle me-1"></i> Valider la photo
                    </button>
                </form>
            @endif
        </div>

        <div>
            <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?')">
                    <i class="bi bi-trash me-1"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border-radius: 0.5rem;
        border: none;
    }

    .card-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    label.small {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
</style>
@endpush
@endsection
