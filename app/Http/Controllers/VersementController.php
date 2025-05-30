<?php

namespace App\Http\Controllers;

use App\Http\Requests\VersementStoreRequest;
use App\Http\Requests\VersementUpdateRequest;
use App\Models\Versement;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class VersementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche la liste des versements avec possibilité de recherche
     */
    public function index(Request $request): View
    {
        $query = Versement::with('category')
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

        $versements = $query->paginate(15)->withQueryString();

        return view('versements.index', compact('versements'));
    }

    /**
     * Affiche le formulaire de création d'un versement
     */
    public function create(): View
    {
        $categories = Category::where('type', 'versement')
            ->orderBy('nom')
            ->get();
        return view('versements.create', compact('categories'));
    }

    /**
     * Enregistre un nouveau versement
     */
    public function store(VersementStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        // Gestion du fichier joint
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('versements', 'public');
        }

        $versement = Versement::create($data);

        return redirect()
            ->route('versements.show', $versement)
            ->with('success', 'Le versement a été créé avec succès.');
    }

    /**
     * Affiche les détails d'un versement
     */
    public function show(Versement $versement): View
    {

        return view('versements.show', compact('versement'));
    }

    /**
     * Affiche le formulaire d'édition d'un versement
     */
    public function edit(Versement $versement): View
    {
        $this->authorize('update', $versement);
        $categories = Category::orderBy('name')->pluck('name', 'id');
        return view('versements.edit', compact('versement', 'categories'));
    }

    /**
     * Met à jour un versement
     */
    public function update(VersementUpdateRequest $request, Versement $versement): RedirectResponse
    {
        $this->authorize('update', $versement);

        $data = $request->validated();

        // Mise à jour du fichier joint si un nouveau est fourni
        if ($request->hasFile('attachment')) {
            // Supprimer l'ancien fichier s'il existe
            if ($versement->attachment) {
                Storage::disk('public')->delete($versement->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('versements', 'public');
        }

        $versement->update($data);

        return redirect()
            ->route('versements.show', $versement)
            ->with('success', 'Le versement a été mis à jour avec succès.');
    }

    /**
     * Supprime un versement
     */
    public function destroy(Versement $versement): RedirectResponse
    {
        $this->authorize('delete', $versement);

        // Supprimer le fichier joint s'il existe
        if ($versement->attachment) {
            Storage::disk('public')->delete($versement->attachment);
        }

        $versement->delete();

        return redirect()
            ->route('versements.index')
            ->with('success', 'Le versement a été supprimé avec succès.');
    }
}
