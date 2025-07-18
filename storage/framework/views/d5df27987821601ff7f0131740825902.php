<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte - <?php echo e($agent->prenom); ?> <?php echo e($agent->nom); ?></title>
    <style>
        @page {
            size: 85.6mm 54mm;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .page {
            width: 85.6mm;
            height: 54mm;
            position: relative;
            page-break-after: always;
            overflow: hidden;
        }

        .full-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .photo-container {
            position: absolute;
            top: 21.2mm;
            left: 4.3mm;
            width: 21mm;
            height: 27mm;
            z-index: 10;
        }

        .photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 0.1mm solid #d5d3d3;
        }

        .qr-code {
            position: absolute;
            top: 4mm;
            right: 4mm;
            width: 20mm;
            height: 20mm;
            z-index: 10;
        }

        .qr-code svg {
            width: 100%;
            height: auto;
            display: block;
        }

        .info-container {
            position: absolute;
            top: 21mm;
            left: 28mm;
            font-size: 3.2mm;
            line-height: 1;
            z-index: 10;
        }

        .info-field {
            margin-bottom: 1mm;
        }

        .info-label {
            margin-right: 1mm;
        }

        .info-value {
            font-weight: bold;
        }

        .cachet {
            position: absolute;
            bottom: 8mm;
            right: 12mm;
            width: 28mm;
            opacity: 1;
            z-index: 12;
        }

        .footer {
            position: absolute;
            bottom: 3mm;
            left: 58mm;
            font-size: 3mm;
            z-index: 10;
        }

        .verso-text.top {
            position: absolute;
            bottom: 20mm;
            left: 5mm;
            right: 5mm;
            font-size: 2.8mm;
            text-align: center;
            z-index: 10;
            line-height: 1.3;
        }

        .verso-footer {
            position: absolute;
            bottom: 4mm;
            left: 5mm;
            right: 5mm;
            font-size: 2mm;
            text-align: center;
            z-index: 10;
            line-height: 1.2;
            font-weight: bold;
        }

        .verso-footer hr {
            border: none;
            border-top: 0.2mm solid #333;
            margin-bottom: 1mm;
            width: 100%;
        }
    </style>
</head>
<body>

<!-- RECTO -->
<div class="page">
    <img class="full-bg" src="<?php echo e($rectoPath); ?>" alt="Recto">

    <div class="photo-container">
        <img class="photo" src="<?php echo e($photoPath); ?>" alt="Photo">
    </div>

    <div class="qr-code">
        <?php echo $qrCode; ?>

    </div>

    <div class="info-container">
        <div class="info-field">
            <span class="info-label">Prénom:</span>
            <span class="info-value"><?php echo e($agent->prenom); ?></span>
        </div>
        <div class="info-field">
            <span class="info-label">Nom:</span>
            <span class="info-value"><?php echo e($agent->nom); ?></span>
        </div>
        <div class="info-field">
            <span class="info-label">Matricule:</span>
            <span class="info-value"><?php echo e($agent->matricule); ?></span>
        </div>
        <div class="info-field">
            <span class="info-label">Fonction:</span>
            <span class="info-value"><?php echo e($agent->fonction); ?></span>
        </div>
    </div>

    <img class="cachet" src="<?php echo e($signaturePath); ?>" alt="Cachet Ministère">

    <div class="footer">
        Délivrée le: <span class="date-value"><?php echo e(\Carbon\Carbon::now()->format('m/Y')); ?></span>
    </div>
</div>

<!-- VERSO -->
<div class="page" style="page-break-after: avoid;">
    <img class="full-bg" src="<?php echo e($versoPath); ?>" alt="Verso">

  

  
</div>

</body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/carteprofessionnnelle/resources/views/agents/carte-pdf.blade.php ENDPATH**/ ?>