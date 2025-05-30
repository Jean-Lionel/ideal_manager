@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-6">
            <h1>Détails du Versement</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('versements.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 40%">Date</th>
                            <td>{{ $versement->date }}</td>
                        </tr>
                        <tr>
                            <th>Référence</th>
                            <td>{{ $versement->reference ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Montant</th>
                            <td class="fw-bold">{{ number_format($versement->montant, 2, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <th>Banque</th>
                            <td>{{ $versement->banque }}</td>
                        </tr>
                        <tr>
                            <th>Catégorie</th>
                            <td>{{ $versement->category->name }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <h5>Description</h5>
                        <p class="border p-3 rounded">
                            {{ $versement->description ?? 'Aucune description' }}
                        </p>
                    </div>

                    @if($versement->attachment)
                        <div class="mb-3">
                            <h5>Pièce jointe</h5>
                            <a href="{{ Storage::url($versement->attachment) }}"
                               class="btn btn-outline-primary" target="_blank">
                                <i class="fas fa-download"></i> Télécharger le fichier
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <div>
                    <p class="text-muted mb-0">
                        <small>Créé le {{ $versement->created_at->format('d/m/Y à H:i') }}</small>
                    </p>
                    @if($versement->created_at != $versement->updated_at)
                        <p class="text-muted mb-0">
                            <small>Dernière mise à jour le {{ $versement->updated_at->format('d/m/Y à H:i') }}</small>
                        </p>
                    @endif
                </div>
                <div>
                    <a href="{{ route('versements.edit', $versement) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('versements.destroy', $versement) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce versement ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
