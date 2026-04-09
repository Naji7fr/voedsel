<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    /**
     * Toon het formulier voor een nieuwe klant.
     */
    public function create(): View
    {
        return view('klant.create');
    }

    /**
     * Sla een nieuwe klant op in de database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'gezinsnaam'         => ['required', 'string', 'max:100'],
            'adres'              => ['required', 'string', 'max:150'],
            'postcode'           => ['required', 'string', 'max:10'],
            'telefoonnummer'     => ['required', 'max:15'],
            'email'              => ['required', 'email', 'max:100', 'unique:Klant,email'],
            'aantal_volwassenen' => ['required', 'integer', 'min:0'],
            'aantal_kinderen'    => ['required', 'integer', 'min:0'],
            'aantal_babys'       => ['required', 'integer', 'min:0'],
            'IsActief'           => ['boolean'],
            'Opmerking'          => ['nullable', 'string', 'max:255'],
        ]);

        Klant::query()->create($request->all());

        return redirect()->route('klant.index');
    }
}
