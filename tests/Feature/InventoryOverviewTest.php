<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryOverviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_inventory_overview_with_products(): void
    {
        Product::query()->create([
            'barcode' => '8712345678901',
            'name' => 'Draadloze Muis',
            'category' => 'Accessoires',
            'stock' => 25,
        ]);

        Product::query()->create([
            'barcode' => '8712345678902',
            'name' => 'Mechanisch Toetsenbord',
            'category' => 'Accessoires',
            'stock' => 12,
        ]);

        $response = $this->get('/voorraad');

        $response->assertStatus(200);
        $response->assertSee('Voorraad overzicht');
        $response->assertSee('Streepjescode');
        $response->assertSee('Productnaam');
        $response->assertSee('Categorie');
        $response->assertSee('Aantal op voorraad');
        $response->assertSee('8712345678901');
        $response->assertSee('Draadloze Muis');
        $response->assertSee('Accessoires');
        $response->assertSee('25');
    }

    public function test_it_shows_message_when_inventory_is_empty(): void
    {
        $response = $this->get('/voorraad');

        $response->assertStatus(200);
        $response->assertSee('Er is geen voorraad beschikbaar.');
        $response->assertDontSee('Streepjescode');
        $response->assertDontSee('Productnaam');
        $response->assertDontSee('Categorie');
        $response->assertDontSee('Aantal op voorraad');
    }
}
