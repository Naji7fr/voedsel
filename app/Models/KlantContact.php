<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Contactpersoon bij een klant (familie/vriend); hoort bij tabel KlantContact.
 */
class KlantContact extends Model
{
    protected $table = 'KlantContact';

    protected $primaryKey = 'contact_id';

    public $timestamps = true;

    protected $fillable = [
        'klant_id',
        'voornaam',
        'achternaam',
        'relatie',
        'telefoonnummer',
        'email',
        'is_primair',
        'opmerking',
    ];

    protected $casts = [
        'is_primair' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'contact_id';
    }

    public function klant(): BelongsTo
    {
        return $this->belongsTo(Klant::class, 'klant_id', 'klant_id');
    }
}
