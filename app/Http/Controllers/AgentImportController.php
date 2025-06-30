<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Agent;
use App\Models\Etablissement;
use App\Models\InspectionAcademique;
use App\Models\Corps;
use App\Models\Grade;
use Illuminate\Support\Str;

class AgentImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'fichier' => 'required|mimes:xlsx,xls,csv'
        ]);

        $fichier = $request->file('fichier');
        $rows = Excel::toArray([], $fichier)[0];

        // Ignorer l'en-tête
        unset($rows[0]);

        foreach ($rows as $row) {
            if (!isset($row[0]) || empty(trim($row[0]))) continue;

            // Lecture et nettoyage des données
            $matricule = trim($row[0]);
            $prenoms = trim($row[1] ?? '');
            $nom = trim($row[2] ?? '');
            $corps_libelle = strtoupper(trim($row[3] ?? ''));
            $fonction = trim($row[4] ?? '');
            $telephone = trim($row[5] ?? '');
            $email = trim($row[6] ?? '');
            $etab_nom = trim($row[7] ?? '');
            $systeme = trim($row[8] ?? '');
            $iden = trim($row[9] ?? '');
            $ia_code = strtoupper(trim($row[10] ?? ''));
            $grade_libelle = strtoupper(trim($row[11] ?? ''));

            // Vérification des champs obligatoires
            if (empty($etab_nom)) {
                \Log::warning("Établissement vide pour matricule : $matricule");
                continue;
            }

            // Inspection Académique
            $inspection = InspectionAcademique::firstOrCreate(
                ['code' => $ia_code],
                ['nom' => $ia_code ?: 'Non spécifié', 'region' => 'À définir']
            );

            // Établissement
            $etablissement = Etablissement::updateOrCreate(
                ['nom' => $etab_nom],
                ['inspection_academique_id' => $inspection->id]
            );

            // Corps - avec valeur par défaut si vide
            $corps_libelle = !empty(trim($corps_libelle)) ? $corps_libelle : 'NON SPECIFIE';

            try {
                $corps = Corps::firstOrCreate(
                    ['nom' => $corps_libelle],
                    ['nom' => $corps_libelle]
                );
            } catch (\Exception $e) {
                // Fallback si jamais ça plante
                $corps = Corps::where('nom', 'NON SPECIFIE')->first();

                if (!$corps) {
                    $corps = Corps::create(['nom' => 'NON SPECIFIE']);
                }

                \Log::warning("Erreur création corps pour $corps_libelle: ".$e->getMessage());
            }


           // Dans la partie gestion des grades
           // Dans la partie gestion des grades
$grade_libelle = !empty(trim($grade_libelle)) ? $grade_libelle : 'NON SPECIFIE';

try {
    $grade = Grade::firstOrCreate(
        ['nom' => $grade_libelle],
        ['nom' => $grade_libelle]
    );
} catch (\Exception $e) {
    // Fallback en cas d'échec
    $grade = Grade::where('nom', 'NON SPECIFIE')->first();

    if (!$grade) {
        $grade = Grade::create(['nom' => 'NON SPECIFIE']);
    }

    \Log::warning("Erreur création grade pour $grade_libelle: ".$e->getMessage());
}

            // Agent
            Agent::updateOrCreate(
                ['matricule' => $matricule],
                [
                    'prenom' => $prenoms ?: 'Non spécifié',
                    'nom' => $nom ?: 'Non spécifié',
                    'fonction' => $fonction ?: 'Non spécifiée',
                    'email' => $email,
                    'telephone' => $telephone,
                    'etablissement_id' => $etablissement->id,
                    'inspection_academique_id' => $inspection->id,
                    'iden' => $iden,
                    'corps_id' => $corps?->id,
                    'grade_id' => $grade->id, // Toujours un grade maintenant
                    'statut_photo' => 'en_attente',
                    'photo' => null,
                ]
            );
        }

        return redirect()->route('agents.index')
               ->with('success', 'Importation terminée avec succès.');
    }
}
