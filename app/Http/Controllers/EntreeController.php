<?php

namespace App\Http\Controllers;

use App\Models\Entree;
use App\Models\Category;
use App\Http\Requests\EntreeStoreRequest;
use App\Http\Requests\EntreeUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EntreeController extends Controller
{
    public function index(Request $request)
    {
        $query = Entree::with('category')
            ->select('entrees.*')
            ->join('categories', 'entrees.category_id', '=', 'categories.id')
            ->when($request->filled('search'), function($q) use ($request) {
                $q->where('entrees.description', 'like', "%{$request->search}%");
            })
            ->when($request->filled('date_debut'), function($q) use ($request) {
                $q->whereDate('entrees.date', '>=', $request->date_debut);
            })
            ->when($request->filled('date_fin'), function($q) use ($request) {
                $q->whereDate('entrees.date', '<=', $request->date_fin);
            })
            ->when($request->filled('category_id'), function($q) use ($request) {
                $q->where('entrees.category_id', $request->category_id);
            });

        // Calcul du montant total pour la période sélectionnée
        $totalMontant = (clone $query)->sum('entrees.montant');

        // Récupération des entrées avec pagination
        $entrees = $query->latest('entrees.date')->paginate(15)->withQueryString();

        // Récupération des catégories pour le filtre
        $categories = Category::where('type', 'entree')->orderBy('nom')->get();

        return view('entree.index', compact('entrees', 'categories', 'totalMontant'));
    }

    public function create()
    {
        $categories = Category::where('type', 'entree')->orderBy('nom')->get();
        return view('entree.create', compact('categories'));
    }

    public function store(EntreeStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $entree = new Entree($request->validated());
            $entree->user_id = Auth::id();
            $entree->save();

            DB::commit();

            return redirect()
                ->route('entrees.index')
                ->with('success', 'L\'entrée a été enregistrée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement de l\'entrée.');
        }
    }

    public function show(Entree $entree)
    {
        return view('entree.show', compact('entree'));
    }

    public function edit(Entree $entree)
    {
        $categories = Category::where('type', 'entree')->orderBy('nom')->get();
        return view('entree.edit', compact('entree', 'categories'));
    }

    public function update(EntreeUpdateRequest $request, Entree $entree)
    {
        try {
            DB::beginTransaction();

            $entree->update($request->validated());

            DB::commit();

            return redirect()
                ->route('entrees.index')
                ->with('success', 'L\'entrée a été mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour de l\'entrée.');
        }
    }

    public function destroy(Entree $entree)
    {
        try {
            DB::beginTransaction();

            $entree->delete();

            DB::commit();

            return redirect()
                ->route('entrees.index')
                ->with('success', 'L\'entrée a été supprimée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression de l\'entrée.');
        }
    }
}
