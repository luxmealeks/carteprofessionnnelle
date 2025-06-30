<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Agent;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $total = Agent::count();
        $en_attente = Agent::where('statut_photo', 'en_attente')->count();
        $validees = Agent::where('statut_photo', 'validee')->count();
        $rejetees = Agent::where('statut_photo', 'rejetee')->count();

        return view('welcome', compact('user', 'total', 'en_attente', 'validees', 'rejetees'));
    }
}
