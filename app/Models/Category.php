<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'slug', 'gambar'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}