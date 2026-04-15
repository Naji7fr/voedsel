<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductManagementController extends Controller
{
    public function create(): View
    {
        $products = Product::query()
            ->orderBy('name')
            ->get();

        return view('products.create', compact('products'));
    }

    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules(), $this->messages());

        Product::query()->create($validated);

        return redirect()
            ->route('inventory.index')
            ->with('status', 'Product is succesvol toegevoegd aan de voorraad.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate($this->rules($product), $this->messages());

        $product->update($validated);

        return redirect()
            ->route('inventory.index')
            ->with('status', 'Product is succesvol gewijzigd.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        if ($product->stock > 0) {
            return redirect()
                ->back()
                ->with('error', 'Het product kan niet worden verwijderd zolang er nog voorraad is.');
        }

        $product->delete();

        return redirect()
            ->back()
            ->with('status', 'Product is succesvol verwijderd uit de voorraad.');
    }

    private function rules(?Product $product = null): array
    {
        return [
            'barcode' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'barcode')->ignore($product?->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
            'stock' => ['required', 'integer', 'min:0'],
        ];
    }

    private function messages(): array
    {
        return [
            'barcode.required' => 'Alle verplichte velden moeten worden ingevuld.',
            'name.required' => 'Alle verplichte velden moeten worden ingevuld.',
            'category.required' => 'Alle verplichte velden moeten worden ingevuld.',
            'category.regex' => 'Categorie mag alleen letters bevatten.',
            'stock.required' => 'Alle verplichte velden moeten worden ingevuld.',
        ];
    }
}
