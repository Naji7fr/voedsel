<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductLeverancier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductLeverancierController extends Controller
{
    public function index(Product $product): View
    {
        $leveranciers = $product->leveranciers()->orderBy('naam')->get();
        return view('productleverancier.index', compact('product', 'leveranciers'));
    }

    public function create(Product $product): View
    {
        return view('productleverancier.create', compact('product'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $product->leveranciers()->create($validated);

        return redirect()->route('products.leverancier.index', $product)
            ->with('success', 'Leverancier is succesvol toegevoegd.');
    }

    public function edit(Product $product, ProductLeverancier $leverancier): View
    {
        return view('productleverancier.edit', compact('product', 'leverancier'));
    }

    public function update(Request $request, Product $product, ProductLeverancier $leverancier): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $leverancier->update($validated);

        return redirect()->route('products.leverancier.index', $product)
            ->with('success', 'Leverancier is succesvol gewijzigd.');
    }

    public function destroy(Product $product, ProductLeverancier $leverancier): RedirectResponse
    {
        $leverancier->delete();

        return redirect()->route('products.leverancier.index', $product)
            ->with('success', 'Leverancier is succesvol verwijderd.');
    }

    private function rules(): array
    {
        return [
            'naam'           => ['required', 'string', 'max:150'],
            'contactpersoon' => ['nullable', 'string', 'max:100'],
            'telefoonnummer' => ['nullable', 'regex:/^[0-9]+$/', 'max:15'],
            'email'          => ['nullable', 'email', 'max:100'],
            'opmerking'      => ['nullable', 'string', 'max:255'],
        ];
    }
}
