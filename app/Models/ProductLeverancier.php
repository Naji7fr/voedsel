<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLeverancier extends Model
{
    protected $table = 'product_leveranciers';

    protected $fillable = [
        'product_id',
        'naam',
        'contactpersoon',
        'telefoonnummer',
        'email',
        'opmerking',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
