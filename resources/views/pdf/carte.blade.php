<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .carte { border: 1px solid #000; width: 85mm; height: 54mm; padding: 10px; }
        .photo { float: right; width: 30mm; height: 40mm; border: 1px solid #000; }
    </style>
</head>
<body>
    <div class="carte">
        <div class="photo">
            <img src="{{ storage_path('app/public/photos/'.$agent->photo) }}" style="width:100%; height:100%;">
        </div>
        <p><strong>Nom :</strong> {{ $agent->nom }}</p>
        <p><strong>Prénom :</strong> {{ $agent->prenom }}</p>
        <p><strong>Matricule :</strong> {{ $agent->matricule }}</p>
        <p><strong>Fonction :</strong> {{ $agent->fonction }}</p>
        <p><strong>Établissement :</strong> {{ $agent->etablissement->nom }}</p>
    </div>
</body>
</html>
