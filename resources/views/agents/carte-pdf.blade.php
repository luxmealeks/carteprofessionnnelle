<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            width: 242.65pt;
            height: 153.07pt;
        }
        body {
            font-family: Arial, sans-serif;
        }
        .carte {
            position: relative;
            width: 100%;
            height: 100%;
        }
        .background {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .photo-qr {
    position: absolute;
    top: 60pt;        /* Avant : 56pt → ajusté vers le haut */
    left: 10pt;       /* Garde le même décalage horizontal */
    width: 50pt;
    height: 90pt;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    z-index: 2;
}

.photo {
    width: 56.7pt;     /* 2 cm */
    height: 65.6pt;    /* 2.67 cm - ratio 3:4 */
    object-fit: cover;
}

.qr {
    width: 25pt;
    height: 25pt;
}


        .infos {
            position: absolute;
            top: 60pt;
            left: 130pt;
            width: 100pt;
            text-align: center;
            font-size: 9pt;
            line-height: 1.3;
            z-index: 2;
        }
        .infos strong {
            font-size: 11pt;
        }
        .signature {
            position: absolute;
            bottom: 10pt;
            right: 10pt;
            width: 60pt;
        }
    </style>
</head>
<body>

<!-- RECTO -->
<div class="carte">
    <img class="background" src="{{ $rectoPath }}" alt="Recto">

    <div class="photo-qr">
        <img class="photo" src="{{ $photoPath }}" alt="Photo">
        <img class="qr" src="{{ $qrCode }}" alt="QR Code">
    </div>

    <div class="infos">
        <strong>{{ $agent->prenom }} {{ $agent->nom }}</strong><br>
        Matricule : {{ $agent->matricule }}<br>
        Fonction : {{ $agent->fonction }}<br>
        {{ $agent->etablissement->nom ?? $agent->direction->nom ?? '' }}<br>
        IA : {{ $agent->inspectionAcademique->nom ?? '' }}
    </div>

    <img class="signature" src="{{ $signaturePath }}" alt="Cachet Ministère">
</div>

<!-- SAUT DE PAGE POUR VERSO -->
<div style="page-break-after: always;"></div>

<!-- VERSO -->
<div class="carte">
    <img class="background" src="{{ $versoPath }}" alt="Verso">
</div>

</body>
</html>
