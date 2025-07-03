<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Corps;
use App\Models\Grade;
use App\Models\Etablissement;
use App\Models\Direction;
use App\Models\InspectionAcademique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Schema;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
use App\Imports\AgentsImport;

class AgentController extends Controller
{
    /**
     * Affiche la liste des agents
     */
 /*    public function index()
    {
        $agents = Agent::with(['etablissement', 'direction', 'inspectionAcademique', 'corps', 'grade', 'lot'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('agents.index', compact('agents'));
    } */

/*     public function index()
{
    $agents = Agent::with(['etablissement', 'direction', 'inspectionAcademique', 'corps', 'grade', 'lot'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    $etablissements = Etablissement::orderBy('nom')->get(); // Add this line

    return view('agents.index', compact('agents', 'etablissements')); // Update this line
} */
public function index(Request $request)
{
    $query = Agent::with(['etablissement', 'direction', 'inspectionAcademique', 'corps', 'grade', 'lot'])
                ->orderBy('created_at', 'desc');

    // Recherche par nom, prénom ou matricule
    if ($request->has('search')) {
        $searchTerm = $request->input('search');
        $query->where(function($q) use ($searchTerm) {
            $q->where('nom', 'LIKE', "%{$searchTerm}%")
              ->orWhere('prenom', 'LIKE', "%{$searchTerm}%")
              ->orWhere('matricule', 'LIKE', "%{$searchTerm}%");
        });
    }

    // Filtre par statut photo
    if ($request->has('statut') && in_array($request->statut, ['validee', 'en_attente', 'rejetee'])) {
        $query->where('statut_photo', $request->statut);
    }

    // Filtre par affectation (établissement)
    if ($request->has('affectation') && str_starts_with($request->affectation, 'etablissement_')) {
        $etablissementId = str_replace('etablissement_', '', $request->affectation);
        $query->where('etablissement_id', $etablissementId);
    }

    // Tri des résultats
    if ($request->has('sort')) {
        switch ($request->sort) {
            case 'nom_asc':
                $query->orderBy('nom', 'asc');
                break;
            case 'nom_desc':
                $query->orderBy('nom', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    $agents = $query->paginate(10);
    $etablissements = Etablissement::orderBy('nom')->get();

    return view('agents.index', compact('agents', 'etablissements'));
}
    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('agents.create', [
            'corps' => $this->getOrderedItems(Corps::class, ['nom']),
            'grades' => $this->getOrderedItems(Grade::class, ['nom']),
            'etablissements' => Etablissement::orderBy('nom')->get(),
            'directions' => Direction::orderBy('nom')->get(),
            'inspectionAcademiques' => InspectionAcademique::orderBy('nom')->get()
        ]);
    }

    /**
     * Enregistre un nouvel agent
     */
    public function store(Request $request)
    {
        $validated = $this->validateAgentData($request);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $this->storeAgentPhoto($request->file('photo'));
            $validated['statut_photo'] = 'en_attente';
        }

        Agent::create($validated);

        return redirect()->route('agents.index')->with('success', 'Agent enrôlé avec succès');
    }

    /**
     * Affiche les détails d'un agent
     */
    public function show($id)
    {
        $agent = $this->getAgentWithRelations($id);
        return view('agents.show', compact('agent'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $agent = Agent::findOrFail($id);
        $etablissements = Etablissement::all();
        $ias = InspectionAcademique::all();
        $corps = Corps::orderBy('nom')->get();
        $grades = Grade::orderBy('nom')->get();

        return view('agents.edit', compact('agent', 'etablissements', 'ias', 'corps', 'grades'));
    }


    /**
     * Met à jour un agent
     */
   /*  public function update(Request $request, Agent $agent)
    {
        $validated = $this->validateAgentData($request, $agent->id);

        if ($request->hasFile('photo')) {
            $this->deleteOldPhoto($agent);
            $validated['photo'] = $this->storeAgentPhoto($request->file('photo'));
            $validated['statut_photo'] = 'en_attente';
            $validated['motif_rejet_photo'] = null;
        }

        $agent->update($validated);

        return redirect()->route('agents.index')->with('success', 'Agent mis à jour avec succès');
    } */
    public function update(Request $request, Agent $agent)
    {
        $validated = $this->validateAgentData($request, $agent->id);

        // 1. Si une nouvelle photo a été recadrée (base64)
        if ($request->filled('cropped_photo')) {
            // Supprimer l’ancienne photo si nécessaire
            if ($agent->photo && Storage::disk('public')->exists($agent->photo)) {
                Storage::disk('public')->delete($agent->photo);
            }

            // Nettoyer la base64 quelle que soit l'extension (jpeg ou png)
            $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $request->input('cropped_photo'));
            $base64 = str_replace(' ', '+', $base64);

            // Décoder l'image
            $imageData = base64_decode($base64);

            // Définir le chemin de sauvegarde
            $filename = 'photos/photo_' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $imageData);
            
            if (!Storage::disk('public')->exists($filename)) {
                \Log::error("Erreur de sauvegarde photo agent : $filename non trouvé");
            }
            
            // Mettre à jour les champs du modèle
            $validated['photo'] = $filename;
            $validated['statut_photo'] = 'en_attente';
            $validated['motif_rejet_photo'] = null;
        }


        // 2. Sinon, si on a uploadé une photo classique (optionnel)
        elseif ($request->hasFile('photo')) {
            $this->deleteOldPhoto($agent);
            $validated['photo'] = $this->storeAgentPhoto($request->file('photo'));
            $validated['statut_photo'] = 'en_attente';
            $validated['motif_rejet_photo'] = null;
        }

        // 3. Mettre à jour l'agent
        $agent->update($validated);

        return redirect()->route('agents.index')->with('success', 'Agent mis à jour avec succès');
    }

    /**
     * Valide la photo d'un agent
     */
    public function validerPhoto($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->update([
            'statut_photo' => 'validee',
            'motif_rejet_photo' => null
        ]);

        return back()->with('success', 'Photo validée avec succès');
    }

    /**
     * Rejette la photo d'un agent
     */
    public function rejeterPhoto(Request $request, $id)
    {
        $request->validate(['motif_rejet_photo' => 'required|string|max:255']);

        $agent = Agent::findOrFail($id);
        $agent->update([
            'statut_photo' => 'rejetee',
            'motif_rejet_photo' => $request->motif_rejet_photo
        ]);

        return back()->with('success', 'Photo rejetée avec succès');
    }

    /**
     * Affiche la carte d'identité
     */
    public function viewCard($id)
    {
        $agent = Agent::with(['etablissement', 'inspectionAcademique'])

                    ->where('statut_photo', 'validee')
                    ->findOrFail($id);

        return view('agents.carte', [
            'agent' => $agent,
            'rectoPath' => asset('template/recto.jpeg'),
            'versoPath' => asset('template/verso.jpeg'),
            'signaturePath' => asset('images/cachet_ministere.png'),
            'qrCode' => QrCode::size(100)->generate(route('agents.verify', $agent->id))
        ]);
    }

    /**
     * Télécharge la carte au format PDF
     */
    /* public function downloadCard($id)
    {
        $agent = Agent::with(['etablissement', 'inspectionAcademique'])
                    ->where('statut_photo', 'validee')
                    ->findOrFail($id);

        $pdf = Pdf::loadView('agents.carte-pdf', [
                'agent' => $agent,
                'rectoPath' => public_path('template/carte_recto.png'),
                'versoPath' => public_path('template/carte_verso.png'),
                'signaturePath' => public_path('images/signature_directeur.png'),
                'qrCode' => QrCode::size(100)->generate(route('agents.verify', $agent->id))
            ])
            ->setPaper([0, 0, 85.6, 54], 'portrait')
            ->setOption('isRemoteEnabled', true);

        return $pdf->download('carte_'.$agent->matricule.'.pdf');
    } */
   /*  public function downloadCard($id)
    {
        $agent = Agent::with(['etablissement', 'inspectionAcademique'])
                    ->where('statut_photo', 'validee')
                    ->findOrFail($id);

        // Vérification complète des relations requises
        if (!$agent->etablissement || !$agent->inspectionAcademique) {
            return back()
                   ->with('error', 'Les informations d\'affectation sont incomplètes. Veuillez compléter l\'affectation de l\'agent avant de générer la carte.');
        }

        // Vérification des champs obligatoires
        $requiredFields = ['prenom', 'nom', 'matricule', 'fonction'];
        foreach ($requiredFields as $field) {
            if (empty($agent->$field)) {
                return back()
                       ->with('error', "Le champ $field est requis pour générer la carte.");
            }
        }

        $filename = 'carte_'.preg_replace('/[^a-zA-Z0-9-_]/', '', $agent->matricule).'.pdf';

        try {
            $pdf = Pdf::loadView('agents.carte-pdf', [
                'agent' => $agent,
                'rectoPath' => public_path('template/carte_recto.png'),
                'versoPath' => public_path('template/carte_verso.png'),
                'signaturePath' => public_path('images/signature_directeur.png'),
                'qrCode' => QrCode::size(100)->generate(route('agents.verify', $agent->id))
            ])->setPaper([0, 0, 85.6, 54], 'portrait')
              ->setOption('isRemoteEnabled', true);

            return $pdf->download($filename);
        } catch (\Exception $e) {
            \Log::error('Erreur génération PDF: '.$e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la génération du PDF.');
        }
    } */

    public function downloadCard($id)
    {
        $agent = Agent::with(['etablissement:id,nom', 'inspectionAcademique:id,nom'])
                      ->where('statut_photo', 'validee')
                      ->findOrFail($id);

        // Vérification minimale
        if (!$agent->etablissement || !$agent->inspectionAcademique) {
            return back()->with('error', 'Les informations d\'affectation sont incomplètes.');
        }

        // Définir les chemins absolus (public/)
        $rectoBase64     = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/template/carte_recto.png')));
        $versoBase64     = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/template/carte_verso.png')));
        $signatureBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/images/cachet_ministre.png')));
        $photoBase64     = $agent->photo ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('storage/' . $agent->photo))) : null;


    /*     // Vérifier que tous les fichiers existent
        foreach (['rectoPath' => $rectoPath, 'versoPath' => $versoPath, 'signaturePath' => $signaturePath] as $label => $path) {
            if (!file_exists($path)) {
                Log::error("Fichier manquant : $label ($path)");
                return back()->with('error', "Erreur : le fichier $label est introuvable.");
            }
        } */

        // Générer le QR Code et le mettre en cache local
        $qrPath = storage_path("app/public/qrcodes/qr_{$agent->id}.png");
        if (!file_exists($qrPath)) {
            $qrSvg = QrCode::format('svg')
            ->size(100)
                ->generate(route('agents.verify', $agent->id));
                $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);


        }



        // PDF
        $pdf = Pdf::loadView('agents.carte-pdf', [
            'agent'         => $agent,
            'rectoPath'     => $rectoBase64,
            'versoPath'     => $versoBase64,
            'signaturePath' => $signatureBase64,
            'photoPath'     => $photoBase64,
            'qrCode'        => $qrCode
        ])
        ->setPaper([0, 0, 242.65, 153.07], 'portrait')
        ->setOption('isRemoteEnabled', true);

        $matricule = preg_replace('/[\/\\\\]/', '_', $agent->matricule);
        return $pdf->download("carte_{$matricule}.pdf");
        // return $pdf->download("carte_{$agent->matricule}.pdf");
    }


    /**
     * Vérifie la carte d'un agent
     */
    public function verify($id)
    {
        $agent = $this->getAgentWithRelations($id);
        return view('agents.carte_verification', compact('agent'));
    }

    /**
     * Méthodes utilitaires
     */
    private function getAgentWithRelations($id)
    {
        return Agent::with(['etablissement', 'direction', 'inspectionAcademique', 'corps', 'grade'])
                  ->findOrFail($id);
    }

    private function validateAgentData(Request $request, $agentId = null)
    {
        $rules = [
            'matricule' => 'required|unique:agents,matricule,'.$agentId,
            'prenom' => 'required',
            'nom' => 'required',
            'cin' => 'required|unique:agents,cin,'.$agentId,
            'telephone' => 'required',
            'fonction' => 'required',
            'etablissement_id' => 'nullable|exists:etablissements,id',
            'direction_id' => 'nullable|exists:directions,id',
            'inspection_academique_id' => 'required|exists:inspection_academiques,id',
            'corps_id' => 'nullable|exists:corps,id',
            'grade_id' => 'nullable|exists:grades,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'statut_photo' => 'nullable|in:en_attente,validee,rejetee',
            'motif_rejet_photo' => 'nullable|required_if:statut_photo,rejetee'
        ];

        return $request->validate($rules);
    }

    private function storeAgentPhoto($photoFile)
    {
        return $photoFile->store('photos', 'public');
    }

    private function deleteOldPhoto(Agent $agent)
    {
        if ($agent->photo) {
            Storage::disk('public')->delete($agent->photo);
        }
    }

    private function getOrderedItems($modelClass, $possibleColumns)
    {
        $query = $modelClass::query();

        foreach ($possibleColumns as $column) {
            if (Schema::hasColumn((new $modelClass)->getTable(), $column)) {
                return $query->orderBy($column)->get();
            }
        }

        return $query->get();
    }
    public function generateCard($id)
{
    return $this->downloadCard($id);
}



public function import(Request $request)
{
    $request->validate([
        'fichier' => 'required|file|mimes:xlsx,xls,csv'
    ]);

    Excel::import(new AgentsImport, $request->file('fichier'));

    return redirect()->route('agents.index')->with('success', 'Importation réussie.');
}
}
