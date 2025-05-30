<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sortie extends Model
{
    use HasFactory;
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
        'user_id',
        'category_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'date' => 'date',
            'montant' => 'decimal:2',
            'user_id' => 'integer',
            'category_id' => 'integer',
        ];
    }

    public function categoryUser(): BelongsTo
    {
        return $this->belongsTo(CategoryUser::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Le "booted" du modèle.
     */
    protected static function booted(): void
    {
        static::creating(function ($sortie) {
            $sortie->user_id = auth()->id();
        });
    }
}
