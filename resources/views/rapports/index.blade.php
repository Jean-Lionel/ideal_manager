@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-graph-up me-3" style="font-size: 1.5rem;"></i>
                        <h3 class="mb-0 fw-bold">Rapport Financier</h3>
                    </div>
                    <div class="badge bg-light text-dark fs-6 px-3 py-2">
                        <i class="bi bi-calendar-range me-2"></i>
                        {{ \Carbon\Carbon::parse($dateDebut)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($dateFin)->translatedFormat('d M Y') }}
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Formulaire de filtre -->
                    <div class="card mb-4 border-0 bg-light">
                        <div class="card-body">
                            <form method="GET" action="{{ route('rapports.generer') }}">
                                @csrf
                                <div class="row align-items-end g-3">
                                    <div class="col-md-4">
                                        <label for="date_debut" class="form-label fw-semibold">
                                            <i class="bi bi-calendar-event me-2"></i>Date de début
                                        </label>
                                        <input type="date" name="date_debut" id="date_debut" class="form-control form-control-lg"
                                               value="{{ $dateDebut ?? old('date_debut', now()->startOfMonth()->format('Y-m-d')) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="date_fin" class="form-label fw-semibold">
                                            <i class="bi bi-calendar-check me-2"></i>Date de fin
                                        </label>
                                        <input type="date" name="date_fin" id="date_fin" class="form-control form-control-lg"
                                               value="{{ $dateFin ?? old('date_fin', now()->format('Y-m-d')) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="bi bi-search me-2"></i>Générer le rapport
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Cartes principales -->
                    <div class="row g-4 mb-4">
                        <!-- Carte des entrées -->
                        <div class="col-lg-6 col-xl-3">
                            <div class="card h-100 border-0 shadow-sm card-hover">
                                <div class="card-header bg-gradient-success text-white border-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0 fw-bold">Entrées</h5>
                                        <i class="bi bi-arrow-down-circle" style="font-size: 1.5rem;"></i>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h2 class="display-6 fw-bold text-success mb-3">
                                        {{ number_format($sommeEntrees ?? 0, 0, ',', ' ') }} <small class="text-muted">FBU</small>
                                    </h2>

                                    @if(isset($entreesParCategorie) && $entreesParCategorie->count() > 0)
                                        <div class="mt-3">
                                            <h6 class="text-muted mb-3">
                                                <i class="bi bi-pie-chart me-2"></i>Répartition par catégorie
                                            </h6>
                                            @foreach($entreesParCategorie as $entree)
                                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                                    <span class="fw-medium">{{ $entree->category->nom ?? 'Non catégorisé' }}</span>
                                                    <span class="badge bg-success fs-6">
                                                        {{ number_format($entree->total, 0, ',', ' ') }} FBU
                                                    </span>
                                                </div>
                                                <div class="progress mb-2" style="height: 4px;">
                                                    <div class="progress-bar bg-success" style="width: {{ $sommeEntrees > 0 ? ($entree->total / $sommeEntrees) * 100 : 0 }}%"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Carte des sorties -->
                        <div class="col-lg-6 col-xl-3">
                            <div class="card h-100 border-0 shadow-sm card-hover">
                                <div class="card-header bg-gradient-danger text-white border-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0 fw-bold">Sorties</h5>
                                        <i class="bi bi-arrow-up-circle" style="font-size: 1.5rem;"></i>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h2 class="display-6 fw-bold text-danger mb-3">
                                        {{ number_format($sommeSorties ?? 0, 0, ',', ' ') }} <small class="text-muted">FBU</small>
                                    </h2>

                                    @if(isset($sortiesParCategorie) && $sortiesParCategorie->count() > 0)
                                        <div class="mt-3">
                                            <h6 class="text-muted mb-3">
                                                <i class="bi bi-pie-chart me-2"></i>Répartition par catégorie
                                            </h6>
                                            @foreach($sortiesParCategorie as $sortie)
                                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                                    <span class="fw-medium">{{ $sortie->category->nom ?? 'Non catégorisé' }}</span>
                                                    <span class="badge bg-danger fs-6">
                                                        {{ number_format($sortie->total, 0, ',', ' ') }} FBU
                                                    </span>
                                                </div>
                                                <div class="progress mb-2" style="height: 4px;">
                                                    <div class="progress-bar bg-danger" style="width: {{ $sommeSorties > 0 ? ($sortie->total / $sommeSorties) * 100 : 0 }}%"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Carte des versements -->
                        <div class="col-lg-6 col-xl-3">
                            <div class="card h-100 border-0 shadow-sm card-hover">
                                <div class="card-header bg-gradient-primary text-white border-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0 fw-bold">Versements</h5>
                                        <i class="bi bi-bank" style="font-size: 1.5rem;"></i>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h2 class="display-6 fw-bold text-primary mb-3">
                                        {{ number_format($sommeVersements ?? 0, 0, ',', ' ') }} <small class="text-muted">FBU</small>
                                    </h2>

                                    @if(isset($versementsParCategorie) && $versementsParCategorie->count() > 0)
                                        <div class="mt-3">
                                            <h6 class="text-muted mb-3">
                                                <i class="bi bi-pie-chart me-2"></i>Répartition par catégorie
                                            </h6>
                                            @foreach($versementsParCategorie as $versement)
                                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                                    <span class="fw-medium">{{ $versement->category->nom ?? 'Non catégorisé' }}</span>
                                                    <span class="badge bg-primary fs-6">
                                                        {{ number_format($versement->total, 0, ',', ' ') }} FBU
                                                    </span>
                                                </div>
                                                <div class="progress mb-2" style="height: 4px;">
                                                    <div class="progress-bar bg-primary" style="width: {{ $sommeVersements > 0 ? ($versement->total / $sommeVersements) * 100 : 0 }}%"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Carte des paiements -->
                        <div class="col-lg-6 col-xl-3">
                            <div class="card h-100 border-0 shadow-sm card-hover">
                                <div class="card-header bg-gradient-info text-white border-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="mb-0 fw-bold">Paiements</h5>
                                        <i class="bi bi-credit-card" style="font-size: 1.5rem;"></i>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h2 class="display-6 fw-bold text-info mb-3">
                                        {{ number_format($sommePaiements ?? 0, 0, ',', ' ') }} <small class="text-muted">FBU</small>
                                    </h2>

                                    @if(isset($paiementsParCategorie) && $paiementsParCategorie->count() > 0)
                                        <div class="mt-3">
                                            <h6 class="text-muted mb-3">
                                                <i class="bi bi-pie-chart me-2"></i>Répartition par catégorie
                                            </h6>
                                            @foreach($paiementsParCategorie as $paiement)
                                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                                    <span class="fw-medium">{{ $paiement->category->nom ?? 'Non catégorisé' }}</span>
                                                    <span class="badge bg-info fs-6">
                                                        {{ number_format($paiement->total, 0, ',', ' ') }} FBU
                                                    </span>
                                                </div>
                                                <div class="progress mb-2" style="height: 4px;">
                                                    <div class="progress-bar bg-info" style="width: {{ $sommePaiements > 0 ? ($paiement->total / $sommePaiements) * 100 : 0 }}%"></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bilan global -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-lg">
                                <div class="card-header bg-dark text-white border-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calculator me-3" style="font-size: 1.5rem;"></i>
                                        <h4 class="mb-0 fw-bold">Bilan Global</h4>
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    @php
                                        $totalEntrees = $sommeEntrees ?? 0;
                                        $totalSorties = $sommeSorties ?? 0;
                                        $totalVersements = $sommeVersements ?? 0;
                                        $totalPaiements = $sommePaiements ?? 0;
                                        $solde = ($totalEntrees + $totalPaiements) - ($totalSorties + $totalVersements);
                                        $totalRecettes = $totalEntrees + $totalPaiements;
                                        $totalDepenses = $totalSorties + $totalVersements;
                                    @endphp

                                    <div class="row g-4 text-center">
                                        <div class="col-md-6 col-lg-3">
                                            <div class="p-3 bg-success bg-opacity-10 rounded-3">
                                                <i class="bi bi-arrow-down-circle text-success mb-2" style="font-size: 2rem;"></i>
                                                <h6 class="text-muted mb-1">Total Recettes</h6>
                                                <h3 class="text-success fw-bold mb-0">{{ number_format($totalRecettes, 0, ',', ' ') }} FBU</h3>
                                                <small class="text-muted">Entrées + Paiements</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="p-3 bg-danger bg-opacity-10 rounded-3">
                                                <i class="bi bi-arrow-up-circle text-danger mb-2" style="font-size: 2rem;"></i>
                                                <h6 class="text-muted mb-1">Total Dépenses</h6>
                                                <h3 class="text-danger fw-bold mb-0">{{ number_format($totalDepenses, 0, ',', ' ') }} FBU</h3>
                                                <small class="text-muted">Sorties + Versements</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="p-3 bg-info bg-opacity-10 rounded-3">
                                                <i class="bi bi-percent text-info mb-2" style="font-size: 2rem;"></i>
                                                <h6 class="text-muted mb-1">Taux d'épargne</h6>
                                                <h3 class="text-info fw-bold mb-0">
                                                    {{ $totalRecettes > 0 ? number_format(($solde / $totalRecettes) * 100, 1) : 0 }}%
                                                </h3>
                                                <small class="text-muted">Solde / Recettes</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="p-3 {{ $solde >= 0 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 rounded-3">
                                                <i class="bi bi-{{ $solde >= 0 ? 'plus' : 'dash' }}-circle {{ $solde >= 0 ? 'text-success' : 'text-danger' }} mb-2" style="font-size: 2rem;"></i>
                                                <h6 class="text-muted mb-1">Solde Final</h6>
                                                <h3 class="fw-bold mb-0 {{ $solde >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $solde >= 0 ? '+' : '-' }}{{ number_format(abs($solde), 0, ',', ' ') }} FBU
                                                </h3>
                                                <small class="text-muted">{{ $solde >= 0 ? 'Excédent' : 'Déficit' }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Graphique de répartition -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="bg-light p-3 rounded-3">
                                                <h6 class="mb-3 fw-semibold">
                                                    <i class="bi bi-bar-chart me-2"></i>Répartition des flux financiers
                                                </h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="progress mb-2" style="height: 20px;">
                                                            <div class="progress-bar bg-success" style="width: {{ $totalRecettes > 0 ? ($totalEntrees / $totalRecettes) * 100 : 0 }}%">
                                                                Entrées ({{ $totalRecettes > 0 ? round(($totalEntrees / $totalRecettes) * 100, 1) : 0 }}%)
                                                            </div>
                                                            <div class="progress-bar bg-info" style="width: {{ $totalRecettes > 0 ? ($totalPaiements / $totalRecettes) * 100 : 0 }}%">
                                                                Paiements ({{ $totalRecettes > 0 ? round(($totalPaiements / $totalRecettes) * 100, 1) : 0 }}%)
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">Répartition des recettes</small>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="progress mb-2" style="height: 20px;">
                                                            <div class="progress-bar bg-danger" style="width: {{ $totalDepenses > 0 ? ($totalSorties / $totalDepenses) * 100 : 0 }}%">
                                                                Sorties ({{ $totalDepenses > 0 ? round(($totalSorties / $totalDepenses) * 100, 1) : 0 }}%)
                                                            </div>
                                                            <div class="progress-bar bg-primary" style="width: {{ $totalDepenses > 0 ? ($totalVersements / $totalDepenses) * 100 : 0 }}%">
                                                                Versements ({{ $totalDepenses > 0 ? round(($totalVersements / $totalDepenses) * 100, 1) : 0 }}%)
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">Répartition des dépenses</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: #0d6efd;
    }
    .bg-gradient-success {
        background: #1cc88a;
    }
    .bg-gradient-danger {
        background: #e74a3b;
    }
    .bg-gradient-info {
        background: #36b9cc;
    }

    

    .progress {
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        font-size: 0.75rem;
        font-weight: 600;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }

    .display-6 {
        font-size: 2rem;
    }

    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }

    .rounded-3 {
        border-radius: 0.5rem !important;
    }

    .card {
        border-radius: 1rem;
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
        padding: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .badge {
        font-weight: 500;
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 0.5rem;
    }

    .form-control-lg {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        border: 2px solid #e3e6f0;
        transition: all 0.3s ease;
    }

    .form-control-lg:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .form-label {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
</style>
@endsection
