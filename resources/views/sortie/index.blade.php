@extends('layouts.app')

@section('title', 'Gestion des sorties')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Sorties</li>
                </ol>
            </nav>
        </div>

        <!-- Cartes de statistiques -->
        <div class="col-12 mb-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-1">Total des sorties</h6>
                                    <h3 class="mb-0">{{ number_format($totalMontant, 2, ',', ' ') }} FBU</h3>
                                </div>
                                <div class="bg-danger bg-opacity-25 p-3 rounded-circle">
                                    <i class="bi bi-currency-exchange fs-2 text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-1">Sorties ce mois</h6>
                                    <h3 class="mb-0">{{ number_format($sorties->where('date', '>=', now()->startOfMonth())->sum('montant'), 2, ',', ' ') }} FBU</h3>
                                </div>
                                <div class="bg-success bg-opacity-25 p-3 rounded-circle">
                                    <i class="bi bi-calendar-month fs-2 text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-1">Moyenne mensuelle</h6>
                                    <h3 class="mb-0">{{ number_format($sorties->avg('montant') ?? 0, 2, ',', ' ') }} FBU</h3>
                                </div>
                                <div class="bg-info bg-opacity-25 p-3 rounded-circle">
                                    <i class="bi bi-graph-up fs-2 text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- Filtres et tableau -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <a href="{{ route('sorties.create') }}" class="btn btn-primary ">
                        <i class="bi bi-plus-circle "></i>
                        <span>Nouvelle sortie</span>
                    </a>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Liste des sorties</h5>

                        <div class="d-flex">
                            <form action="{{ route('sorties.index') }}" method="GET" class="me-2">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Rechercher..."
                                           value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                                @forelse($sorties as $sortie)
                                    <tr>
                                        <td>{{ $sortie->date }}</td>
                                        <td class="fw-bold text-danger">-{{ number_format($sortie->montant, 2, ',', ' ') }} FBU</td>
                                        <td>{{ Str::limit($sortie->description, 50) }}</td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $sortie->category->couleur ?? '#6c757d' }}; color: white;">
                                                {{ $sortie->category->nom ?? 'Non définie' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="{{ route('sorties.edit', $sortie) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('sorties.destroy', $sortie) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette sortie ?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">Aucune sortie enregistrée pour le moment.</div>
                                            <a href="{{ route('sorties.create') }}" class="btn btn-primary mt-2">
                                                <i class="bi bi-plus-circle me-1"></i> Ajouter une sortie
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($sorties->hasPages())
                        <div class="card-footer bg-white">
                            {{ $sorties->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
