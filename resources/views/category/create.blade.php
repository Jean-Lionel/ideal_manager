@extends('layouts.app')

@section('title', 'Nouvelle catégorie')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Catégories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nouvelle catégorie</li>
                </ol>
            </nav>
        </div>

        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ajouter une nouvelle catégorie</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @include('category._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
