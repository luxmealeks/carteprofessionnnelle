<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 10px; }
        body { font-family: sans-serif; font-size: 12px; }
        .card {
            width: 260px;
            height: 170px;
            border: 1px solid #ccc;
            float: left;
            margin: 5px;
            padding: 10px;
            position: relative;
        }
        .photo {
            width: 60px;
            height: 80px;
            object-fit: cover;
            float: right;
        }
        .info {
            font-size: 11px;
        }
        .qr {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 50px;
        }
    </style>
</head>
<body>
    @foreach($agents as $agent)
        <div class="card">
            <div class="info">
                <strong>{{ $agent->prenom }} {{ $agent->nom }}</strong><br>
                Matricule: {{ $agent->matricule }}<br>
                CIN: {{ $agent->cin }}<br>
                Fonction: {{ $agent->fonction }}<br>
                Etablissement: {{ $agent->etablissement->nom ?? '-' }}<br>
                Inspection: {{ $agent->inspectionAcademique->nom ?? '-' }}
            </div>
            @if($agent->photo)
                <img src="{{ public_path('storage/' . $agent->photo) }}" class="photo">
            @endif
            <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(80)->generate($agent->matricule)) }}" class="qr">
        </div>
    @endforeach
</body>
</html>
