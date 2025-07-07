<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cartes - <?php echo e($lot->label); ?></title>
    <style>
         /* Définit la taille exacte d’une page PDF au format badge (carte bancaire) */
        @page {
            size: 85.6mm 54mm;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
        }

        /* 🔹 Définit chaque carte (recto ou verso) comme une "page" PDF  */

        .page {
            width: 85.6mm;
            height: 54mm;
            position: relative;
            page-break-after: always;
            overflow: hidden;
        }
        /* 🔹 Applique une image de fond (recto ou verso) sur toute la surface de la carte. */
        .full-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .qr-code {
            width: 100%;
            height: 35%;
        }
     /*    🔹 Bloc contenant matricule, nom, prénom, fonction : 
     Positionné à droite de la carte (après la photo)
     top: 20mm = aligné verticalement avec la photo
     left:28=aligner le blc de texte par rapport de la photo
     font-size: 3.2mm = texte lisible imprimé
     line-height: 1.4 = bonne lisibilité */

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
            /* font-weight: bold; */
            margin-right: 1mm;
        }
        .info-value {
            font-weight: bold;
         }
        .cachet {
            position: absolute;
            bottom: 8mm;
            right: 12mm;         /* ou left: 4mm si tu préfères à gauche */
            width: 28mm;
            opacity: 1;        /* effet semi-transparent de cachet officiel */
            z-index: 12;
        }
        .date-value {
            font-weight: bold;
        }
        .qr-code svg {
    width: 100%;
    height: auto;
    display: block;
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
    text-align: center;       /* ✅ Centré horizontalement */
    z-index: 10;
    line-height: 1.3;
}

.verso-footer {
    position: absolute;
    bottom: 4mm;
    left: 5mm;
    right: 5mm;
    font-size: 2mm;        /* ✅ Petite taille conservée */
    text-align: center;
    z-index: 10;
    line-height: 1.2;
    font-weight: bold;     /* ✅ Ajoute le gras */
}


.verso-footer hr {
    border: none;
    border-top: 0.2mm solid #333;
    margin-bottom: 1mm;       /* ✅ Espace réduit */
    width: 100%;
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


    </style>
</head>
<body>

<?php
    $recto = base64_encode(file_get_contents(public_path('storage/template/recto.png')));
    $verso = base64_encode(file_get_contents(public_path('storage/template/verso.png')));
    $cachet = base64_encode(file_get_contents(public_path('storage/images/cachet_ministre.png')));

    
?>

<?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <!-- RECTO -->
    <div class="page" style="page-break-after: always;">
    <img class="full-bg" src="data:image/png;base64,<?php echo e($recto); ?>">
    <!-- ... contenu recto ... -->
    <div class="photo-container">
        <?php
            $photoBase64 = $agent->photo ? (function($photoPath){
                $cleanPath = str_replace('public/', '', $photoPath);
                $fullPath = public_path('storage/' . $cleanPath);
                if (file_exists($fullPath)) {
                    $mime = mime_content_type($fullPath);
                    $data = base64_encode(file_get_contents($fullPath));
                    return "data:$mime;base64,$data";
                }
                return null;
            })($agent->photo) : null;
        ?>

        <?php if($photoBase64): ?>
            <img class="photo" src="<?php echo e($photoBase64); ?>">
        <?php else: ?>
            <div class="photo"></div>
        <?php endif; ?>

        <div class="qr-code">
            <?php echo \QrCode::size(100)->format('svg')->generate(route('agents.show', $agent->id)); ?>

        </div>
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

    <img src="data:image/png;base64,<?php echo e($cachet); ?>" class="cachet">

    <div class="footer">
        Délivrée le: <span class="date-value"><?php echo e(\Carbon\Carbon::now()->format('m/Y')); ?></span>
    </div>
</div>


    <!-- VERSO -->
    <div class="page" <?php if($loop->last): ?> style="page-break-after: avoid;" <?php else: ?> style="page-break-after: always;" <?php endif; ?>>
        <img class="full-bg" src="data:image/png;base64,<?php echo e($verso); ?>">
    
        <div class="verso-text top">
            Carte strictement personnelle, propriété du Ministère de la Formation Professionnelle et Technique (MFPT).<br>
            Toute personne trouvant cette carte est priée de bien vouloir l'adresser à la Direction des ressources humaines du dit ministère.
        </div>
    
        <div class="verso-footer">
            Sphère ministérielle, arrondissement 2, Bâtiment C, Diamniadio, Dakar Sénégal.<br>
            Téléphone : 33 865 70 80 • Site : https://formation.gouv.sn
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


</body>
</html><?php /**PATH /Applications/MAMP/htdocs/carteprofessionnnelle/resources/views/lots/pdf.blade.php ENDPATH**/ ?>