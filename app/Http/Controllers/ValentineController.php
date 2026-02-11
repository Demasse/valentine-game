<?php

namespace App\Http\Controllers;

use App\Models\Valentine;
use App\Models\View;
use Illuminate\Http\Request;

class ValentineController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
        ]);

        Valentine::create([
            'name' => $request->name,
            'gender' => $request->gender,
        ]);

        return response()->json(['message' => 'Merci ! 🎉']);
    }

    public function show()
    {
        // Récupère l'enregistrement pour la page "valentine" ou le crée s'il n'existe pas
        $view = View::firstOrCreate(
            ['page' => 'valentine'], // page = nom unique
            ['count' => 0]           // initialise à 0 si nouvel enregistrement
        );

        // Incrémente le compteur
        $view->increment('count');

        // Retourne la vue avec le nombre de visites
        return view('valentine', [
            'views' => $view->count
        ]);
    }
}
