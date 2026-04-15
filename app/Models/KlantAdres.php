<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Adresregel(s) bij een klant. Foreign key: klant_id → Klant.klant_id.
 */
class KlantAdres extends Model
{
    protected $table = 'KlantAdres';

    protected $primaryKey = 'adres_id';

    public $timestamps = true;

    protected $fillable = [
        'klant_id',
        'straat',
        'postcode',
        'stad',
        'opmerking',
    ];

    public function getRouteKeyName(): string
    {
        return 'adres_id';
    }

    public function klant(): BelongsTo
    {
        return $this->belongsTo(Klant::class, 'klant_id', 'klant_id');
    }
}
