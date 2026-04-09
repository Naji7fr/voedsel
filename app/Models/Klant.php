<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klant extends Model
{
    protected $table = 'Klant';

    protected $primaryKey = 'klant_id';

    // DatumAangemaakt and DatumGewijzigd are managed manually
    public $timestamps = false;

    protected $fillable = [
        'gezinsnaam',
        'adres',
        'postcode',
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
}
