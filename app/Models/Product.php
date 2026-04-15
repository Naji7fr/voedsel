<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'name',
        'category',
        'stock',
        'is_used_in_food_package',
    ];

    protected $casts = [
        'is_used_in_food_package' => 'boolean',
    ];

    public function leveranciers()
    {
        return $this->hasMany(ProductLeverancier::class, 'product_id');
    }
}
