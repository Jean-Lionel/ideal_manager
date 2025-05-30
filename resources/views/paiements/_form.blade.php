<div class="form-group">
    <label for="date">Date</label>
    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror"
           value="{{ old('date', $paiement->date ?? now()->format('Y-m-d')) }}" required>
    @error('date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-3">
    <label for="montant">Montant</label>
    <input type="number" step="0.0001" name="montant" id="montant"
           class="form-control @error('montant') is-invalid @enderror"
           value="{{ old('montant', $paiement->montant ?? '') }}" required>
    @error('montant')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-3">
    <label for="reference">Référence</label>
    <input type="text" name="reference" id="reference"
           class="form-control @error('reference') is-invalid @enderror"
           value="{{ old('reference', $paiement->reference ?? '') }}">
    @error('reference')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-3">
    <label for="description">Description</label>
    <textarea name="description" id="description"
              class="form-control @error('description') is-invalid @enderror"
              rows="3">{{ old('description', $paiement->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-3">
    <label for="banque">Banque (optionnel)</label>
    <input type="text" name="banque" id="banque"
           class="form-control @error('banque') is-invalid @enderror"
           value="{{ old('banque', $paiement->banque ?? '') }}">
    @error('banque')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-3">
    <label for="attachment">Pièce jointe (optionnel)</label>
    <input type="file" name="attachment" id="attachment"
           class="form-control @error('attachment') is-invalid @enderror">
    @error('attachment')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($paiement) && $paiement->attachment)
        <div class="mt-2">
            <a href="{{ Storage::url($paiement->attachment) }}" target="_blank">
                <i class="fas fa-paperclip"></i> Voir le fichier joint
            </a>
        </div>
    @endif
</div>

<div class="form-group mt-3">
    <label for="category_id">Catégorie</label>
    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
        <option value="">Sélectionnez une catégorie</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $paiement->category_id ?? '') == $category->id ? 'selected' : '' }}>
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
    <a href="{{ route('paiements.index') }}" class="btn btn-secondary">Annuler</a>
</div>
