<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Corps;
use App\Models\Grade;
use App\Models\Etablissement;
use App\Models\Structure;
use App\Models\InspectionAcademique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Schema;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
use App\Imports\AgentsImport;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $query = Agent::with(['etablissement', 'structure', 'inspectionAcademique', 'corps', 'grade', 'lot'])
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

    public function create()
    {
        return view('agents.create', [
            'corps' => $this->getOrderedItems(Corps::class, ['nom']),
            'grades' => $this->getOrderedItems(Grade::class, ['nom']),
            'structures' => Structure::orderBy('nom')->get(),
            'inspectionAcademiques' => InspectionAcademique::with('etablissements')->orderBy('nom')->get(),
            'etablissements' => collect() // Collection vide pour la création
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateAgentData($request);

        // Gestion des relations
        $this->handleAffectationRelations($request, $validated);

        // Gestion de la photo
        if ($request->hasFile('photo')) {
            $validated['photo'] = $this->storeAgentPhoto($request->file('photo'));
            $validated['statut_photo'] = 'en_attente';
        }

        Agent::create($validated);

        return redirect()->route('agents.index')->with('success', 'Agent enrôlé avec succès');
    }

    public function show($id)
    {
        $agent = $this->getAgentWithRelations($id);
        return view('agents.show', compact('agent'));
    }

    public function edit(Agent $agent)
    {
        $inspectionAcademiques = InspectionAcademique::with('etablissements')->get();
    
        return view('agents.edit', [
            'agent' => $agent,
            'corps' => Corps::all(),
            'grades' => Grade::all(),
            'structures' => Structure::all(),
            'inspectionAcademiques' => $inspectionAcademiques,
            'etablissements' => $agent->inspection_academique_id 
                ? Etablissement::where('inspection_academique_id', $agent->inspection_academique_id)->get()
                : collect()
        ]);
    }

    public function update(Request $request, Agent $agent)
    {
        // Validation des données
        $validated = $this->validateAgentData($request, $agent->id);
        
        // Gestion des relations
        $this->handleAffectationRelations($request, $validated);

        // Gestion de la photo
        $this->handleAgentPhoto($request, $agent, $validated);
        
        // Mise à jour de l'agent
        $agent->update($validated);
        
        return redirect()->route('agents.index')
               ->with('success', 'Agent mis à jour avec succès.');
    }

    public function validerPhoto($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->update([
            'statut_photo' => 'validee',
            'motif_rejet_photo' => null
        ]);

        return back()->with('success', 'Photo validée avec succès');
    }

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

    public function downloadCard($id)
    {
        $agent = Agent::with(['etablissement:id,nom', 'inspectionAcademique:id,nom'])
                      ->where('statut_photo', 'validee')
                      ->findOrFail($id);

        if (!$agent->etablissement || !$agent->inspectionAcademique) {
            return back()->with('error', 'Les informations d\'affectation sont incomplètes.');
        }

        // Convertir les images en base64
        $rectoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/template/carte_recto.png')));
        $versoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/template/carte_verso.png')));
        $signatureBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('storage/images/cachet_ministre.png')));
        $photoBase64 = $agent->photo ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents(public_path('storage/' . $agent->photo))) : null;

        // Générer le QR Code
        $qrSvg = QrCode::format('svg')
            ->size(100)
            ->generate(route('agents.verify', $agent->id));
        $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        // Générer le PDF
        $pdf = Pdf::loadView('agents.carte-pdf', [
            'agent' => $agent,
            'rectoPath' => $rectoBase64,
            'versoPath' => $versoBase64,
            'signaturePath' => $signatureBase64,
            'photoPath' => $photoBase64,
            'qrCode' => $qrCode
        ])
        ->setPaper([0, 0, 242.65, 153.07], 'portrait')
        ->setOption('isRemoteEnabled', true);

        $matricule = preg_replace('/[\/\\\\]/', '_', $agent->matricule);
        return $pdf->download("carte_{$matricule}.pdf");
    }

    public function verify($id)
    {
        $agent = $this->getAgentWithRelations($id);
        return view('agents.carte_verification', compact('agent'));
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

    // ============ Méthodes utilitaires ============

    protected function handleAffectationRelations(Request $request, array &$validated)
    {
        if ($request->filled('structure_id')) {
            $validated['inspection_academique_id'] = null;
            $validated['etablissement_id'] = null;
        } else {
            $validated['structure_id'] = null;
            
            if (empty($request->inspection_academique_id)) {
                throw new \Exception('Le champ inspection académique est requis quand aucune structure n\'est sélectionnée');
            }
        }
    }

    protected function handleAgentPhoto(Request $request, Agent $agent, array &$validated)
    {
        // Photo recadrée en base64 (prioritaire)
        if ($request->filled('cropped_photo')) {
            $this->saveCroppedPhoto($request->input('cropped_photo'), $agent, $validated);
        } 
        // Upload classique
        elseif ($request->hasFile('photo')) {
            $this->saveUploadedPhoto($request->file('photo'), $agent, $validated);
        }
        
        // Si aucune nouvelle photo n'est fournie, on conserve l'ancienne
        if (!isset($validated['photo'])) {
            $validated['photo'] = $agent->photo;
        }
    }

    protected function saveCroppedPhoto(string $imageData, Agent $agent, array &$validated)
    {
        $image = Image::make($imageData)->encode('jpg', 90);
        $filename = 'photos/'.uniqid().'.jpg';
        
        $this->deleteOldPhoto($agent);
        Storage::disk('public')->put($filename, $image);
        
        $validated['photo'] = $filename;
        $validated['statut_photo'] = 'en_attente';
        $validated['motif_rejet_photo'] = null;
    }

    protected function saveUploadedPhoto($photoFile, Agent $agent, array &$validated)
    {
        $this->deleteOldPhoto($agent);
        $validated['photo'] = $photoFile->store('photos', 'public');
        $validated['statut_photo'] = 'en_attente';
        $validated['motif_rejet_photo'] = null;
    }

    private function validateAgentData(Request $request, $agentId = null)
    {
        $rules = [
            'matricule' => 'nullable|string|max:20|unique:agents,matricule,'.$agentId,
            'cin' => 'nullable|string|max:20',
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'date_naissance' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'fonction' => 'required|string|max:100',
            'corps_id' => 'nullable|exists:corps,id',
            'grade_id' => 'nullable|exists:grades,id',
            'iden' => 'nullable|string|max:255',
            'statut_photo' => 'nullable|in:en_attente,validee,rejetee',
            'motif_rejet_photo' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'cropped_photo' => 'nullable|string',
        ];
    
        // Règles conditionnelles pour les relations
        if ($request->filled('structure_id')) {
            $rules['inspection_academique_id'] = 'nullable';
            $rules['etablissement_id'] = 'nullable';
        } else {
            $rules['inspection_academique_id'] = 'required|exists:inspection_academiques,id';
            $rules['etablissement_id'] = 'required|exists:etablissements,id';
        }
    
        return $request->validate($rules);
    }

    private function getAgentWithRelations($id)
    {
        return Agent::with(['etablissement', 'structure', 'inspectionAcademique', 'corps', 'grade'])
                  ->findOrFail($id);
    }

    private function storeAgentPhoto($photoFile)
    {
        return $photoFile->store('photos', 'public');
    }

    private function deleteOldPhoto(Agent $agent)
    {
        if ($agent->photo && Storage::disk('public')->exists($agent->photo)) {
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
}