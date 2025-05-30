@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-6">
            <h1>Gestion des Versements</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('versements.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouveau Versement
            </a>
        </div>
    </div>

    <!-- Formulaire de recherche -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('versements.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Recherche</label>
                    <input type="text" name="search" id="search" class="form-control"
                           value="{{ request('search') }}" placeholder="Référence, description...">
                </div>
                <div class="col-md-2">
                    <label for="banque" class="form-label">Banque</label>
                    <select name="banque" id="banque" class="form-select">
                        <option value="">Toutes</option>
                        @foreach(['CRDB', 'BANCOBU', 'BCB', 'INTERBANK', 'KCB', 'BCAB', 'BBCI', 'BGEF', 'ECOBANK', 'FINBANK', 'OTHER'] as $banque)
                            <option value="{{ $banque }}" {{ request('banque') == $banque ? 'selected' : '' }}>
                                {{ $banque }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="category_id" class="form-label">Catégorie</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">Toutes</option>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
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

    <!-- Tableau des versements -->
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
                        @forelse($versements as $versement)
                            <tr>
                                <td>{{ $versement->date }}</td>
                                <td>{{ $versement->reference ?? '-' }}</td>
                                <td>{{ Str::limit($versement->description, 50) }}</td>
                                <td class="text-end">{{ number_format($versement->montant, 2, ',', ' ') }} FBU</td>
                                <td>{{ $versement->banque }}</td>
                                <td>{{ $versement->category->name }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('versements.show', $versement) }}" class="btn btn-sm btn-info"
                                           title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('versements.edit', $versement) }}" class="btn btn-sm btn-warning"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('versements.destroy', $versement) }}" method="POST"
                                              class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce versement ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @if($versement->attachment)
                                            <a href="{{ Storage::url($versement->attachment) }}"
                                               class="btn btn-sm btn-secondary" target="_blank" title="Voir la pièce jointe">
                                                <i class="fas fa-paperclip"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun versement trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($versements->count() > 0)
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total :</th>
                                <th class="text-end">{{ number_format($versements->sum('montant'), 2, ',', ' ') }} FCFA</th>
                                <th colspan="3"></th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $versements->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
