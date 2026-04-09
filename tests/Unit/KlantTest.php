<?php

namespace Tests\Unit;

use App\Models\Klant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class KlantTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------
    // Feature: Overzicht Klant
    // -------------------------------------------------------

    public function test_klant_overzicht_wordt_succesvol_geladen(): void
    {
        Klant::create([
            'gezinsnaam'         => 'De Vries',
            'adres'              => 'Dorpsstraat 12',
            'postcode'           => '5388 AB',
            'telefoonnummer'     => '0612345678',
            'email'              => 'devries@email.nl',
            'aantal_volwassenen' => 2,
            'aantal_kinderen'    => 3,
            'aantal_babys'       => 0,
            'IsActief'           => true,
        ]);

        $klanten = Klant::all();

        $this->assertCount(1, $klanten);
        $this->assertEquals('De Vries', $klanten->first()->gezinsnaam);
    }

    // -------------------------------------------------------
    // Feature: Nieuwe Klant toevoegen
    // -------------------------------------------------------

    public function test_een_klant_kan_succesvol_worden_aangemaakt(): void
    {
        $klant = Klant::create([
            'gezinsnaam'         => 'Janssen',
            'adres'              => 'Kerkweg 5',
            'postcode'           => '5388 CD',
            'telefoonnummer'     => '0623456789',
            'email'              => 'janssen@email.nl',
            'aantal_volwassenen' => 1,
            'aantal_kinderen'    => 2,
            'aantal_babys'       => 1,
            'IsActief'           => true,
        ]);

        $this->assertDatabaseHas('Klant', ['email' => 'janssen@email.nl']);
        $this->assertTrue($klant->IsActief);
    }

    public function test_klant_wordt_niet_toegevoegd_als_niet_actief(): void
    {
        $validator = Validator::make(
            ['IsActief' => '0'],
            ['IsActief' => ['accepted']],
            ['IsActief.accepted' => 'Klant moet actief zijn.']
        );

        $this->assertTrue($validator->fails());
        $this->assertEquals('Klant moet actief zijn.', $validator->errors()->first('IsActief'));
    }

    // -------------------------------------------------------
    // Feature: Bestaande Klant wijzigen
    // -------------------------------------------------------

    public function test_een_klant_kan_succesvol_worden_gewijzigd(): void
    {
        $klant = Klant::create([
            'gezinsnaam'         => 'El Amrani',
            'adres'              => 'Molenpad 8',
            'postcode'           => '5388 EF',
            'telefoonnummer'     => '0634567890',
            'email'              => 'elamrani@email.nl',
            'aantal_volwassenen' => 2,
            'aantal_kinderen'    => 1,
            'aantal_babys'       => 0,
            'IsActief'           => true,
        ]);

        $klant->update(['email' => 'elamrani.nieuw@email.nl']);

        $this->assertDatabaseHas('Klant', ['email' => 'elamrani.nieuw@email.nl']);
        $this->assertEquals('elamrani.nieuw@email.nl', $klant->fresh()->email);
    }

    public function test_klant_wordt_niet_gewijzigd_met_bestaand_emailadres(): void
    {
        Klant::create([
            'gezinsnaam'         => 'Bakker',
            'adres'              => 'Nieuweweg 17',
            'postcode'           => '5388 IJ',
            'telefoonnummer'     => '0656789012',
            'email'              => 'bakker@email.nl',
            'aantal_volwassenen' => 1,
            'aantal_kinderen'    => 4,
            'aantal_babys'       => 1,
            'IsActief'           => true,
        ]);

        $klant2 = Klant::create([
            'gezinsnaam'         => 'Smit',
            'adres'              => 'Lindenlaan 2',
            'postcode'           => '5388 KL',
            'telefoonnummer'     => '0667890123',
            'email'              => 'smit@email.nl',
            'aantal_volwassenen' => 2,
            'aantal_kinderen'    => 2,
            'aantal_babys'       => 0,
            'IsActief'           => true,
        ]);

        // Try to update klant2 with an email that already belongs to klant1
        $validator = Validator::make(
            ['email' => 'bakker@email.nl'],
            ['email' => ['unique:Klant,email,' . $klant2->klant_id . ',klant_id']],
            ['email.unique' => 'Dit e-mailadres bestaat al.']
        );

        $this->assertTrue($validator->fails());
        $this->assertEquals('Dit e-mailadres bestaat al.', $validator->errors()->first('email'));
    }

    // -------------------------------------------------------
    // Feature: Bestaande Klant verwijderen
    // -------------------------------------------------------

    public function test_een_inactieve_klant_kan_succesvol_worden_verwijderd(): void
    {
        $klant = Klant::create([
            'gezinsnaam'         => 'Willems',
            'adres'              => 'Beekstraat 45',
            'postcode'           => '5388 MN',
            'telefoonnummer'     => '0678901234',
            'email'              => 'willems@email.nl',
            'aantal_volwassenen' => 1,
            'aantal_kinderen'    => 0,
            'aantal_babys'       => 0,
            'IsActief'           => false,
        ]);

        $klant->delete();

        $this->assertDatabaseMissing('Klant', ['email' => 'willems@email.nl']);
    }

    public function test_een_actieve_klant_kan_niet_worden_verwijderd(): void
    {
        $klant = Klant::create([
            'gezinsnaam'         => 'Van den Berg',
            'adres'              => 'Schoolstraat 33',
            'postcode'           => '5388 GH',
            'telefoonnummer'     => '0645678901',
            'email'              => 'vandenberg@email.nl',
            'aantal_volwassenen' => 2,
            'aantal_kinderen'    => 0,
            'aantal_babys'       => 0,
            'IsActief'           => true,
        ]);

        // Active client should NOT be deleted
        $this->assertTrue($klant->IsActief);
        $this->assertDatabaseHas('Klant', ['email' => 'vandenberg@email.nl']);
    }
}
