<!-- resources/views/lots/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" class="feather feather-plus-circle me-2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="16" />
                            <line x1="8" y1="12" x2="16" y2="12" />
                        </svg>
                        <h4 class="mb-0">Création d'un nouveau lot</h4>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('lots.store') }}" method="POST">
                        @csrf

                        <!-- Numéro du lot généré automatiquement -->
                        <div class="mb-4">
                            <label for="numero" class="form-label fw-bold">Numéro du lot</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-hashtag text-primary"></i>
                                </span>
                                <input type="text" name="numero" id="numero" class="form-control form-control-lg" placeholder="Généré automatiquement" readonly>
                            </div>
                            <small class="form-text text-muted">Généré automatiquement à partir de l’IA sélectionnée.</small>
                        </div>

                        <!-- IA -->
                        <div class="mb-4">
                            <label for="inspection_academique_id" class="form-label fw-bold">Inspection Académique</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-school text-primary"></i></span>
                                <select name="inspection_academique_id" id="inspection_academique_id" class="form-select form-select-lg" required>
                                    <option value="">-- Sélectionnez une inspection --</option>
                                    @foreach($ias as $ia)
                                        <option value="{{ $ia->id }}">{{ $ia->nom }} ({{ $ia->region }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const iaSelect = document.getElementById('inspection_academique_id');
        const numeroInput = document.getElementById('numero');

        iaSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const iaName = selectedOption.text.split('(')[0].trim();
            const now = new Date();
            const dateCode = now.getFullYear().toString().slice(2) +
                             ('0' + (now.getMonth() + 1)).slice(-2) +
                             ('0' + now.getDate()).slice(-2) +
                             '-' + Math.floor(100 + Math.random() * 900);
            const slug = iaName.toUpperCase().replace(/\s+/g, '_').replace(/[^\w\-]/g, '');
            numeroInput.value = `LOT-${slug}-${dateCode}`;
        });
    });
</script>
@endpush
@endsection
