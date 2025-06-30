@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">
                <i class="bi bi-images me-2"></i>Validation des Photos d'Agents
            </h2>
        </div>

        <div class="card-body">
            @if($agents->isEmpty())
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>Aucune photo en attente de validation
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="100">Photo</th>
                                <th>Informations Agent</th>
                                <th>Affectation</th>
                                <th width="250">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agents as $agent)
                            <tr>
                                <!-- Colonne Photo -->
                                <td>
                                    <div class="photo-preview">
                                        <img src="{{ Storage::url($agent->photo) }}"
                                             alt="Photo de {{ $agent->prenom }} {{ $agent->nom }}"
                                             class="img-thumbnail"
                                             data-bs-toggle="modal"
                                             data-bs-target="#photoModal{{ $agent->id }}">
                                    </div>
                                </td>

                                <!-- Colonne Informations -->
                                <td>
                                    <h5 class="mb-1">{{ $agent->prenom }} {{ $agent->nom }}</h5>
                                    <div class="text-muted small">
                                        <div><i class="bi bi-person-badge me-1"></i> {{ $agent->matricule }}</div>
                                        <div><i class="bi bi-telephone me-1"></i> {{ $agent->telephone }}</div>
                                        @if($agent->email)
                                            <div><i class="bi bi-envelope me-1"></i> {{ $agent->email }}</div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Colonne Affectation -->
                                <td>
                                    <div class="fw-medium">{{ $agent->etablissement->nom ?? 'Non affecté' }}</div>
                                    <div class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i> {{ $agent->inspectionAcademique->nom ?? '' }}
                                    </div>
                                </td>

                                <!-- Colonne Actions -->
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('photos.valider', $agent) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-circle me-1"></i> Valider
                                            </button>
                                        </form>

                                        <button class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejetModal{{ $agent->id }}">
                                            <i class="bi bi-x-circle me-1"></i> Rejeter
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal pour la photo en grand -->
                            <div class="modal fade" id="photoModal{{ $agent->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Photo de {{ $agent->prenom }} {{ $agent->nom }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ Storage::url($agent->photo) }}" class="img-fluid" alt="Photo agent">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal pour le rejet -->
                            <div class="modal fade" id="rejetModal{{ $agent->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('photos.rejeter', $agent) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Rejeter la photo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="motif{{ $agent->id }}" class="form-label">Motif du rejet</label>
                                                    <textarea class="form-control" id="motif{{ $agent->id }}"
                                                              name="motif_rejet_photo" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-x-circle me-1"></i> Confirmer le rejet
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .photo-preview img {
        width: 80px;
        height: 100px;
        object-fit: cover;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .photo-preview img:hover {
        transform: scale(1.05);
    }
    .table th {
        white-space: nowrap;
    }
</style>
@endpush
