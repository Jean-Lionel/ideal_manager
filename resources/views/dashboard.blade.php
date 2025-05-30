@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid">
    <!-- En-tête du tableau de bord -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Tableau de bord</h1>
        <div class="btn-group">
            <button class="btn btn-outline-secondary">
                <i class="bi bi-calendar"></i> Ce mois-ci
            </button>
            <button class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Nouvelle transaction
            </button>
        </div>
    </div>

    <!-- Cartes de synthèse -->
    <div class="row g-4 mb-4">
        <!-- Solde total -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 bg-primary bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Solde total</h6>
                            <h3 class="mb-0">0 FBU</h3>
                        </div>
                        <div class="bg-primary bg-opacity-25 p-3 rounded-circle">
                            <i class="bi bi-wallet2 text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success"><i class="bi bi-arrow-up"></i> 0% ce mois-ci</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenus -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 bg-success bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Revenus</h6>
                            <h3 class="mb-0">0 FBU</h3>
                        </div>
                        <div class="bg-success bg-opacity-25 p-3 rounded-circle">
                            <i class="bi bi-arrow-down-circle text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success"><i class="bi bi-arrow-up"></i> 0% ce mois-ci</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dépenses -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 bg-danger bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Dépenses</h6>
                            <h3 class="mb-0">0 FBU</h3>
                        </div>
                        <div class="bg-danger bg-opacity-25 p-3 rounded-circle">
                            <i class="bi bi-arrow-up-circle text-danger" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-danger"><i class="bi bi-arrow-up"></i> 0% ce mois-ci</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Épargne -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 bg-warning bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Épargne</h6>
                            <h3 class="mb-0">0 FBU</h3>
                        </div>
                        <div class="bg-warning bg-opacity-25 p-3 rounded-circle">
                            <i class="bi bi-piggy-bank text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-success"><i class="bi bi-arrow-up"></i> 0% ce mois-ci</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et tableaux -->
    <div class="row g-4">
        <!-- Graphique des revenus et dépenses -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Activité récente</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <!-- L'espace pour le graphique sera ajouté dynamiquement -->
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="text-center">
                                <i class="bi bi-bar-chart-line" style="font-size: 3rem; opacity: 0.2;"></i>
                                <p class="mt-2 text-muted">Aucune donnée à afficher pour le moment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Catégories de dépenses -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Catégories de dépenses</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Alimentation</span>
                            <span>0%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%; background-color: #4e73df;"></div>
                        </div>
                    </div>
                    <!-- Ajoutez d'autres catégories ici -->
                    <div class="text-center mt-4">
                        <i class="bi bi-pie-chart" style="font-size: 3rem; opacity: 0.2;"></i>
                        <p class="mt-2 text-muted">Aucune donnée à afficher</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières transactions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dernières transactions</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Catégorie</th>
                                    <th class="text-end">Montant</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-credit-card" style="font-size: 2rem; opacity: 0.2;"></i>
                                        <p class="mt-2 text-muted">Aucune transaction récente</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
