<?php

namespace Database\Seeders;

use App\Models\Klant;
use Illuminate\Database\Seeder;

class KlantSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'voornaam' => 'Sophie', 'achternaam' => 'de Vries', 'telefoonnummer' => '0612345678',
                'email' => 'sophie.devries@example.nl', 'aantal_volwassenen' => 2, 'aantal_kinderen' => 1, 'aantal_babys' => 0,
                'IsActief' => true, 'Opmerking' => null,
                'adres' => ['straat' => 'Kerkstraat 12', 'postcode' => '1012AB', 'stad' => 'Amsterdam'],
            ],
            [
                'voornaam' => 'Mohamed', 'achternaam' => 'El Amrani', 'telefoonnummer' => '0623456789',
                'email' => 'mohamed.elamrani@example.nl', 'aantal_volwassenen' => 1, 'aantal_kinderen' => 2, 'aantal_babys' => 1,
                'IsActief' => true, 'Opmerking' => 'Liever contact via e-mail.',
                'adres' => ['straat' => 'Stationsweg 45', 'postcode' => '3013AK', 'stad' => 'Rotterdam'],
            ],
            [
                'voornaam' => 'Lisa', 'achternaam' => 'Jansen', 'telefoonnummer' => '0634567890',
                'email' => 'lisa.jansen@example.nl', 'aantal_volwassenen' => 1, 'aantal_kinderen' => 0, 'aantal_babys' => 0,
                'IsActief' => true, 'Opmerking' => null,
                'adres' => ['straat' => 'Lange Elisabethstraat 8', 'postcode' => '3511TG', 'stad' => 'Utrecht'],
            ],
            [
                'voornaam' => 'Thomas', 'achternaam' => 'Bakker', 'telefoonnummer' => '0645678901',
                'email' => 'thomas.bakker@example.nl', 'aantal_volwassenen' => 3, 'aantal_kinderen' => 2, 'aantal_babys' => 0,
                'IsActief' => true, 'Opmerking' => null,
                'adres' => ['straat' => 'Vismarkt 3', 'postcode' => '9711CA', 'stad' => 'Groningen'],
            ],
            [
                'voornaam' => 'Emma', 'achternaam' => 'van Dijk', 'telefoonnummer' => '0656789012',
                'email' => 'emma.vandijk@example.nl', 'aantal_volwassenen' => 2, 'aantal_kinderen' => 0, 'aantal_babys' => 0,
                'IsActief' => false, 'Opmerking' => 'Inactief — demo.',
                'adres' => ['straat' => 'Havenkade 22', 'postcode' => '2511VB', 'stad' => 'Den Haag'],
            ],
        ];

        foreach ($rows as $row) {
            $adres = $row['adres'];
            unset($row['adres']);

            $klant = Klant::create($row);
            $klant->adressen()->create($adres);
        }
    }
}
