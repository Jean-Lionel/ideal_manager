@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Rapport Financier</h3>
                    <div class="badge badge-primary">
                        {{ \Carbon\Carbon::parse($dateDebut)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($dateFin)->translatedFormat('d M Y') }}
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('rapports.generer') }}" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_debut">Date de début :</label>
                                    <input type="date" name="date_debut" id="date_debut" class="form-control"
                                           value="{{ $dateDebut ?? old('date_debut', now()->startOfMonth()->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_fin">Date de fin :</label>
                                    <input type="date" name="date_fin" id="date_fin" class="form-control"
                                           value="{{ $dateFin ?? old('date_fin', now()->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Générer le rapport</button>
                            </div>
                        </div>
                    </form>


                    <div class="row">
                        <!-- Carte des entrées -->
                        <div class="col-md-6 mb-4">
                            <div class="card bg-light">
                                <div class="card-header bg-success text-white">
                                    <h4 class="mb-0">Entrées</h4>
                                </div>
                                <div class="card-body">
                                    <h2 class="text-center">{{ number_format($sommeEntrees ?? 0, 0, ',', ' ') }} FBU</h2>

                                    @if(isset($entreesParCategorie) && $entreesParCategorie->count() > 0)
                                        <div class="mt-3">
                                            <h5>Par catégorie :</h5>
                                            <ul class="list-group">
                                                @foreach($entreesParCategorie as $entree)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $entree->category->name ?? 'Non catégorisé' }}
                                                        <span class="badge badge-success badge-pill">{{ number_format($entree->total, 0, ',', ' ') }}
                                                            FBU
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <!-- Carte des sorties -->
                        <div class="col-md-6 mb-4">
                            <div class="card bg-light">
                                <div class="card-header bg-danger text-white">
                                    <h4 class="mb-0">Sorties</h4>
                                </div>
                                <div class="card-body">
                                    <h2 class="text-center">{{ number_format($sommeSorties ?? 0, 0, ',', ' ') }} FBU</h2>

                                    @if(isset($sortiesParCategorie) && $sortiesParCategorie->count() > 0)
                                        <div class="mt-3">
                                            <h5>Par catégorie :</h5>
                                            <ul class="list-group">
                                                @foreach($sortiesParCategorie as $sortie)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $sortie->category->name ?? 'Non catégorisé' }}
                                                        <span class="badge badge-danger badge-pill">{{ number_format($sortie->total, 0, ',', ' ') }} FBU</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <!-- Carte des versements -->
                        <div class="col-md-6 mb-4">
                            <div class="card bg-light">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0">Versements</h4>
                                </div>
                                <div class="card-body">
                                    <h2 class="text-center">{{ number_format($sommeVersements ?? 0, 0, ',', ' ') }} FBU</h2>

                                    @if(isset($versementsParCategorie) && $versementsParCategorie->count() > 0)
                                        <div class="mt-3">
                                            <h5>Par catégorie :</h5>
                                            <ul class="list-group">
                                                @foreach($versementsParCategorie as $versement)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $versement->category->name ?? 'Non catégorisé' }}
                                                        <span class="badge badge-primary badge-pill">{{ number_format($versement->total, 0, ',', ' ') }} FBU</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <!-- Carte des paiements -->
                        <div class="col-md-6 mb-4">
                            <div class="card bg-light">
                                <div class="card-header bg-info text-white">
                                    <h4 class="mb-0">Paiements</h4>
                                </div>
                                <div class="card-body">
                                    <h2 class="text-center">{{ number_format($sommePaiements ?? 0, 0, ',', ' ') }} FBU</h2>

                                    @if(isset($paiementsParCategorie) && $paiementsParCategorie->count() > 0)
                                        <div class="mt-3">
                                            <h5>Par catégorie :</h5>
                                            <ul class="list-group">
                                                @foreach($paiementsParCategorie as $paiement)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $paiement->category->name ?? 'Non catégorisé' }}
                                                        <span class="badge badge-info badge-pill">{{ number_format($paiement->total, 0, ',', ' ') }} FBU</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bilan global -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-dark text-white">
                                    <h4 class="mb-0">Bilan Global</h4>
                                </div>
                                <div class="card-body">
                                    @php
                                        $totalEntrees = $sommeEntrees ?? 0;
                                        $totalSorties = $sommeSorties ?? 0;
                                        $totalVersements = $sommeVersements ?? 0;
                                        $totalPaiements = $sommePaiements ?? 0;

                                        $solde = ($totalEntrees + $totalPaiements) - ($totalSorties + $totalVersements);
                                    @endphp

                                    <div class="row text-center">
                                        <div class="col-md-3">
                                            <h5>Total Entrées</h5>
                                            <h3 class="text-success">{{ number_format($totalEntrees, 0, ',', ' ') }} FBU</h3>
                                        </div>
                                        <div class="col-md-3">
                                            <h5>Total Sorties</h5>
                                            <h3 class="text-danger">{{ number_format($totalSorties, 0, ',', ' ') }} FBU</h3>
                                        </div>
                                        <div class="col-md-3">
                                            <h5>Total Paiements</h5>
                                            <h3 class="text-info">{{ number_format($totalPaiements, 0, ',', ' ') }} FBU</h3>
                                        </div>
                                        <div class="col-md-3">
                                            <h5>Solde</h5>
                                            <h3 class="font-weight-bold {{ $solde >= 0 ? 'text-success' : 'text-danger' }}">
                                                {{ number_format(abs($solde), 0, ',', ' ') }} FBU
                                                @if($solde < 0) (Déficit) @endif
                                            </h3>
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
    .card {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
        padding: 1rem 1.25rem;
    }
    .card-body h2 {
        font-weight: 600;
        margin: 0;
    }
    .btn-primary {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    .btn-primary:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
    }
    .badge-pill {
        padding: 0.5em 0.8em;
        font-size: 0.9em;
    }
    .list-group-item {
        border-left: none;
        border-right: none;
    }
    .list-group-item:first-child {
        border-top: none;
    }
    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
@endsection
