@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier l'agent : {{ $agent->prenom }} {{ $agent->nom }}</h2>

    <form method="POST" action="{{ route('agents.update', $agent->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="matricule" class="form-label">Matricule</label>
                <input type="text" name="matricule" id="matricule" class="form-control" value="{{ old('matricule', $agent->matricule) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="cin" class="form-label">CIN</label>
                <input type="text" name="cin" id="cin" class="form-control" value="{{ old('cin', $agent->cin) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom', $agent->prenom) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $agent->nom) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $agent->email) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', $agent->telephone) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="fonction" class="form-label">Fonction</label>
                <input type="text" name="fonction" id="fonction" class="form-control" value="{{ old('fonction', $agent->fonction) }}">
            </div>


            <div class="col-md-6 mb-3">
                <label for="corps_id" class="form-label">Corps</label>
                <select name="corps_id" id="corps_id" class="form-select">
                    @foreach($corps as $cor)
                    <option value="{{ $cor->id }}" {{ $agent->corps_id == $cor->id ? 'selected' : '' }}>
                        {{ $cor->nom }}
                    </option>
                @endforeach

                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="grade_id" class="form-label">Grade</label>
                <select name="grade_id" id="grade_id" class="form-select">
                    @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ $agent->grade_id == $grade->id ? 'selected' : '' }}>
                        {{ $grade->nom }}
                    </option>
                @endforeach

                </select>
            </div>


            <div class="col-md-6 mb-3">
                <label for="iden" class="form-label">Service central)</label>
                <input type="text" name="iden" id="iden" class="form-control" value="{{ old('iden', $agent->iden) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label for="etablissement_id" class="form-label">Établissement</label>
                <select name="etablissement_id" id="etablissement_id" class="form-select">
                    @foreach(App\Models\Etablissement::all() as $etab)
                        <option value="{{ $etab->id }}" {{ $agent->etablissement_id == $etab->id ? 'selected' : '' }}>
                            {{ $etab->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="inspection_academique_id" class="form-label">Inspection Académique</label>
                <select name="inspection_academique_id" id="inspection_academique_id" class="form-select">
                    @foreach(App\Models\InspectionAcademique::all() as $ia)
                        <option value="{{ $ia->id }}" {{ $agent->inspection_academique_id == $ia->id ? 'selected' : '' }}>
                            {{ $ia->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="statut_photo" class="form-label">Statut Photo</label>
                <select name="statut_photo" id="statut_photo" class="form-select">
                    <option value="en_attente" {{ $agent->statut_photo === 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="validee" {{ $agent->statut_photo === 'validee' ? 'selected' : '' }}>Validée</option>
                    <option value="rejetee" {{ $agent->statut_photo === 'rejetee' ? 'selected' : '' }}>Rejetée</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label for="motif_rejet_photo" class="form-label">Motif Rejet (si applicable)</label>
                <input type="text" name="motif_rejet_photo" id="motif_rejet_photo" class="form-control" value="{{ old('motif_rejet_photo', $agent->motif_rejet_photo) }}">
            </div>
        </div>

        <!-- Champ pour transmettre l'image recadrée en base64 -->
        <input type="hidden" name="cropped_photo" id="cropped_photo">

        <div class="mb-3">
            <label for="new_photo" class="form-label">Remplacer la photo</label>
            <input type="file" id="new_photo" accept="image/*" class="form-control">
        </div>

        <div id="crop-container" class="mb-3" style="display: none;">
            <p class="text-muted">Recadrez la photo avant de sauvegarder :</p>
            <div style="max-width: 100%;">
                <img id="preview-image" style="max-width: 100%;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Enregistrer les modifications</button>
    </form>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    const input = document.getElementById('new_photo');
    const previewImage = document.getElementById('preview-image');
    const cropContainer = document.getElementById('crop-container');
    const croppedPhotoInput = document.getElementById('cropped_photo');

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

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
            reader.readAsDataURL(blob);
            reader.onloadend = () => {
                croppedPhotoInput.value = reader.result;
            };
        }, 'image/jpeg');
    }
});

            };
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
