@csrf

<div class="mb-3">
    <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
           value="{{ old('nom', $category->nom ?? '') }}" required>
    @error('nom')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
        <option value="">Sélectionnez un type</option>
        <option value="entree" @if(old('type', $category->type ?? '') == 'entree') selected @endif>Entrée</option>
        <option value="sortie" @if(old('type', $category->type ?? '') == 'sortie') selected @endif>Sortie</option>
        <option value="paiement" @if(old('type', $category->type ?? '') == 'paiement') selected @endif>Paiement</option>
        <option value="versement" @if(old('type', $category->type ?? '') == 'versement') selected @endif>Versement</option>
    </select>
    @error('type')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror"
              id="description" name="description" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Enregistrer
    </button>
</div>
