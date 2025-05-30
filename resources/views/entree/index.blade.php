@extends('layouts.app')

@section('title', 'Gestion des entrées')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .table-responsive {
        overflow-x: auto;
    }
    .total-amount {
        font-size: 1.25rem;
        font-weight: bold;
    }
    .badge-income {
        background-color: #198754;
    }
    .badge-expense {
        background-color: #dc3545;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Entrées</li>
                </ol>
            </nav>
        </div>

        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Gestion des entrées</h1>
                <a href="{{ route('entrees.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Nouvelle entrée
                </a>
            </div>

            <!-- Carte de synthèse -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-primary bg-opacity-10">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-1">Total des entrées</h6>
                                    <h3 class="mb-0">{{ number_format($totalMontant, 2, ',', ' ') }} FCFA</h3>
                                </div>
                                <div class="bg-primary bg-opacity-25 p-3 rounded-circle">
                                    <i class="bi bi-currency-exchange fs-2 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-success bg-opacity-10">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-1">Entrées ce mois</h6>
                                    <h3 class="mb-0">{{ number_format($entrees->where('date', '>=', now()->startOfMonth())->sum('montant'), 2, ',', ' ') }} FCFA</h3>
                                </div>
                                <div class="bg-success bg-opacity-25 p-3 rounded-circle">
                                    <i class="bi bi-calendar-month fs-2 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-info bg-opacity-10">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-1">Moyenne mensuelle</h6>
                                    <h3 class="mb-0">{{ number_format($entrees->avg('montant') ?? 0, 2, ',', ' ') }} FCFA</h3>
                                </div>
                                <div class="bg-info bg-opacity-25 p-3 rounded-circle">
                                    <i class="bi bi-graph-up fs-2 text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtres -->
            @livewire('entree.entree-filter')

            <!-- Tableau des entrées -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Description</th>
                                    <th>Catégorie</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($entrees as $entree)
                                    <tr>
                                        <td>{{ $entree->date->format('d/m/Y') }}</td>
                                        <td class="fw-bold text-success">+{{ number_format($entree->montant, 2, ',', ' ') }} FCFA</td>
                                        <td>{{ Str::limit($entree->description, 50) }}</td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $entree->category->couleur ?? '#6c757d' }}; color: white;">
                                                {{ $entree->category->nom ?? 'Non catégorisé' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('entrees.edit', $entree) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirm('Êtes-vous sûr de vouloir supprimer cette entrée ?') ? document.getElementById('delete-form-{{ $entree->id }}').submit() : ''">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $entree->id }}" action="{{ route('entrees.destroy', $entree) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-database-exclamation fs-1"></i>
                                                <p class="mt-2 mb-0">Aucune entrée trouvée</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($entrees->hasPages())
                        <div class="card-footer bg-transparent">
                            {{ $entrees->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
<script>
    document.addEventListener('livewire:load', function() {
        // Initialiser les datepickers
        flatpickr("input[type=date]", {
            locale: 'fr',
            dateFormat: 'Y-m-d',
            allowInput: true
        });

        // Gérer les événements Livewire
        Livewire.on('filtersUpdated', filters => {
            // Mettre à jour l'URL sans recharger la page
            let url = new URL(window.location.href);

            if (filters.search) url.searchParams.set('search', filters.search);
            else url.searchParams.delete('search');

            if (filters.date_debut) url.searchParams.set('date_debut', filters.date_debut);
            else url.searchParams.delete('date_debut');

            if (filters.date_fin) url.searchParams.set('date_fin', filters.date_fin);
            else url.searchParams.delete('date_fin');

            if (filters.category_id) url.searchParams.set('category_id', filters.category_id);
            else url.searchParams.delete('category_id');

            window.history.pushState({}, '', url);

            // Recharger la page avec les nouveaux filtres
            window.livewire.emit('refreshEntrees');
        });
    });
</script>
@endpush
