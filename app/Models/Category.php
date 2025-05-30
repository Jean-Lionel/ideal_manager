<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'type',
        'description',
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
            'id' => 'integer',
        ];
    }

    public function entreeSortieVersementPaiements(): HasMany
    {
        return $this->hasMany(EntreeSortieVersementPaiement::class);
    }

    public function entrees()
    {
        return $this->hasMany(Entree::class);
    }

    public function sorties()
    {
        return $this->hasMany(Sortie::class);
    }

    // Scopes
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Méthodes utilitaires
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

    public function getTypeClassAttribute()
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
