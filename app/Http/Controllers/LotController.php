<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Agent;
use App\Models\InspectionAcademique;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class LotController extends Controller
{
    /**
     * Affiche la liste des lots avec filtres
     */
    public function index(Request $request)
    {
        $query = Lot::with(['inspectionAcademique', 'agents'])
                  ->withCount('agents');

        // Recherche
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhereHas('inspectionAcademique', function($q) use ($search) {
                      $q->where('nom', 'like', "%{$search}%");
                  });
            });
        }

        // Filtre par région
        if ($request->has('region')) {
            $query->whereHas('inspectionAcademique', function($q) use ($request) {
                $q->where('region', $request->input('region'));
            });
        }

        // Tri
        switch ($request->input('sort')) {
            case 'oldest': $query->oldest(); break;
            case 'numero': $query->orderBy('numero'); break;
            default: $query->latest();
        }

        $lots = $query->paginate(10);

        return view('lots.index', compact('lots'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $ias = InspectionAcademique::orderBy('nom')->get();
        return view('lots.create', compact('ias'));
    }

    /**
     * Enregistre un nouveau lot
     */
    public function store(Request $request)
    {
        $request->validate([
            'inspection_academique_id' => 'required|exists:inspection_academiques,id',
        ]);

        $inspection = InspectionAcademique::findOrFail($request->inspection_academique_id);

        $numero = 'LOT-' . strtoupper(Str::slug($inspection->nom)) . '-' . now()->format('ymd-His');

        Lot::create([
            'numero' => $numero,
            'inspection_academique_id' => $inspection->id,
            'region' => $inspection->region,
            'label' => $request->input('lot_label', 'Lot ' . now()->format('d/m/Y')),
        ]);

        return redirect()->route('lots.index')->with('success', 'Lot créé avec succès: ' . $numero);
    }

    /**
     * Affiche le formulaire de génération
     */
    public function genererForm(Request $request)
    {
        $ia_id = $request->input('ia_id');

        if (!$ia_id) {
            return view('lots.choisir', [
                'ias' => InspectionAcademique::orderBy('nom')->get(),
                'lots' => Lot::withCount('agents')->latest()->paginate(10)
            ]);
        }

        $agents = Agent::whereHas('etablissement', function($q) use ($ia_id) {
                $q->where('inspection_academique_id', $ia_id);
            })
            ->where('photo_validee', true)
            ->whereDoesntHave('lots')
            ->with('etablissement')
            ->get();

        return view('lots.generer', [
            'ia' => InspectionAcademique::findOrFail($ia_id),
            'agents' => $agents
        ]);
    }

    /**
     * Génère un nouveau lot
     */
    public function generer(Request $request)
    {
        $validated = $request->validate([
            'lot_label' => 'required|string|max:255',
            'agents' => 'required|array|min:1',
            'agents.*' => 'exists:agents,id'
        ]);

        $ia = InspectionAcademique::findOrFail($request->inspection_academique_id);

        $numero = 'LOT-' . strtoupper(Str::slug($ia->nom)) . '-' . now()->format('ymd-His');

        $lot = Lot::create([
            'numero' => $numero,
            'inspection_academique_id' => $ia->id,
            'region' => $ia->region,
            'label' => $request->lot_label,
        ]);

        // Assignation des agents via la relation many-to-many
        $lot->agents()->attach($request->agents);

        return redirect()->route('lots.show', $lot->id)
               ->with('success', 'Lot généré avec succès');
    }

    /**
     * Exporte le PDF d'un lot
     */
    public function exportPDF($id)
    {
        $lot = Lot::with(['agents', 'inspectionAcademique'])->findOrFail($id);
        $pdf = Pdf::loadView('lots.pdf', compact('lot'));
        return $pdf->download('lot_' . $lot->numero . '.pdf');
    }

    /**
     * Affiche les détails d'un lot
     */
    public function show($id)
    {
        $lot = Lot::with(['inspectionAcademique', 'agents'])->findOrFail($id);
        return view('lots.show', compact('lot'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $lot = Lot::with(['agents'])->findOrFail($id);
        $ias = InspectionAcademique::orderBy('nom')->get();
        $agents = Agent::where('inspection_academique_id', $lot->inspection_academique_id)
                     ->where('photo_validee', true)
                     ->get();

        return view('lots.edit', compact('lot', 'ias', 'agents'));
    }

    /**
     * Met à jour un lot existant
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'inspection_academique_id' => 'required|exists:inspection_academiques,id',
            'lot_label' => 'required|string|max:255',
            'agents' => 'required|array|min:1',
            'agents.*' => 'exists:agents,id'
        ]);

        $lot = Lot::findOrFail($id);
        $lot->update([
            'inspection_academique_id' => $request->inspection_academique_id,
            'label' => $request->lot_label,
        ]);

        // Synchronisation des agents via la relation many-to-many
        $lot->agents()->sync($request->agents);

        return redirect()->route('lots.show', $lot->id)
               ->with('success', 'Lot mis à jour avec succès');
    }

    /**
     * Supprime un lot
     */
    public function destroy(Lot $lot)
    {
        try {
            // Détache tous les agents du lot
            $lot->agents()->detach();

            // Supprime le lot
            $lot->delete();

            return redirect()->route('lots.index')
                ->with('success', 'Le lot a été supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la suppression : '.$e->getMessage());
        }
    }

    /**
     * Imprime un lot existant
     */
    public function imprimer($lot_id)
    {
        $lot = Lot::with(['agents', 'inspectionAcademique'])->findOrFail($lot_id);

        if ($lot->agents->isEmpty()) {
            return redirect()->back()
                   ->with('error', 'Ce lot ne contient aucun agent à imprimer.');
        }
        if (is_null($lot->date_generation)) {
            $lot->date_generation = now();
            $lot->save();
        }

        $pdf = Pdf::loadView('lots.pdf', [
            'lot' => $lot,
            'agents' => $lot->agents,
            'inspection' => $lot->inspectionAcademique
        ]);

        return $pdf->stream('cartes_' . $lot->numero . '.pdf');
    }

    /**
     * Affiche la vue de sélection pour génération
     */
    public function choisir()
    {
        $lots = Lot::withCount('agents')->latest()->paginate(10);
        $ias = InspectionAcademique::orderBy('nom')->get();
        return view('lots.choisir', compact('lots', 'ias'));
    }
}
