<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AgentController,
    LotController,
    PhotoController,
    AuthController,
    WelcomeController,
    DashboardController,
    EtablissementController,
    DirectionController,
    InspectionAcademiqueController,
    CorpsController,
    GradeController,
    AgentImportController,
    ProfileController,
    ActivityController,
    StructureController
};
use App\Livewire\Settings\{Appearance, Password, Profile};
use App\Http\Controllers\IEFController;

// Accueil
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
})->name('home');

// Authentification
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Routes protégées
Route::middleware('auth')->group(function () {

    // Agents
    Route::resource('agents', AgentController::class);
    Route::get('agents/validation/list', [AgentController::class, 'validationList'])->name('agents.validation');
    Route::post('agents/{id}/valider-photo', [AgentController::class, 'validerPhoto'])->name('agents.validerPhoto');
    Route::post('agents/{id}/rejeter-photo', [AgentController::class, 'rejeterPhoto'])->name('agents.rejeterPhoto');
    Route::post('agents/bulk-validate', [AgentController::class, 'bulkValidate'])->name('agents.bulkValidate');

    // Cartes agents
    Route::get('agents/{agent}/view-card', [AgentController::class, 'viewCard'])->name('agents.viewCard');
    Route::get('agents/{agent}/generate-card', [AgentController::class, 'generateCard'])->name('agents.generateCard');
    Route::get('agents/{agent}/download-card', [AgentController::class, 'downloadCard'])->name('agents.downloadCard');
    Route::get('agents/{agent}/verify', [AgentController::class, 'verify'])->name('agents.verify');

    // Lots
// Routes LOTS (protégées)
Route::middleware(['auth'])->group(function () {
    Route::get('lots/create', [LotController::class, 'create'])->name('lots.create');
    Route::post('lots', [LotController::class, 'store'])->name('lots.store');
    Route::get('lots/generer', [LotController::class, 'genererForm'])->name('lots.generer.form');
    Route::get('lots/generer/{ia_id?}', [LotController::class, 'generer'])->name('lots.generer');
    Route::post('lots/generer', [LotController::class, 'generer'])->name('lots.generer.post');
    Route::post('lots/imprimer/{ia_id}', [LotController::class, 'imprimer'])->name('lots.imprimer');
    Route::get('lots/{id}/pdf', [LotController::class, 'exportPDF'])->name('lots.pdf');
    Route::resource('lots', LotController::class)->except(['show']);

    Route::resource('lots', LotController::class)->only([
        'index', 'create', 'store', 'edit', 'update', 'destroy'
    ]);

    // Déclarez manuellement les routes supplémentaires
    Route::get('/lots/{id}', [LotController::class, 'show'])->name('lots.show');
    Route::get('/lots/choisir', [LotController::class, 'choisir'])->name('lots.choisir');
});

// Route spécifique /lots/choisir accessible publiquement (sans auth)
Route::get('/lots/choisir', [LotController::class, 'choisir'])->name('lots.choisir');

    // Photos
    Route::get('photos', [PhotoController::class, 'index'])->name('photos.index');
    Route::post('photos/{agent}/valider', [PhotoController::class, 'valider'])->name('photos.valider');
    Route::post('photos/{agent}/rejeter', [PhotoController::class, 'rejeter'])->name('photos.rejeter');

    // Importation d'agents
    Route::get('/agents/import', fn () => view('agents.import'))->name('agents.import.form');
    Route::post('/agents/import', [AgentImportController::class, 'import'])->name('agents.import');

    // Paramétrage
    Route::prefix('parametrage')->name('parametrage.')->group(function () {
        Route::resource('etablissements', EtablissementController::class);
        Route::resource('directions', DirectionController::class);
        Route::resource('ias', InspectionAcademiqueController::class);
        Route::resource('corps', CorpsController::class);
        Route::resource('grades', GradeController::class);
    });

    // Activités
    Route::resource('activities', ActivityController::class);

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Paramètres Livewire
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// Autres routes publiques
Route::get('ias/{ia}/etablissements', [InspectionAcademiqueController::class, 'etablissements'])->name('ias.etablissements');

// Route du manifeste PWA
Route::get('/site.webmanifest', fn () => response()
    ->file(public_path('site.webmanifest'))
    ->header('Content-Type', 'application/manifest+json')
);
Route::resource('ias', InspectionAcademiqueController::class)->middleware('auth');

Route::get('/cards/generate-all/{ia}', [App\Http\Controllers\CarteController::class, 'generateAll'])->name('cards.generateAll');
Route::get('/cartes/generer/ia/{iaId}', [AgentImportController::class, 'generateAll'])->name('cartes.generate.all');


/* Route::resource('lots', LotController::class)->middleware('auth');
 */

// Route::resource('lots', LotController::class)->except(['edit', 'update', 'show']);


Route::get('/photos/validees', [PhotoController::class, 'validees'])->name('photos.validees');
Route::get('/photos/rejetees', [PhotoController::class, 'rejetees'])->name('photos.rejetees');
Route::post('/photos/reintegrer/{agent}', [PhotoController::class, 'reintegrer'])->name('photos.reintegrer');


// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
});



Route::resource('iefs', IEFController::class)->middleware('auth');

// Route personnalisée AVANT la resource
// Route::get('/lots/choisir', [LotController::class, 'choisir'])
//        ->name('lots.choisir')
//        ->withoutMiddleware(['auth']); // ← Désactive la protection


// Route::get('/lots/choisir', [LotController::class, 'choisir'])->name('lots.choisir');
// Route::resource('lots', LotController::class)->except(['show']);

// Déclaration unique et propre
// Route::resource('lots', LotController::class)->except(['show'])->middleware('auth');

Route::resource('etablissements', EtablissementController::class)->middleware('auth');

// Pour l'impression d'un lot existant
Route::post('/lots/{lot}/imprimer', [LotController::class, 'imprimer'])
     ->name('lots.imprimer');

     // Pour la création + impression
Route::post('/ias/{ia}/generer', [LotController::class, 'traiterGeneration'])
->name('lots.traiterGeneration');

Route::get('/lots/imprimer/{id}', [LotController::class, 'imprimer'])->name('lots.imprimer');

Route::post('/lots/imprimer/{ia}', [LotController::class, 'imprimer'])
     ->name('lots.imprimer');

// Route::resource('lots', LotController::class);

// Route::get('/lots/imprimer/{id}', [LotController::class, 'imprimer'])->name('lots.imprimer');

// Route::get('/lots/choisir', [App\Http\Controllers\LotController::class, 'choisir'])->name('lots.choisir');




Route::post('/lots/imprimer/{ia}', [LotController::class, 'imprimer'])->name('lots.imprimer');
Route::get('/lots/generer', [LotController::class, 'genererForm'])->name('lots.generer.form');
Route::post('/lots/imprimer/{ia_id}', [LotController::class, 'imprimer'])->name('lots.imprimer');
Route::post('/lots/generer', [LotController::class, 'generer'])->name('lots.generer');

Route::get('/agents/{id}', [AgentController::class, 'show'])->name('agents.show');

Route::get('/photos/{agent}/traiter', [PhotoController::class, 'traiter'])->name('photos.traiter');
Route::post('/photos/{agent}/rogner', [PhotoController::class, 'rogner'])->name('photos.rogner');

Route::post('/photos/{agent}/rogner-removebg', [PhotoController::class, 'rognerEtSupprimerFond'])
    ->name('photos.rogner.removebg');

    Route::resource('structures', StructureController::class);
