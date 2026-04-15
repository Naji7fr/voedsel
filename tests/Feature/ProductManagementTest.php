<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_can_be_added_successfully(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('products.create'))
            ->assertStatus(200)
            ->assertSee('Product toevoegen');

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->post(route('products.store'), [
                'barcode' => '8711111111111',
                'name' => 'USB-C Kabel',
                'category' => 'Kabels',
                'stock' => 40,
            ]);

        $response->assertStatus(200);
        $response->assertSee('Product is succesvol toegevoegd aan de voorraad.');
        $response->assertSee('USB-C Kabel');
        $response->assertSee('8711111111111');
        $response->assertSee('Kabels');
        $response->assertSee('40');

        $this->assertDatabaseHas('products', [
            'barcode' => '8711111111111',
            'name' => 'USB-C Kabel',
            'category' => 'Kabels',
            'stock' => 40,
        ]);
    }

    public function test_product_is_not_saved_when_required_fields_are_missing(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->from(route('products.create'))
            ->post(route('products.store'), [
                'barcode' => '',
                'name' => '',
                'category' => '',
                'stock' => '',
            ]);

        $response->assertStatus(200);
        $response->assertSee('Alle verplichte velden moeten worden ingevuld.');

        $this->assertDatabaseCount('products', 0);
    }

    public function test_category_cannot_contain_numbers(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->from(route('products.create'))
            ->post(route('products.store'), [
                'barcode' => '8711111111112',
                'name' => 'HDMI Kabel',
                'category' => 'Kabels123',
                'stock' => 10,
            ]);

        $response->assertStatus(200);
        $response->assertSee('Categorie mag alleen letters bevatten.');

        $this->assertDatabaseMissing('products', [
            'barcode' => '8711111111112',
        ]);
    }

    public function test_product_can_be_updated_successfully(): void
    {
        $user = User::factory()->create();
        $product = Product::query()->create([
            'barcode' => '8711111111199',
            'name' => 'Muis',
            'category' => 'Accessoires',
            'stock' => 5,
        ]);

        $this->actingAs($user)
            ->get(route('products.create'))
            ->assertStatus(200)
            ->assertSee('Wijzigen');

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->put(route('products.update', $product), [
                'barcode' => '8711111111199',
                'name' => 'Gaming Muis',
                'category' => 'Accessoires',
                'stock' => 9,
            ]);

        $response->assertStatus(200);
        $response->assertSee('Product is succesvol gewijzigd.');
        $response->assertSee('Gaming Muis');
        $response->assertSee('9');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'barcode' => '8711111111199',
            'name' => 'Gaming Muis',
            'category' => 'Accessoires',
            'stock' => 9,
        ]);
    }

    public function test_product_update_fails_when_required_fields_are_missing(): void
    {
        $user = User::factory()->create();
        $product = Product::query()->create([
            'barcode' => '8711111111188',
            'name' => 'Toetsenbord',
            'category' => 'Accessoires',
            'stock' => 7,
        ]);

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->from(route('products.edit', $product))
            ->put(route('products.update', $product), [
                'barcode' => '',
                'name' => '',
                'category' => '',
                'stock' => '',
            ]);

        $response->assertStatus(200);
        $response->assertSee('Alle verplichte velden moeten worden ingevuld.');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'barcode' => '8711111111188',
            'name' => 'Toetsenbord',
            'category' => 'Accessoires',
            'stock' => 7,
        ]);
    }

    public function test_product_can_be_deleted_successfully(): void
    {
        $user = User::factory()->create();
        $product = Product::query()->create([
            'barcode' => '8711111111177',
            'name' => 'Oude Blender',
            'category' => 'Keuken',
            'stock' => 0,
            'is_used_in_food_package' => false,
        ]);

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->from(route('products.create'))
            ->delete(route('products.destroy', $product));

        $response->assertStatus(200);
        $response->assertSee('Product is succesvol verwijderd uit de voorraad.');
        $response->assertDontSee('Oude Blender');

        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_used_product_cannot_be_deleted(): void
    {
        $user = User::factory()->create();
        $product = Product::query()->create([
            'barcode' => '8711111111166',
            'name' => 'Rijst',
            'category' => 'Voeding',
            'stock' => 15,
            'is_used_in_food_package' => false,
        ]);

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->from(route('products.create'))
            ->delete(route('products.destroy', $product));

        $response->assertStatus(200);
        $response->assertSee('Een product met voorraad mag niet verwijderd worden.');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Rijst',
        ]);
    }
}
