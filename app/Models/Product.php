<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Const
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    // Relations
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function productCategories() {
        return $this->hasMany(ProductCategory::class);
    }

    public function productImages() {
        return $this->hasMany(ProductImage::class);
    }

    public function productAttributes() {
        return $this->hasMany(ProductAttribute::class);
    }
}
