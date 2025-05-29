<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntreeStoreRequest;
use App\Http\Requests\EntreeUpdateRequest;
use App\Models\Entree;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EntreeController extends Controller
{
    public function index(Request $request): Response
    {
        $entrees = Entree::all();

        return view('entree.index', [
            'entrees' => $entrees,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('entree.create');
    }

    public function store(EntreeStoreRequest $request): Response
    {
        $entree = Entree::create($request->validated());

        $request->session()->flash('entree.id', $entree->id);

        return redirect()->route('entrees.index');
    }

    public function show(Request $request, Entree $entree): Response
    {
        return view('entree.show', [
            'entree' => $entree,
        ]);
    }

    public function edit(Request $request, Entree $entree): Response
    {
        return view('entree.edit', [
            'entree' => $entree,
        ]);
    }

    public function update(EntreeUpdateRequest $request, Entree $entree): Response
    {
        $entree->update($request->validated());

        $request->session()->flash('entree.id', $entree->id);

        return redirect()->route('entrees.index');
    }

    public function destroy(Request $request, Entree $entree): Response
    {
        $entree->delete();

        return redirect()->route('entrees.index');
    }
}
