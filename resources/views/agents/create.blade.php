@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0"><i class="bi bi-person-plus me-2"></i>Nouvel Agent</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('agents.store') }}" method="POST" enctype="multipart/form-data" id="agent-form">
                @csrf

                <div class="row g-3">
                    <!-- Section 1: Informations de base -->
                    <div class="col-md-6">
                        <h5 class="border-bottom pb-2 mb-3 text-primary">Informations Personnelles</h5>

                        <div class="mb-3">
                            <label class="form-label">Matricule</label>
                            <input type="text" name="matricule" class="form-control" value="{{ old('matricule') }}" maxlength="20">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">CIN</label>
                            <input type="text" name="cin" class="form-control" value="{{ old('cin') }}" maxlength="20">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date de Naissance</label>
                            <input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance') }}">
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
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                            <input type="tel" name="telephone" class="form-control" value="{{ old('telephone') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <textarea name="adresse" class="form-control" rows="2">{{ old('adresse') }}</textarea>
                        </div>
                    </div>

                    <!-- Section 3: Informations professionnelles -->
                    <div class="col-12">
                        <h5 class="border-bottom pb-2 mb-3 text-primary">Informations Professionnelles</h5>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Fonction <span class="text-danger">*</span></label>
                                <input type="text" name="fonction" class="form-control" value="{{ old('fonction') }}" required>
                            </div>

                            <!-- Corps -->
                            <div class="col-md-4">
                                <label class="form-label">Corps</label>
                                <select name="corps_id" class="form-select select-enhanced">
                                    <option value="">Sélectionner un corps</option>
                                    @foreach($corps as $corpsItem)
                                        <option value="{{ $corpsItem->id }}" {{ old('corps_id') == $corpsItem->id ? 'selected' : '' }}>
                                            {{ $corpsItem->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Grade -->
                            <div class="col-md-4">
                                <label class="form-label">Grade</label>
                                <select name="grade_id" class="form-select select-enhanced">
                                    <option value="">Sélectionner un grade</option>
                                    @foreach($grades as $grade)
                                        <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>
                                            {{ $grade->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <!-- Structure -->
                            <div class="col-md-4">
                                <label for="structure_id" class="form-label">Structure</label>
                                <select name="structure_id" class="form-select" id="structure-select">
                                    <option value="">-- Aucune structure --</option>
                                    @foreach($structures as $structure)
                                        <option value="{{ $structure->id }}" {{ old('structure_id') == $structure->id ? 'selected' : '' }}>
                                            {{ $structure->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Inspection Académique -->
                            <div class="col-md-4" id="inspection-wrapper">
                                <label class="form-label">Inspection Académique</label>
                                <select name="inspection_academique_id" id="inspection-select" class="form-select">
                                    <option value="">Sélectionner une IA</option>
                                    @foreach($inspectionAcademiques as $ia)
                                        <option value="{{ $ia->id }}" {{ old('inspection_academique_id') == $ia->id ? 'selected' : '' }}>
                                            {{ $ia->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Établissement -->
                            <div class="col-md-4" id="etablissement-wrapper">
                                <label class="form-label">Établissement</label>
                                <select name="etablissement_id" id="etablissement-select" class="form-select">
                                    <option value="">Sélectionner un établissement</option>
                                    @foreach($etablissements as $etablissement)
                                        <option value="{{ $etablissement->id }}" {{ old('etablissement_id') == $etablissement->id ? 'selected' : '' }}>
                                            {{ $etablissement->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                       {{--  <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Service central</label>
                                <input type="text" name="iden" class="form-control" value="{{ old('iden') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Statut Photo</label>
                                <select name="statut_photo" class="form-select">
                                    <option value="en_attente" {{ old('statut_photo') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                    <option value="validee" {{ old('statut_photo') === 'validee' ? 'selected' : '' }}>Validée</option>
                                    <option value="rejetee" {{ old('statut_photo') === 'rejetee' ? 'selected' : '' }}>Rejetée</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Motif de rejet photo (si applicable)</label>
                                <input type="text" name="motif_rejet_photo" class="form-control" value="{{ old('motif_rejet_photo') }}">
                            </div>
                        </div> --}}
                    </div>
                </div>

                <!-- Champ pour transmettre l'image recadrée en base64 -->
                <input type="hidden" name="cropped_photo" id="cropped_photo">

                <!-- Conteneur pour le recadrage d'image -->
                <div id="crop-container" class="mb-3 mt-3" style="display: none;">
                    <p class="text-muted">Recadrez la photo avant de sauvegarder :</p>
                    <div style="max-width: 100%;">
                        <img id="preview-image" style="max-width: 100%;">
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('agents.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Créer l'Agent
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
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
    #preview-image {
        max-height: 400px;
    }
    
    /* Styles pour les selects */
    select.form-select, 
    select.form-select option {
        background-color: #fff !important;
        color: #212529 !important;
    }
    
    select.form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ----- Gestion du crop d'image -----
    const inputPhoto = document.querySelector('input[name="photo"]');
    const previewImage = document.getElementById('preview-image');
    const cropContainer = document.getElementById('crop-container');
    const croppedPhotoInput = document.getElementById('cropped_photo');
    let cropper;

    if (inputPhoto) {
        inputPhoto.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024 || !['image/jpeg', 'image/png'].includes(file.type)) {
                alert('Seuls les fichiers JPEG ou PNG de moins de 2 Mo sont autorisés.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                cropContainer.style.display = 'block';

                previewImage.onload = function () {
                    if (cropper) cropper.destroy();

                    cropper = new Cropper(previewImage, {
                        aspectRatio: NaN,
                        viewMode: 1,
                        autoCropArea: 0.8,
                        movable: true,
                        zoomable: true,
                        scalable: true,
                        cropBoxResizable: true,
                        cropBoxMovable: true,
                        cropend() {
                            cropper.getCroppedCanvas().toBlob(blob => {
                                const reader = new FileReader();
                                reader.onloadend = () => {
                                    croppedPhotoInput.value = reader.result;
                                };
                                reader.readAsDataURL(blob);
                            }, 'image/jpeg');
                        }
                    });
                };
            };
            reader.readAsDataURL(file);
        });
    }

    // ----- Validation des champs obligatoires -----
    document.getElementById('agent-form').addEventListener('submit', function (e) {
        let isValid = true;
        this.querySelectorAll('[required]').forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires.');
        }
    });

    // ----- Masquer IA + établissement si structure sélectionnée -----
    const structureSelect = document.getElementById('structure-select');
    const inspectionWrapper = document.getElementById('inspection-wrapper');
    const etablissementWrapper = document.getElementById('etablissement-wrapper');

    function toggleVisibility() {
        const hasStructure = structureSelect && structureSelect.value;
        inspectionWrapper.style.display = hasStructure ? 'none' : 'block';
        etablissementWrapper.style.display = hasStructure ? 'none' : 'block';

        const inspectionSelect = inspectionWrapper.querySelector('select');
        const etablissementSelect = etablissementWrapper.querySelector('select');

        if (hasStructure) {
            inspectionSelect.removeAttribute('required');
            etablissementSelect.removeAttribute('required');
        } else {
            inspectionSelect.setAttribute('required', 'required');
            etablissementSelect.setAttribute('required', 'required');
        }
    }

    if (structureSelect) {
        structureSelect.addEventListener('change', toggleVisibility);
        toggleVisibility(); // appel initial
    }

    // ----- Chargement dynamique des établissements selon IA -----
    const inspectionSelect = document.getElementById('inspection-select');
    const etablissementSelect = document.getElementById('etablissement-select');

    if (inspectionSelect && etablissementSelect) {
        inspectionSelect.addEventListener('change', function() {
            const iaId = this.value;
            etablissementSelect.innerHTML = '<option value="">Chargement...</option>';
            etablissementSelect.disabled = true;

            if (!iaId) {
                etablissementSelect.innerHTML = '<option value="">Sélectionnez une IA</option>';
                etablissementSelect.disabled = false;
                return;
            }

            const iaData = @json($inspectionAcademiques);
            const selectedIa = iaData.find(ia => ia.id == iaId);
            
            if (selectedIa && selectedIa.etablissements) {
                etablissementSelect.innerHTML = '<option value="">Sélectionner un établissement</option>';
                selectedIa.etablissements.forEach(etab => {
                    const option = new Option(etab.nom, etab.id);
                    etablissementSelect.add(option);
                });

                const prevValue = "{{ old('etablissement_id') }}";
                if (prevValue) etablissementSelect.value = prevValue;

                etablissementSelect.disabled = false;
            } else {
                fetch(`/api/etablissements?inspection_academique_id=${iaId}`, {
                    headers: { 
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erreur réseau');
                    return response.json();
                })
                .then(data => {
                    etablissementSelect.innerHTML = '<option value="">Sélectionner un établissement</option>';
                    if (data.data && data.data.length) {
                        data.data.forEach(etab => {
                            const option = new Option(etab.nom, etab.id);
                            etablissementSelect.add(option);
                        });
                    }

                    const prevValue = "{{ old('etablissement_id') }}";
                    if (prevValue) etablissementSelect.value = prevValue;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    etablissementSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                })
                .finally(() => {
                    etablissementSelect.disabled = false;
                });
            }
        });

        if (inspectionSelect.value) {
            inspectionSelect.dispatchEvent(new Event('change'));
        }
    }
});
</script>
@endpush