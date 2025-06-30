@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-person-circle me-2"></i>Mon Profil
                        </h4>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-pencil-square me-1"></i> Modifier
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="avatar-container mb-3">
                                @if($user->photo)
                                    <img src="{{ asset('storage/'.$user->photo) }}"
                                         alt="Photo de profil"
                                         class="img-thumbnail rounded-circle"
                                         width="150" height="150">
                                @else
                                    <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center bg-light text-muted"
                                         style="width: 150px; height: 150px;">
                                        <i class="bi bi-person" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="mb-3">{{ $user->name }}</h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Email :</strong></p>
                                    <p>{{ $user->email }}</p>
                                </div>

                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Rôle :</strong></p>
                                    <p>
                                        <span class="badge bg-primary">
                                            {{ $user->role->name ?? 'Utilisateur' }}
                                        </span>
                                    </p>
                                </div>

                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Date d'inscription :</strong></p>
                                    <p>{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                </div>

                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Dernière connexion :</strong></p>
                                    <p>
                                        @if($user->last_login_at)
                                            {{ $user->last_login_at->diffForHumans() }}
                                        @else
                                            Jamais connecté
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section informations supplémentaires -->
                    <div class="border-top pt-3">
                        <h5 class="mb-3">
                            <i class="bi bi-info-circle me-2"></i>Informations complémentaires
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Téléphone :</strong></p>
                                <p>{{ $user->phone ?? 'Non renseigné' }}</p>
                            </div>

                            <div class="col-md-6">
                                <p class="mb-1"><strong>Service :</strong></p>
                                <p>{{ $user->department ?? 'Non renseigné' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar-placeholder {
        border: 1px dashed #dee2e6;
    }
    .card-header {
        padding: 1.25rem 1.5rem;
    }
</style>
@endsection
