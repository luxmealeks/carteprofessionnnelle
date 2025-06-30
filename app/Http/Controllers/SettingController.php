<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;




class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            Setting::set($key, $value);
        }
        return redirect()->back()->with('success', 'Paramètres mis à jour avec succès.');
    }
}
