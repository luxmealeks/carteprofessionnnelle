<?php

namespace App\Http\Controllers;

use App\Models\InspectionAcademique;
use Illuminate\Http\Request;

class InspectionAcademiqueController extends Controller
{
    public function index()
    {
        $ias = InspectionAcademique::all();
        return view('ias.index', compact('ias'));
    }

    public function create()
    {
        return view('ias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
        ]);

        InspectionAcademique::create($request->all());

        return redirect()->route('ias.index')->with('success', 'Inspection ajoutée avec succès.');
    }

    public function edit($id)
    {
        $ia = InspectionAcademique::findOrFail($id);
        return view('ias.edit', compact('ia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string',
        ]);

        $ia = InspectionAcademique::findOrFail($id);
        $ia->update($request->all());

        return redirect()->route('ias.index')->with('success', 'Inspection mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $ia = InspectionAcademique::findOrFail($id);
        $ia->delete();

        return redirect()->route('ias.index')->with('success', 'Inspection supprimée.');
    }

    public function etablissements($id)
    {
        $ia = InspectionAcademique::with('etablissements')->findOrFail($id);
        return view('ias.etablissements', compact('ia'));
    }
}
