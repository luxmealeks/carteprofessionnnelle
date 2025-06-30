<?php

namespace App\Http\Controllers;

use App\Models\IEF;
use Illuminate\Http\Request;

class IEFController extends Controller
{
    public function index()
    {
        $iefs = IEF::all();
        return view('iefs.index', compact('iefs'));
    }

    public function create()
    {
        $ias = \App\Models\InspectionAcademique::orderBy('nom')->get();
        return view('iefs.create', compact('ias'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'region' => 'required|string',
        ]);

        IEF::create($request->all());

        return redirect()->route('iefs.index')->with('success', 'IEF ajoutée avec succès.');
    }

    public function edit($id)
    {
        $ief = IEF::findOrFail($id);
        return view('iefs.edit', compact('ief'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string',
            'region' => 'required|string',
        ]);

        $ief = IEF::findOrFail($id);
        $ief->update($request->all());

        return redirect()->route('iefs.index')->with('success', 'IEF mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $ief = IEF::findOrFail($id);
        $ief->delete();

        return redirect()->route('iefs.index')->with('success', 'IEF supprimée.');
    }
}
