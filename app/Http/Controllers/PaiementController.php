<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaiementStoreRequest;
use App\Http\Requests\PaiementUpdateRequest;
use App\Models\Paiement;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PaiementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche la liste des paiements avec possibilité de recherche
     */
    public function index(Request $request): View
    {
        $query = Paiement::with('category')
            ->latest();

        // Filtre par recherche textuelle
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtre par banque
        if ($request->filled('banque')) {
            $query->where('banque', $request->input('banque'));
        }

        // Filtre par catégorie
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filtre par date
        if ($request->filled('date_debut')) {
            $query->whereDate('date', '>=', $request->input('date_debut'));
        }

        if ($request->filled('date_fin')) {
            $query->whereDate('date', '<=', $request->input('date_fin'));
        }

        $paiements = $query->paginate(15)->withQueryString();

        return view('paiements.index', compact('paiements'));
    }

    /**
     * Affiche le formulaire de création d'un paiement
     */
    public function create(): View
    {
        $categories = Category::where('type', 'paiement')
            ->orderBy('nom')
            ->get();
        return view('paiements.create', compact('categories'));
    }

    /**
     * Enregistre un nouveau paiement
     */
    public function store(PaiementStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        // Gestion du fichier joint
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('paiements', 'public');
        }

        $paiement = Paiement::create($data);

        return redirect()
            ->route('paiements.show', $paiement)
            ->with('success', 'Le paiement a été créé avec succès.');
    }

    /**
     * Affiche les détails d'un paiement
     */
    public function show(Paiement $paiement): View
    {
        return view('paiement.show', compact('paiement'));
    }

    /**
     * Affiche le formulaire d'édition d'un paiement
     */
    public function edit(Paiement $paiement): View
    {
        $categories = Category::where('type', 'paiement')
            ->orderBy('nom')
            ->get();
        return view('paiements.edit', compact('paiement', 'categories'));
    }

    /**
     * Met à jour un paiement
     */
    public function update(PaiementUpdateRequest $request, Paiement $paiement): RedirectResponse
    {
        $data = $request->validated();

        // Mise à jour du fichier joint si un nouveau est fourni
        if ($request->hasFile('attachment')) {
            // Supprimer l'ancien fichier s'il existe
            if ($paiement->attachment) {
                Storage::disk('public')->delete($paiement->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('paiements', 'public');
        }

        $paiement->update($data);

        return redirect()
            ->route('paiements.show', $paiement)
            ->with('success', 'Le paiement a été mis à jour avec succès.');
    }

    /**
     * Supprime un paiement
     */
    public function destroy(Paiement $paiement): RedirectResponse
    {
        // Supprimer le fichier joint s'il existe
        if ($paiement->attachment) {
            Storage::disk('public')->delete($paiement->attachment);
        }

        $paiement->delete();

        return redirect()
            ->route('paiements.index')
            ->with('success', 'Le paiement a été supprimé avec succès.');
    }
}
