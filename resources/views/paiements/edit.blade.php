@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Modifier le Paiement</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('paiements.show', $paiement) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux détails
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('paiements.update', $paiement) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        @include('paiements._form')
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de l'affichage du nom du fichier sélectionné
        const fileInput = document.getElementById('attachment');
        if (fileInput) {
            // Afficher le nom du fichier existant s'il y en a un
            const existingFile = '{{ $paiement->attachment ? 'Fichier actuel : ' . basename($paiement->attachment) : '' }}';
            if (existingFile) {
                const existingFileLabel = document.createElement('small');
                existingFileLabel.className = 'form-text text-muted d-block mt-1';
                existingFileLabel.textContent = existingFile;
                existingFileLabel.id = 'current-file';
                fileInput.parentNode.appendChild(existingFileLabel);
            }

            // Gestion du changement de fichier
            fileInput.addEventListener('change', function(e) {
                const fileName = e.target.files[0]
                    ? 'Nouveau fichier : ' + e.target.files[0].name
                    : 'Aucun fichier sélectionné';

                // Mettre à jour ou créer le label
                let fileLabel = document.querySelector('#attachment + small.form-text');
                if (!fileLabel) {
                    fileLabel = document.createElement('small');
                    fileLabel.className = 'form-text text-muted d-block mt-1';
                    fileLabel.id = 'file-selected';
                    fileInput.parentNode.appendChild(fileLabel);
                }

                fileLabel.textContent = fileName;

                // Cacher le label du fichier actuel si un nouveau fichier est sélectionné
                const currentFileLabel = document.getElementById('current-file');
                if (currentFileLabel && e.target.files.length > 0) {
                    currentFileLabel.style.display = 'none';
                } else if (currentFileLabel) {
                    currentFileLabel.style.display = 'block';
                }
            });
        }
    });
</script>
@endpush
@endsection
