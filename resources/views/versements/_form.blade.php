<div class="form-group">
    <label for="date">Date</label>
    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
           value="{{ old('date', $versement->date ?? now()->format('Y-m-d')) }}" required>
    @error('date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-3">
    <label for="montant">Montant</label>
    <input type="number" step="0.01" name="montant" id="montant"
           class="form-control @error('montant') is-invalid @enderror"
           value="{{ old('montant', $versement->montant ?? '') }}" required>
    @error('montant')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-3">
    <label for="reference">Référence</label>
    <input type="text" name="reference" id="reference"
           class="form-control @error('reference') is-invalid @enderror"
           value="{{ old('reference', $versement->reference ?? '') }}">
    @error('reference')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-3">
    <label for="description">Description</label>
    <textarea name="description" id="description"
              class="form-control @error('description') is-invalid @enderror"
              rows="3">{{ old('description', $versement->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-3">
    <label for="banque">Banque</label>
    <select name="banque" id="banque" class="form-select @error('banque') is-invalid @enderror" required>
        <option value="">Sélectionnez une banque</option>
        @foreach(['CRDB', 'BANCOBU', 'BCB', 'INTERBANK', 'KCB', 'BCAB', 'BBCI', 'BGEF', 'ECOBANK', 'FINBANK', 'OTHER'] as $banque)
            <option value="{{ $banque }}" {{ old('banque', $versement->banque ?? '') == $banque ? 'selected' : '' }}>
                {{ $banque }}
            </option>
        @endforeach
    </select>
    @error('banque')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-3">
    <label for="attachment">Pièce jointe</label>
    <input type="file" name="attachment" id="attachment"
           class="form-control @error('attachment') is-invalid @enderror">
    @error('attachment')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($versement) && $versement->attachment)
        <div class="mt-2">
            <a href="{{ Storage::url($versement->attachment) }}" target="_blank">Voir le fichier joint</a>
        </div>
    @endif
</div>

<div class="form-group mt-3">
    <label for="category_id">Catégorie</label>
    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
        <option value="">Sélectionnez une catégorie</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $versement->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->nom }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <a href="{{ route('versements.index') }}" class="btn btn-secondary">Annuler</a>
</div>
