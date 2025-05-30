<?php

namespace App\Http\Controllers;

use App\Models\Sortie;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\SortieStoreRequest;
use App\Http\Requests\SortieUpdateRequest;
use Illuminate\Support\Facades\Auth;

class SortieController extends Controller
{
    /**
     * Afficher la liste des sorties.
     */
    public function index(Request $request)
    {
        $query = Sortie::with('category')
            ->latest('date');

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('montant', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('nom', 'like', "%{$search}%");
                  });
            });
        }

        $sorties = $query->paginate(15)->withQueryString();
        $totalMontant = $sorties->sum('montant');

        return view('sortie.index', compact('sorties', 'totalMontant'));
    }

    /**
     * Afficher le formulaire de création d'une sortie.
     */
    public function create()
    {
        $categories = Category::where('type', 'sortie')
            ->orderBy('nom')
            ->get();

        return view('sortie.create', compact('categories'));
    }

    /**
     * Enregistrer une nouvelle sortie.
     */
    public function store(SortieStoreRequest $request)
    {
        $sortie = new Sortie($request->validated());
        $sortie->user_id = Auth::id();
        $sortie->save();

        return redirect()
            ->route('sorties.index')
            ->with('success', 'La sortie a été enregistrée avec succès.');
    }

    /**
     * Afficher le formulaire d'édition d'une sortie.
     */
    public function edit(Sortie $sortie)
    {
        $this->authorize('update', $sortie);

        $categories = Category::where('type', 'sortie')
            ->where('user_id', Auth::id())
            ->orderBy('nom')
            ->get();

        return view('sortie.edit', compact('sortie', 'categories'));
    }

    /**
     * Mettre à jour une sortie existante.
     */
    public function update(SortieUpdateRequest $request, Sortie $sortie)
    {
        $this->authorize('update', $sortie);

        $sortie->update($request->validated());

        return redirect()
            ->route('sorties.index')
            ->with('success', 'La sortie a été mise à jour avec succès.');
    }

    /**
     * Supprimer une sortie.
     */
    public function destroy(Sortie $sortie)
    {
        $this->authorize('delete', $sortie);

        $sortie->delete();

        return redirect()
            ->route('sorties.index')
            ->with('success', 'La sortie a été supprimée avec succès.');
    }
}
