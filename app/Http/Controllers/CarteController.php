<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CarteController extends Controller
{
    /**
     * Génère un PDF de toutes les cartes validées d'une IA donnée.
     *
     * @param int $iaId
     * @return \Illuminate\Http\Response
     */
    public function generateAll($iaId)
    {
        $agents = Agent::where('inspection_academique_id', $iaId)
            ->where('statut_photo', 'validee')
            ->get();

        if ($agents->isEmpty()) {
            return redirect()->back()->with('error', 'Aucune carte validée trouvée pour cette IA.');
        }

        $pdf = Pdf::loadView('cartes.pdf_all', compact('agents'))->setPaper('A4', 'portrait');

        return $pdf->download("Cartes_Validées_IA_$iaId.pdf");
    }
}
