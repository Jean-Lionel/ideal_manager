<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        // Filtre par recherche
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtre par type
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        // Tri et pagination
        $categories = $query->latest()->paginate(10)->withQueryString();

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $category = Category::create($request->validated());

            DB::commit();

            return redirect()
                ->route('categories.index')
                ->with('success', 'La catégorie a été créée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la création de la catégorie.');
        }
    }

    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        try {
            DB::beginTransaction();

            $category->update($request->validated());

            DB::commit();

            return redirect()
                ->route('categories.index')
                ->with('success', 'La catégorie a été mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour de la catégorie.');
        }
    }

    public function destroy(Category $category)
    {
        try {
            DB::beginTransaction();

            // Vérifier si la catégorie est utilisée avant de supprimer
            if ($category->entrees()->exists() || $category->sorties()->exists()) {
                return back()->with('error', 'Impossible de supprimer cette catégorie car elle est utilisée dans des transactions.');
            }

            $category->delete();

            DB::commit();

            return redirect()
                ->route('categories.index')
                ->with('success', 'La catégorie a été supprimée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la suppression de la catégorie.');
        }
    }
}
