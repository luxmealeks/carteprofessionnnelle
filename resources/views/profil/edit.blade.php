@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>Modifier mon profil
                    </h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
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
                                <input type="file" class="form-control" id="photo" name="photo">
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom complet</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ old('name', $user->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                           value="{{ old('phone', $user->phone) }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary me-md-2">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
