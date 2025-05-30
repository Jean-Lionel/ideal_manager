@extends('layouts.app')

@section('title', 'Catégories')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Gestion des catégories</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouvelle catégorie
        </a>
    </div>

    <!-- Filtres de recherche -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('categories.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Recherche</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ request('search') }}" placeholder="Nom ou description...">
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">Tous les types</option>
                        <option value="entree" {{ request('type') == 'entree' ? 'selected' : '' }}>Entrée</option>
                        <option value="sortie" {{ request('type') == 'sortie' ? 'selected' : '' }}>Sortie</option>
                        <option value="paiement" {{ request('type') == 'paiement' ? 'selected' : '' }}>Paiement</option>
                        <option value="versement" {{ request('type') == 'versement' ? 'selected' : '' }}>Versement</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel"></i> Filtrer
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des catégories -->
    <div class="card">
        <div class="card-body">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Créé le</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->nom }}</td>
                                    <td>
                                        @php
                                            $typeLabels = [
                                                'entree' => 'Entrée',
                                                'sortie' => 'Sortie',
                                                'paiement' => 'Paiement',
                                                'versement' => 'Versement'
                                            ];
                                            $typeClass = [
                                                'entree' => 'success',
                                                'sortie' => 'danger',
                                                'paiement' => 'info',
                                                'versement' => 'warning'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $typeClass[$category->type] ?? 'secondary' }}">
                                            {{ $typeLabels[$category->type] ?? $category->type }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($category->description, 50) }}</td>
                                    <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="mt-3">
                    {{ $categories->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-folder-x" style="font-size: 3rem; opacity: 0.2;"></i>
                    <p class="mt-3">Aucune catégorie trouvée</p>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-lg"></i> Créer une catégorie
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
