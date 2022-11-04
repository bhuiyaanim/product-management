<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    // Relations
    public function attribute() {
        return $this->belongsTo(Attribute::class);
    }
}
