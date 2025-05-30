<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'type',
        'description',
        'couleur',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'id' => 'integer',
        ];
    }

    // Constantes pour les types de catégories
    public const TYPE_INCOME = 'entree';
    public const TYPE_EXPENSE = 'sortie';

    /**
     * Obtenir le nom du type formaté
     *
     * @return string
     */
    public function getTypeFormattedAttribute(): string
    {
        return $this->type === self::TYPE_INCOME ? 'Entrée' : 'Sortie';
    }

    /**
     * Obtenir la classe CSS pour le type
     *
     * @return string
     */
    public function getTypeClassAttribute(): string
    {
        return $this->type === self::TYPE_INCOME ? 'success' : 'danger';
    }

    /**
     * Obtenir l'icône pour le type
     *
     * @return string
     */
    public function getTypeIconAttribute(): string
    {
        return $this->type === self::TYPE_INCOME ? 'arrow-down-circle' : 'arrow-up-circle';
    }

    /**
     * Obtenir le montant total des entrées pour cette catégorie
     *
     * @return float
     */
    public function getTotalAmountAttribute(): float
    {
        return $this->entrees()->sum('montant');
    }

    /**
     * Relation avec les entrées
     */
    public function entrees(): HasMany
    {
        return $this->hasMany(Entree::class);
    }

    /**
     * Relation avec les sorties
     */
    public function sorties(): HasMany
    {
        return $this->hasMany(Sortie::class);
    }

    /**
     * Relation avec les entrées-sorties-versements-paiements
     */
    public function entreeSortieVersementPaiements(): HasMany
    {
        return $this->hasMany(EntreeSortieVersementPaiement::class);
    }

    /**
     * Scope pour les catégories de type entrée
     */
    public function scopeIncome($query)
    {
        return $query->where('type', self::TYPE_INCOME);
    }

    /**
     * Scope pour les catégories de type dépense
     */
    public function scopeExpense($query)
    {
        return $query->where('type', self::TYPE_EXPENSE);
    }

    /**
     * Scope pour les catégories de type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Vérifie si la catégorie est utilisée dans des transactions
     *
     * @return bool
     */
    public function isUsed(): bool
    {
        return $this->entrees()->exists() || $this->sorties()->exists();
    }

    /**
     * Obtenir le libellé du type
     *
     * @return string
     */
    public function getTypeLabelAttribute()
    {
        $types = [
            'entree' => 'Entrée',
            'sortie' => 'Sortie',
            'paiement' => 'Paiement',
            'versement' => 'Versement',
        ];

        return $types[$this->type] ?? $this->type;
    }

    /**
     * Obtenir la classe CSS pour le type
     *
     * @return string
     */
    public function getTypeClassAttributeOld()
    {
        $classes = [
            'entree' => 'success',
            'sortie' => 'danger',
            'paiement' => 'info',
            'versement' => 'warning',
        ];

        return $classes[$this->type] ?? 'secondary';
    }
}
