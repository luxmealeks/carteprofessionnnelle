<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PhotoController extends Controller
{
    public function index()
    {
       // Récupère les agents avec photo en attente de validation
    $agents = Agent::where('statut_photo', 'en_attente')
    ->with(['etablissement', 'inspectionAcademique'])
    ->paginate(10);
    
      return view('photos.validation', compact('agents'));
    }
    
    
    
    public function traiter(Agent $agent)
{
    return view('photos.traiter', compact('agent'));
}
public function recadrer(Agent $agent)
{
    if (!$agent->photo) {
        return redirect()->route('photos.validation')->with('error', 'Cet agent n\'a pas de photo à recadrer');
    }

    return view('photos.recadrer', compact('agent'));
}

public function updateCrop(Request $request, Agent $agent)
{
    $validated = $request->validate([
        'x' => 'required|numeric',
        'y' => 'required|numeric',
        'width' => 'required|numeric',
        'height' => 'required|numeric',
        'rotate' => 'sometimes|numeric'
    ]);

    // Chemin vers l'image originale
    $path = storage_path('app/public/' . $agent->photo);
    
    // Créer une intervention image
    $image = Image::make($path);
    
    // Appliquer la rotation si nécessaire
    if ($request->rotate) {
        $image->rotate($request->rotate);
    }
    
    // Recadrer l'image
    $image->crop(
        (int)$request->width,
        (int)$request->height,
        (int)$request->x,
        (int)$request->y
    );
    
    // Sauvegarder l'image recadrée (écrase l'originale)
    $image->save($path);
    
    return redirect()
           ->route('photos.validation')
           ->with('success', 'Photo recadrée avec succès');
}

public function rogner(Request $request, Agent $agent)
{
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');

        // Supprimer ancienne photo si elle existe
        if ($agent->photo && Storage::exists($agent->photo)) {
            Storage::delete($agent->photo);
        }

        $path = $photo->store('public/photos');
        $agent->update(['photo' => $path]);

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'error' => 'Aucune image reçue.']);
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
