<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\View\View;

class KlantController extends Controller
{
    /**
     * Toon een overzicht van alle klanten.
     */
    public function index(): View
    {
        $klanten = Klant::query()
            ->orderBy('gezinsnaam')
            ->get();

        return view('klant.index', compact('klanten'));
    }
}
