<?php

namespace App\Http\Controllers;

use App\Models\Entree;
use App\Models\Sortie;
use App\Models\Versement;
use App\Models\Paiement;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RapportController extends Controller
{
    /**
     * Affiche le formulaire de rapport avec les données du mois en cours
     */
    public function index()
    {
        $dateDebut = now()->startOfMonth();
        $dateFin = now()->endOfMonth();

        $data = $this->getRapportData($dateDebut, $dateFin);
        $data['categories'] = Category::all();
        $data['dateDebut'] = $dateDebut->format('Y-m-d');
        $data['dateFin'] = $dateFin->format('Y-m-d');

        return view('rapports.index', $data);
    }

    /**
     * Génère le rapport selon la période sélectionnée
     */
    public function genererRapport(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $dateDebut = Carbon::parse($request->date_debut)->startOfDay();
        $dateFin = Carbon::parse($request->date_fin)->endOfDay();

        $data = $this->getRapportData($dateDebut, $dateFin);
        $data['categories'] = Category::all();
        $data['dateDebut'] = $dateDebut->format('Y-m-d');
        $data['dateFin'] = $dateFin->format('Y-m-d');

        return view('rapports.index', $data);
    }

    /**
     * Récupère les données du rapport pour une période donnée
     */
    private function getRapportData($dateDebut, $dateFin)
    {
        // Récupération des sommes globales
        $sommeEntrees = Entree::whereBetween('date', [$dateDebut, $dateFin])
            ->sum('montant');

        $sommeSorties = Sortie::whereBetween('date', [$dateDebut, $dateFin])
            ->sum('montant');

        $sommeVersements = Versement::whereBetween('date', [$dateDebut, $dateFin])
            ->sum('montant');

        $sommePaiements = Paiement::whereBetween('date', [$dateDebut, $dateFin])
            ->sum('montant');

        // Récupération des données par catégorie
        $entreesParCategorie = Entree::with('category')
            ->selectRaw('category_id, SUM(montant) as total')
            ->whereBetween('date', [$dateDebut, $dateFin])
            ->groupBy('category_id')
            ->get();

        $sortiesParCategorie = Sortie::with('category')
            ->selectRaw('category_id, SUM(montant) as total')
            ->whereBetween('date', [$dateDebut, $dateFin])
            ->groupBy('category_id')
            ->get();

        $versementsParCategorie = Versement::with('category')
            ->selectRaw('category_id, SUM(montant) as total')
            ->whereBetween('date', [$dateDebut, $dateFin])
            ->groupBy('category_id')
            ->get();

        $paiementsParCategorie = Paiement::with('category')
            ->selectRaw('category_id, SUM(montant) as total')
            ->whereBetween('date', [$dateDebut, $dateFin])
            ->groupBy('category_id')
            ->get();

        return [
            'sommeEntrees' => $sommeEntrees,
            'sommeSorties' => $sommeSorties,
            'sommeVersements' => $sommeVersements,
            'sommePaiements' => $sommePaiements,
            'entreesParCategorie' => $entreesParCategorie,
            'sortiesParCategorie' => $sortiesParCategorie,
            'versementsParCategorie' => $versementsParCategorie,
            'paiementsParCategorie' => $paiementsParCategorie,
        ];
    }
}
