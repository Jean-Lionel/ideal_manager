<?php

namespace App\Http\Controllers;

use App\Http\Requests\VersementStoreRequest;
use App\Http\Requests\VersementUpdateRequest;
use App\Models\Versement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VersementController extends Controller
{
    public function index(Request $request): Response
    {
        $versements = Versement::all();

        return view('versement.index', [
            'versements' => $versements,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('versement.create');
    }

    public function store(VersementStoreRequest $request): Response
    {
        $versement = Versement::create($request->validated());

        $request->session()->flash('versement.id', $versement->id);

        return redirect()->route('versements.index');
    }

    public function show(Request $request, Versement $versement): Response
    {
        return view('versement.show', [
            'versement' => $versement,
        ]);
    }

    public function edit(Request $request, Versement $versement): Response
    {
        return view('versement.edit', [
            'versement' => $versement,
        ]);
    }

    public function update(VersementUpdateRequest $request, Versement $versement): Response
    {
        $versement->update($request->validated());

        $request->session()->flash('versement.id', $versement->id);

        return redirect()->route('versements.index');
    }

    public function destroy(Request $request, Versement $versement): Response
    {
        $versement->delete();

        return redirect()->route('versements.index');
    }
}
