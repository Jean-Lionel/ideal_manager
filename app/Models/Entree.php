<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entree extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'montant',
        'description',
        'category_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'montant' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the category that owns the entree.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that owns the entree.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include entrees for the given user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int|null  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $userId = null)
    {
        return $query->where('user_id', $userId ?? auth()->id());
    }

    /**
     * Scope a query to only include entrees between the given dates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $startDate
     * @param  string|null  $endDate
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBetweenDates($query, $startDate, $endDate = null)
    {
        $endDate = $endDate ?? $startDate;
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include entrees for the given category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $categoryId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Get the formatted montant attribute.
     *
     * @return string
     */
    public function getFormattedMontantAttribute(): string
    {
        return number_format($this->montant, 2, ',', ' ') . ' FCFA';
    }

    /**
     * Get the formatted date attribute.
     *
     * @return string
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->date->format('d/m/Y');
    }
}
