@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date"
                   value="{{ old('date', $sortie->date ?? now()->format('Y-m-d')) }}" required>
            @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="montant" class="form-label">Montant (FBU) <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="number" step="0.01" min="0" class="form-control @error('montant') is-invalid @enderror"
                       id="montant" name="montant" value="{{ old('montant', $sortie->montant ?? '') }}" required>
                <span class="input-group-text">FBU</span>
                @error('montant')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
              rows="3">{{ old('description', $sortie->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="category_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
        <option value="">Sélectionnez une catégorie</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                    {{ old('category_id', $sortie->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->nom }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('sorties.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Retour
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Enregistrer
    </button>
</div>
