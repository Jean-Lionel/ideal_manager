@extends('layouts.app')

@section('title', 'Modifier une entrée')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('entrees.index') }}">Entrées</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Modifier</li>
                </ol>
            </nav>
        </div>

        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Modifier l'entrée</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('entrees.update', $entree) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('entree._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
