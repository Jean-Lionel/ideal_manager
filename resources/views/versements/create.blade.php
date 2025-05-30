@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-md-6">
            <h1>Nouveau Versement</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('versements.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Annuler
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('versements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        @include('versements._form', ['versement' => null , 'categories' => $categories])
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Script pour la validation côté client si nécessaire
    document.addEventListener('DOMContentLoaded', function() {
        // Validation personnalisée peut être ajoutée ici
    });
</script>
@endpush
@endsection
