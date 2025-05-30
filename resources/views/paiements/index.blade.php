@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-6">
            <h1>Gestion des Paiements</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('paiements.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouveau Paiement
            </a>
        </div>
    </div>

    <!-- Formulaire de recherche -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('paiements.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Recherche</label>
                    <input type="text" name="search" id="search" class="form-control"
                           value="{{ request('search') }}" placeholder="Référence, description...">
                </div>
                <div class="col-md-2">
                    <label for="banque" class="form-label">Banque</label>
                    <input type="text" name="banque" id="banque" class="form-control"
                           value="{{ request('banque') }}" placeholder="Nom de la banque">
                </div>
                <div class="col-md-2">
                    <label for="category_id" class="form-label">Catégorie</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">Toutes</option>
                        @foreach(\App\Models\Category::where('type', 'paiement')->get() as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_debut" class="form-label">Date début</label>
                    <input type="date" name="date_debut" id="date_debut" class="form-control"
                           value="{{ request('date_debut') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_fin" class="form-label">Date fin</label>
                    <input type="date" name="date_fin" id="date_fin" class="form-control"
                           value="{{ request('date_fin') }}">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des paiements -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Référence</th>
                            <th>Description</th>
                            <th class="text-end">Montant</th>
                            <th>Banque</th>
                            <th>Catégorie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements as $paiement)
                            <tr>
                                <td>{{ $paiement->date }}</td>
                                <td>{{ $paiement->reference ?? '-' }}</td>
                                <td>{{ Str::limit($paiement->description, 50) }}</td>
                                <td class="text-end">{{ number_format($paiement->montant, 4, ',', ' ') }} FBU</td>
                                <td>{{ $paiement->banque ?? '-' }}</td>
                                <td>{{ $paiement->category->nom }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('paiements.show', $paiement) }}" class="btn btn-sm btn-info"
                                           title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('paiements.edit', $paiement) }}" class="btn btn-sm btn-warning"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('paiements.destroy', $paiement) }}" method="POST"
                                              class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @if($paiement->attachment)
                                            <a href="{{ Storage::url($paiement->attachment) }}"
                                               class="btn btn-sm btn-secondary" target="_blank" title="Voir la pièce jointe">
                                                <i class="fas fa-paperclip"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun paiement trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($paiements->count() > 0)
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total :</th>
                                <th class="text-end">{{ number_format($paiements->sum('montant'), 4, ',', ' ') }} FBU</th>
                                <th colspan="3"></th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $paiements->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
