@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-6">
            <h1>Modifier le Versement</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('versements.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Annuler
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('versements.update', $versement) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        @include('versements._form')
                    </div>
                </div>
            </form>

            <hr class="my-4">

            <div class="mt-4">
                <h5>Zone de suppression</h5>
                <p class="text-muted">
                    La suppression est irréversible. Toutes les données associées à ce versement seront supprimées.
                </p>
                <form action="{{ route('versements.destroy', $versement) }}" method="POST"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce versement ? Cette action est irréversible.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Supprimer ce versement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scripts spécifiques à l'édition si nécessaire
    });
</script>
@endpush
@endsection
