<?php

namespace App\Imports;

use App\Models\Agent;
use App\Models\Etablissement;
use App\Models\Corps;
use App\Models\Grade;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AgentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $etablissement = Etablissement::firstOrCreate([
            'nom' => $row['nom_etablissement'],
        ]);

        $corps = Corps::firstOrCreate([
            'nom' => $row['libelle_corps'],
        ]);

        return new Agent([
            'matricule'      => $row['matricule_enseignant'] ?? null,
            'prenom'         => $row['prenoms_enseignant'] ?? null,
            'nom'            => $row['nom_enseignant'] ?? null,
            'fonction'       => $row['libelle_fonction'] ?? null,
            'telephone'      => $row['mobile_enseignant'] ?? null,
            'email'          => $row['mail_enseignant'] ?? null,
            'iden'           => $row['iden'] ?? null,
            'ia'             => $row['ia'] ?? null,
            'corps_id'       => $corps->id,
            'etablissement_id' => $etablissement->id,
        ]);
        $inspection = InspectionAcademique::firstOrCreate(
            ['code' => $ia_code],
            ['nom' => $ia_code, 'region' => 'À définir']
        );

    }
}
