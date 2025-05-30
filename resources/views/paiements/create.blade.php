@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Nouveau Paiement</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('paiements.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('paiements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        @include('paiements._form', ['paiement' => new App\Models\Paiement()])
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Script pour la gestion des fichiers
    document.addEventListener('DOMContentLoaded', function() {
        // Afficher le nom du fichier sélectionné
        const fileInput = document.getElementById('attachment');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'Aucun fichier sélectionné';
                const fileLabel = document.createElement('small');
                fileLabel.className = 'form-text text-muted';
                fileLabel.textContent = fileName;

                // Supprimer l'ancien label s'il existe
                const oldLabel = document.querySelector('#attachment + small.form-text');
                if (oldLabel) {
                    oldLabel.remove();
                }

                // Ajouter le nouveau label
                fileInput.parentNode.appendChild(fileLabel);
            });
        }
    });
</script>
@endpush
@endsection
