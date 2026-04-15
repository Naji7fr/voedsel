<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Hoofd-entiteit "Klant" (voedselhulp): persoons- / gezinsgegevens.
 * Gekoppelde tabellen: KlantAdres (adressen), optioneel KlantContact (contactpersonen).
 */
class Klant extends Model
{
    /** Fysieke tabelnaam in de database (hoofdletter zoals in migratie). */
    protected $table = 'Klant';

    /** Primaire sleutel is geen "id" maar klant_id. */
    protected $primaryKey = 'klant_id';

    public $timestamps = false;

    protected $fillable = [
        'voornaam',
        'achternaam',
        'telefoonnummer',
        'email',
        'aantal_volwassenen',
        'aantal_kinderen',
        'aantal_babys',
        'IsActief',
        'Opmerking',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
    ];

    /** Voor route model binding: /klant/{klant} gebruikt klant_id in de URL. */
    public function getRouteKeyName(): string
    {
        return 'klant_id';
    }

    /** Alle adressen van deze klant (één of meer rijen in KlantAdres). */
    public function adressen(): HasMany
    {
        return $this->hasMany(KlantAdres::class, 'klant_id', 'klant_id');
    }

    /** Optionele contactpersonen gekoppeld aan deze klant (tabel KlantContact). */
    public function contacten(): HasMany
    {
        return $this->hasMany(KlantContact::class, 'klant_id', 'klant_id');
    }
}
