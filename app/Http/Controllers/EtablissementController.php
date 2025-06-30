<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Http\Request;
use App\Models\IEF;
use App\Models\InspectionAcademique;

class EtablissementController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Etablissement::query()->with(['inspectionAcademique', 'ief']);

        if ($request->filled('inspection_academique_id')) {
            $query->where('inspection_academique_id', $request->inspection_academique_id);
        }

        if ($request->filled('ief_id')) {
            $query->where('ief_id', $request->ief_id);
        }

        $etablissements = $query->orderBy('nom')->paginate(10);
        $ias = \App\Models\InspectionAcademique::orderBy('nom')->get();
        $iefs = \App\Models\Ief::orderBy('nom')->get();

        return view('parametrage.etablissements.index', compact('etablissements', 'ias', 'iefs'));
    }


    public function create()
    {
        $ias = \App\Models\InspectionAcademique::orderBy('nom')->get();
        $iefs = \App\Models\Ief::orderBy('nom')->get();
        return view('parametrage.etablissements.create', compact('ias', 'iefs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'region' => 'nullable|string|max:100',
            'departement' => 'nullable|string|max:100',
            'inspection_academique_id' => 'nullable|exists:inspection_academiques,id',
            'ief_id' => 'nullable|exists:iefs,id',
        ]);

        Etablissement::create($request->all());

        return redirect()->route('etablissements.index')->with('success', 'Établissement ajouté avec succès.');
    }


    public function edit(Etablissement $etablissement)
    {
        $ias = InspectionAcademique::orderBy('nom')->get();
        $iefs = IEF::orderBy('nom')->get(); // ← ajout obligatoire

        return view('parametrage.etablissements.edit', compact('etablissement', 'ias', 'iefs'));
    }

    public function update(Request $request, Etablissement $etablissement)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'region' => 'nullable|string|max:100',
            'departement' => 'nullable|string|max:100',
            'inspection_academique_id' => 'nullable|exists:inspection_academiques,id',
            'ief_id' => 'nullable|exists:iefs,id',
        ]);

        $etablissement->update($request->only(['nom', 'inspection_academique_id', 'ief_id']));

        return redirect()->route('etablissements.index')->with('success', 'Établissement mis à jour.');
    }



    public function destroy(Etablissement $etablissement)
    {
        $etablissement->delete();
        return redirect()->route('etablissements.index')->with('success', 'Établissement supprimé.');
    }


}
