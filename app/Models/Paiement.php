<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Paiement extends Model
{
    use SoftDeletes;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'montant',
        'reference',
        'description',
        'banque',
        'attachment',
        'user_id',
        'category_id',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'montant' => 'decimal:4',
    ];

    /**
     * Les attributs qui doivent être mutés en dates.
     *
     * @var array
     */
    protected $dates = [
        'date',
        'deleted_at',
    ];

    /**
     * Relation avec l'utilisateur qui a créé le paiement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec la catégorie du paiement.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Obtenir le chemin d'accès au fichier joint.
     *
     * @return string|null
     */
    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->attachment ? Storage::url($this->attachment) : null;
    }

    /**
     * Obtenir le nom du fichier joint.
     *
     * @return string|null
     */
    public function getAttachmentNameAttribute(): ?string
    {
        return $this->attachment ? basename($this->attachment) : null;
    }

    /**
     * Scope pour filtrer les paiements par période.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $startDate
     * @param  string  $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope pour filtrer les paiements par banque.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $banque
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfBanque($query, $banque)
    {
        return $query->where('banque', $banque);
    }

    /**
     * Scope pour filtrer les paiements par catégorie.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $categoryId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Obtenir le montant formaté avec le séparateur de milliers.
     *
     * @return string
     */
    public function getFormattedMontantAttribute(): string
    {
        return number_format($this->montant, 4, ',', ' ');
    }

    /**
     * Obtenir la date formatée.
     *
     * @return string
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->date->format('d/m/Y');
    }
}
