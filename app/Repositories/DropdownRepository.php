<?php

namespace App\Repositories;

use App\Models\Corps;
use App\Models\Grade;
use App\Models\Etablissement;
use App\Models\Direction;
use App\Models\InspectionAcademique;

class DropdownRepository
{
    public function getAgentFormData()
    {
        return [
            'corps' => Corps::orderBy('libelle')->get(),
            'grades' => Grade::orderBy('libelle')->get(),
            'etablissements' => Etablissement::orderBy('nom')->get(),
            'directions' => Direction::orderBy('nom')->get(),
            'inspectionAcademiques' => InspectionAcademique::orderBy('nom')->get()
        ];
    }
}
