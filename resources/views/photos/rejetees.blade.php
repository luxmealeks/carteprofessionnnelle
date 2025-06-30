@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white">
            <h2 class="mb-0">
                <i class="bi bi-x-circle-fill me-2"></i>Photos Rejetées
            </h2>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($agents->isEmpty())
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>Aucune photo rejetée.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="100">Photo</th>
                                <th>Informations Agent</th>
                                <th>Affectation</th>
                                <th>Motif du rejet</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agents as $agent)
                            <tr>
                                <td>
                                    <div class="photo-preview">
                                        <img src="{{ Storage::url($agent->photo) }}"
                                             alt="Photo de {{ $agent->prenom }} {{ $agent->nom }}"
                                             class="img-thumbnail"
                                             data-bs-toggle="modal"
                                             data-bs-target="#photoModal{{ $agent->id }}">
                                    </div>
                                </td>
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
                                <td>
                                    <div class="fw-medium">{{ $agent->etablissement->nom ?? 'Non affecté' }}</div>
                                    <div class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i> {{ $agent->inspectionAcademique->nom ?? '' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="text-danger small">{{ $agent->motif_rejet_photo }}</span>
                                </td>
                                <td>
                                    <!-- Bouton pour réintégration -->
                                    <button class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reintegrerModal{{ $agent->id }}">
                                        <i class="bi bi-arrow-clockwise me-1"></i> Réintégrer
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal photo -->
                            <div class="modal fade" id="photoModal{{ $agent->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Photo de {{ $agent->prenom }} {{ $agent->nom }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ Storage::url($agent->photo) }}" class="img-fluid" alt="Photo agent">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal confirmation réintégration -->
                            <div class="modal fade" id="reintegrerModal{{ $agent->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('photos.reintegrer', $agent) }}" class="modal-content">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Réintégrer la photo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                            Voulez-vous vraiment réintégrer cette photo pour une nouvelle validation ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Confirmer
                                            </button>
                                        </div>
                                    </form>
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
</style>
@endpush
