<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index()
    {
        $agents = Agent::with('etablissement')->whereNotNull('photo')->get();
        return view('photos.index', compact('agents'));
    }

    public function valider(Agent $agent)
    {
        $agent->update([
            'statut_photo' => 'validee',
            'motif_rejet_photo' => null,
        ]);

        return back()->with('success', 'Photo validée.');
    }

    public function rejeter(Request $request, Agent $agent)
    {
        $request->validate([
            'motif_rejet_photo' => 'required|string|max:255',
        ]);

        $agent->update([
            'statut_photo' => 'rejetee',
            'motif_rejet_photo' => $request->motif_rejet_photo,
        ]);

        return back()->with('success', 'Photo rejetée.');
    }
    public function validees()
{
    $agents = Agent::with(['etablissement', 'inspectionAcademique'])
        ->where('statut_photo', 'validee')
        ->get();

    return view('photos.validees', compact('agents'));
}

public function rejetees()
{
    $agents = Agent::with(['etablissement', 'inspectionAcademique'])
        ->where('statut_photo', 'rejetee')
        ->get();

    return view('photos.rejetees', compact('agents'));
}

public function reintegrer(Agent $agent)
{
    $agent->update([
        'statut_photo' => 'en_attente',
        'motif_rejet_photo' => null,
    ]);

    return back()->with('success', 'Photo réintégrée pour validation.');
}


}
