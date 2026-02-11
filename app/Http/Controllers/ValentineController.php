<?php

namespace App\Http\Controllers;

use App\Models\PageView;
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

    public function show(Request $request)
    {
        // Vérifie si l'utilisateur a déjà visité cette page
        if (!$request->session()->has('visited_valentine')) {

            // Incrémente le compteur
            $view = PageView::firstOrCreate(
                ['page' => 'valentine'],
                ['count' => 0]
            );
            $view->increment('count');

            // Marque la session pour dire que ce visiteur a déjà vu
            $request->session()->put('visited_valentine', true);
        } else {
            // Récupère le compteur actuel sans incrémenter
            $view = PageView::firstOrCreate(
                ['page' => 'valentine'],
                ['count' => 0]
            );
        }

        // Passe la variable à la vue
        return view('valentine', ['views' => $view->count]);
    }

    public function adminViews()
    {
        // Récupère le compteur actuel
        $view = PageView::firstOrCreate(
            ['page' => 'valentine'], // page identifiant unique
            ['count' => 0]
        );

        // Affiche le nombre de vues dans une vue admin
        return view('admin.valentine_views', [
            'views' => $view->count
        ]);
    }
}
