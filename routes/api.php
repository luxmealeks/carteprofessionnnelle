<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Etablissement;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route pour filtrer les établissements par inspection académique
Route::get('/etablissements', function (Request $request) {
    try {
        // Valider le paramètre d'entrée
        $request->validate([
            'inspection_academique_id' => 'nullable|integer|exists:inspection_academiques,id'
        ]);

        $query = Etablissement::query()->with('inspectionAcademique:nom');
        
        if ($request->filled('inspection_academique_id')) {
            $query->where('inspection_academique_id', $request->inspection_academique_id);
        }

        $etablissements = $query->orderBy('nom')
                               ->get(['id', 'nom', 'inspection_academique_id'])
                               ->map(function($item) {
                                   return [
                                       'id' => $item->id,
                                       'nom' => $item->nom,
                                       'ia_nom' => $item->inspectionAcademique->nom ?? null
                                   ];
                               });

        return response()->json([
            'success' => true,
            'data' => $etablissements
        ]);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Server error',
            'error' => $e->getMessage()
        ], 500);
    }
})->name('api.etablissements.index');