<?php

$directory = __DIR__ . '/database/migrations';
$files = scandir($directory);
$corps_migrations = [];

foreach ($files as $file) {
    if (str_contains($file, '.php')) {
        $content = file_get_contents($directory . '/' . $file);

        if (str_contains($content, "'corps'") || str_contains($content, '"corps"')) {
            $hasLibelle = str_contains($content, "'libelle'") || str_contains($content, '"libelle"');

            $corps_migrations[] = [
                'fichier' => $file,
                'libelle_present' => $hasLibelle ? '✅ OUI' : '❌ NON',
            ];
        }
    }
}

if (empty($corps_migrations)) {
    echo "✅ Aucun fichier de migration ne concerne la table `corps`.\n";
    exit;
}

echo "🔍 Résultat de la recherche dans les fichiers de migration :\n\n";
foreach ($corps_migrations as $migration) {
    echo "- {$migration['fichier']} → libelle : {$migration['libelle_present']}\n";
}
