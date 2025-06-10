<?php

namespace App\Http\Controllers;

use App\Models\Entree;
use App\Models\Paiement;
use App\Models\Sortie;
use App\Models\Versement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        // Sortie
        $sorties = Sortie::all()->sum('montant');
        // Entre
        $entres = Entree::all()->sum('montant');
        // Versement
        $versements = Versement::all()->sum('montant');
        // Paiements
        $paiements = Paiement::all()->sum('montant');

        return view('dashboard', compact('sorties', 'entres', 'versements', 'paiements'));
    }
}
