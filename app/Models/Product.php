<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'nama',
        'slug',
        'harga',
        'gambar',
        'deskripsi_singkat',
        'deskripsi_panjang',
        'category_id',
        'discount_percentage',
        'is_on_sale'
    ];

    protected $casts = [
        'is_on_sale' => 'boolean',
        'discount_percentage' => 'decimal:2'
    ];

    public function getDiscountedPriceAttribute()
    {
        if ($this->is_on_sale && $this->discount_percentage > 0) {
            return $this->harga - ($this->harga * ($this->discount_percentage / 100));
        }
        return $this->harga;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ProductQuestion::class);
    }

    /**
     * Get the average rating for the product.
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get the total number of reviews for the product.
     */
    public function getTotalReviewsAttribute(): int
    {
        return $this->reviews()->count();
    }
}