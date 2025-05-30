@extends('layouts.app')

@section('title', 'Nouvelle sortie')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('sorties.index') }}">Sorties</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nouvelle sortie</li>
                </ol>
            </nav>
        </div>

        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ajouter une nouvelle sortie</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sorties.store') }}" method="POST">
                        @csrf
                        @include('sortie._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
