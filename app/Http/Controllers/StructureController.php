<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Structure;

class StructureController extends Controller
{
    /**
     * Affiche la liste des structures.
     */
    public function index()
    {
        $structures = Structure::orderBy('nom')->get();
        return view('structures.index', compact('structures'));
    }

    /**
     * Affiche le formulaire de création.
     */
    public function create()
    {
        return view('structures.create');
    }

    /**
     * Enregistre une nouvelle structure.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
        ]);

        Structure::create($validated);

        return redirect()->route('structures.index')->with('success', 'Structure créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition.
     */
    public function edit(Structure $structure)
    {
        return view('structures.edit', compact('structure'));
    }

    /**
     * Met à jour une structure existante.
     */
    public function update(Request $request, Structure $structure)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
        ]);

        $structure->update($validated);

        return redirect()->route('structures.index')->with('success', 'Structure mise à jour avec succès.');
    }

    /**
     * Supprime une structure.
     */
    public function destroy(Structure $structure)
    {
        $structure->delete();

        return redirect()->route('structures.index')->with('success', 'Structure supprimée avec succès.');
    }
}

