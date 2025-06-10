<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Entree;
use App\Models\Sortie;
use App\Models\Versement;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RapportController extends Controller
{
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

    public function generer(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin = Carbon::parse($request->date_fin);

        $data = $this->getRapportData($dateDebut, $dateFin);
        $data['categories'] = Category::all();
        $data['dateDebut'] = $dateDebut->format('Y-m-d');
        $data['dateFin'] = $dateFin->format('Y-m-d');

        return view('rapports.index', $data);
    }

    private function getRapportData($dateDebut, $dateFin)
    {
        // Récupération des sommes globales avec optimisation
        $sommeEntrees = Entree::whereBetween('date', [$dateDebut, $dateFin])
            ->sum('montant');

        $sommeSorties = Sortie::whereBetween('date', [$dateDebut, $dateFin])
            ->sum('montant');

        $sommeVersements = Versement::whereBetween('date', [$dateDebut, $dateFin])
            ->sum('montant');

        $sommePaiements = Paiement::whereBetween('date', [$dateDebut, $dateFin])
            ->sum('montant');

        // Récupération des données par catégorie avec eager loading
        $entreesParCategorie = Entree::with(['category' => function($query) {
                $query->select('id', 'nom', 'type');
            }])
            ->selectRaw('category_id, SUM(montant) as total')
            ->whereBetween('date', [$dateDebut, $dateFin])
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();

        $sortiesParCategorie = Sortie::with(['category' => function($query) {
                $query->select('id', 'nom', 'type');
            }])
            ->selectRaw('category_id, SUM(montant) as total')
            ->whereBetween('date', [$dateDebut, $dateFin])
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();

        $versementsParCategorie = Versement::with(['category' => function($query) {
                $query->select('id', 'nom', 'type');
            }])
            ->selectRaw('category_id, SUM(montant) as total')
            ->whereBetween('date', [$dateDebut, $dateFin])
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();

        $paiementsParCategorie = Paiement::with(['category' => function($query) {
                $query->select('id', 'nom', 'type');
            }])
            ->selectRaw('category_id, SUM(montant) as total')
            ->whereBetween('date', [$dateDebut, $dateFin])
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->get();

        // Calcul des statistiques additionnelles
        $totalRecettes = $sommeEntrees + $sommePaiements;
        $totalDepenses = $sommeSorties + $sommeVersements;
        $solde = $totalRecettes - $totalDepenses;

        // Récupération des montants sans catégorie
        $entreesNonCategorisees = Entree::whereBetween('date', [$dateDebut, $dateFin])
            ->whereNull('category_id')
            ->sum('montant');

        $sortiesNonCategorisees = Sortie::whereBetween('date', [$dateDebut, $dateFin])
            ->whereNull('category_id')
            ->sum('montant');

        $versementsNonCategorises = Versement::whereBetween('date', [$dateDebut, $dateFin])
            ->whereNull('category_id')
            ->sum('montant');

        $paiementsNonCategorises = Paiement::whereBetween('date', [$dateDebut, $dateFin])
            ->whereNull('category_id')
            ->sum('montant');

        return [
            'sommeEntrees' => $sommeEntrees,
            'sommeSorties' => $sommeSorties,
            'sommeVersements' => $sommeVersements,
            'sommePaiements' => $sommePaiements,
            'entreesParCategorie' => $entreesParCategorie,
            'sortiesParCategorie' => $sortiesParCategorie,
            'versementsParCategorie' => $versementsParCategorie,
            'paiementsParCategorie' => $paiementsParCategorie,
            // Statistiques additionnelles
            'totalRecettes' => $totalRecettes,
            'totalDepenses' => $totalDepenses,
            'solde' => $solde,
            'tauxEpargne' => $totalRecettes > 0 ? ($solde / $totalRecettes) * 100 : 0,
            // Montants non catégorisés
            'entreesNonCategorisees' => $entreesNonCategorisees,
            'sortiesNonCategorisees' => $sortiesNonCategorisees,
            'versementsNonCategorises' => $versementsNonCategorises,
            'paiementsNonCategorises' => $paiementsNonCategorises,
        ];
    }

    
}
