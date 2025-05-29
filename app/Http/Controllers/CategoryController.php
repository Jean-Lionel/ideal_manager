<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): Response
    {
        $categories = Category::all();

        return view('category.index', [
            'categories' => $categories,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('category.create');
    }

    public function store(CategoryStoreRequest $request): Response
    {
        $category = Category::create($request->validated());

        $request->session()->flash('category.id', $category->id);

        return redirect()->route('categories.index');
    }

    public function show(Request $request, Category $category): Response
    {
        return view('category.show', [
            'category' => $category,
        ]);
    }

    public function edit(Request $request, Category $category): Response
    {
        return view('category.edit', [
            'category' => $category,
        ]);
    }

    public function update(CategoryUpdateRequest $request, Category $category): Response
    {
        $category->update($request->validated());

        $request->session()->flash('category.id', $category->id);

        return redirect()->route('categories.index');
    }

    public function destroy(Request $request, Category $category): Response
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}
