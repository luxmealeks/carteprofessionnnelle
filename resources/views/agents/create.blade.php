@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0"><i class="bi bi-person-plus me-2"></i>Enrôlement d'un Agent</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('agents.store') }}" method="POST" enctype="multipart/form-data" id="agent-form">
                @csrf

                <div class="row g-3">
                    <!-- Section 1: Informations de base -->
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3 text-primary">Informations Personnelles</h5>

                        <div class="mb-3">
                            <label class="form-label">Matricule <span class="text-danger">*</span></label>
                            <input type="text" name="matricule" class="form-control" required maxlength="20">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">CIN <span class="text-danger">*</span></label>
                            <input type="text" name="cin" class="form-control" required maxlength="20">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date de Naissance</label>
                            <input type="date" name="date_naissance" class="form-control">
                        </div>
                    </div>

                    <!-- Section 2: Photo et contacts -->
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3 text-primary">Photo & Contacts</h5>

                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/jpeg,image/png">
                            <small class="text-muted">Format: JPEG ou PNG (max 2MB)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                            <input type="tel" name="telephone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea name="adresse" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <!-- Section 3: Informations professionnelles -->
                    <div class="col-12">
                        <h5 class="border-bottom pb-2 mb-3 text-primary">Informations Professionnelles</h5>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Fonction <span class="text-danger">*</span></label>
                                <input type="text" name="fonction" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Corps</label>
                                <select name="corps_id" class="form-select">
                                    <option value="">Sélectionner un corps</option>
                                    @foreach($corps as $corpsItem)
                                        <option value="{{ $corpsItem->id }}">{{ $corpsItem->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Grade</label>
                                <select name="grade_id" class="form-select">
                                    <option value="">Sélectionner un grade</option>
                                    @foreach($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->libelle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Établissement</label>
                                <select name="etablissement_id" class="form-select">
                                    <option value="">Sélectionner un établissement</option>
                                    @foreach($etablissements as $etablissement)
                                        <option value="{{ $etablissement->id }}">{{ $etablissement->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Direction</label>
                                <select name="direction_id" class="form-select">
                                    <option value="">Sélectionner une direction</option>
                                    @foreach($directions as $direction)
                                        <option value="{{ $direction->id }}">{{ $direction->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Inspection Académique <span class="text-danger">*</span></label>
                                <select name="inspection_academique_id" class="form-select" required>
                                    <option value="">Sélectionner une IA</option>
                                    @foreach($inspectionAcademiques as $ia)
                                        <option value="{{ $ia->id }}">{{ $ia->nom }}</option>
                                    @endforeach
                                </select>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">Service central</label>
                                        <input type="text" name="iden" class="form-control">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Statut Photo</label>
                                        <select name="statut_photo" class="form-select">
                                            <option value="en_attente">En attente</option>
                                            <option value="validee">Validée</option>
                                            <option value="rejetee">Rejetée</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Motif de rejet photo (si applicable)</label>
                                        <input type="text" name="motif_rejet_photo" class="form-control">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('agents.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Enregistrer l'agent
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validation du fichier photo
        document.querySelector('input[name="photo"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Le fichier est trop volumineux (max 2MB)');
                    this.value = '';
                }
                if (!['image/jpeg', 'image/png'].includes(file.type)) {
                    alert('Seuls les formats JPEG et PNG sont acceptés');
                    this.value = '';
                }
            }
        });

        // Validation du formulaire
        document.getElementById('agent-form').addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs obligatoires');
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    .form-label {
        font-weight: 500;
    }
    .card-header {
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
    .is-invalid {
        border-color: #dc3545;
    }
</style>
@endpush
