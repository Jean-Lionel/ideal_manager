@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Détails de l\'utilisateur') }}</span>
                    <div>
                        <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('profile.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-4 fw-bold">{{ __('Nom') }}:</div>
                        <div class="col-md-8">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 fw-bold">{{ __('Adresse email') }}:</div>
                        <div class="col-md-8">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 fw-bold">{{ __('Rôle') }}:</div>
                        <div class="col-md-8">
                            <span class="badge {{ $user->role === 'admin' ? 'bg-success' : 'bg-primary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>


                    <div class="row mb-4">
                        <div class="col-md-4 fw-bold">{{ __('Date de création') }}:</div>
                        <div class="col-md-8">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 fw-bold">{{ __('Dernière mise à jour') }}:</div>
                        <div class="col-md-8">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                    </div>


                    <div class="d-flex justify-content-between mt-4">
                        <form action="{{ route('profile.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" {{ Auth::id() === $user->id ? 'disabled' : '' }}>
                                <i class="fas fa-trash"></i> Supprimer l'utilisateur
                            </button>
                        </form>

                        <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
