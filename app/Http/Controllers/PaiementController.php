<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaiementStoreRequest;
use App\Http\Requests\PaiementUpdateRequest;
use App\Models\Paiement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaiementController extends Controller
{
    public function index(Request $request): Response
    {
        $paiements = Paiement::all();

        return view('paiement.index', [
            'paiements' => $paiements,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('paiement.create');
    }

    public function store(PaiementStoreRequest $request): Response
    {
        $paiement = Paiement::create($request->validated());

        $request->session()->flash('paiement.id', $paiement->id);

        return redirect()->route('paiements.index');
    }

    public function show(Request $request, Paiement $paiement): Response
    {
        return view('paiement.show', [
            'paiement' => $paiement,
        ]);
    }

    public function edit(Request $request, Paiement $paiement): Response
    {
        return view('paiement.edit', [
            'paiement' => $paiement,
        ]);
    }

    public function update(PaiementUpdateRequest $request, Paiement $paiement): Response
    {
        $paiement->update($request->validated());

        $request->session()->flash('paiement.id', $paiement->id);

        return redirect()->route('paiements.index');
    }

    public function destroy(Request $request, Paiement $paiement): Response
    {
        $paiement->delete();

        return redirect()->route('paiements.index');
    }
}
