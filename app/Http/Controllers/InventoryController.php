<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->orderBy('name')
            ->get();

        return view('inventory.index', compact('products'));
    }
}
