<?php

namespace App\Http\Controllers;

use App\Http\Requests\SortieStoreRequest;
use App\Http\Requests\SortieUpdateRequest;
use App\Models\Sortie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SortieController extends Controller
{
    public function index(Request $request): Response
    {
        $sorties = Sortie::all();

        return view('sortie.index', [
            'sorties' => $sorties,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('sortie.create');
    }

    public function store(SortieStoreRequest $request): Response
    {
        $sortie = Sortie::create($request->validated());

        $request->session()->flash('sortie.id', $sortie->id);

        return redirect()->route('sorties.index');
    }

    public function show(Request $request, Sortie $sortie): Response
    {
        return view('sortie.show', [
            'sortie' => $sortie,
        ]);
    }

    public function edit(Request $request, Sortie $sortie): Response
    {
        return view('sortie.edit', [
            'sortie' => $sortie,
        ]);
    }

    public function update(SortieUpdateRequest $request, Sortie $sortie): Response
    {
        $sortie->update($request->validated());

        $request->session()->flash('sortie.id', $sortie->id);

        return redirect()->route('sorties.index');
    }

    public function destroy(Request $request, Sortie $sortie): Response
    {
        $sortie->delete();

        return redirect()->route('sorties.index');
    }
}
