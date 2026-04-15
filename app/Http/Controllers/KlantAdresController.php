<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use App\Models\KlantAdres;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CRUD voor extra adressen van een klant (route prefix: /klant/{klant}/adres/...).
 * Het eerste adres kan ook via KlantController worden beheerd; hier voor meerdere adressen.
 */
class KlantAdresController extends Controller
{
    /** Lijst met alle adressen van één klant, gesorteerd op stad. */
    public function index(Klant $klant): View
    {
        $adressen = $klant->adressen()->orderBy('stad')->get();

        return view('klantadres.index', compact('klant', 'adressen'));
    }

    /** Formulier nieuw adres (los van het hoofdadres in klant-formulier). */
    public function create(Klant $klant): View
    {
        return view('klantadres.create', compact('klant'));
    }

    /** Slaat een extra adres op, gekoppeld aan $klant. */
    public function store(Request $request, Klant $klant): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $klant->adressen()->create($validated);

        return redirect()->route('klant.adres.index', $klant)->with('success', 'Adres is succesvol toegevoegd.');
    }

    /** Formulier bestaand adres wijzigen. */
    public function edit(Klant $klant, KlantAdres $adres): View
    {
        return view('klantadres.edit', compact('klant', 'adres'));
    }

    public function update(Request $request, Klant $klant, KlantAdres $adres): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $adres->update($validated);

        return redirect()->route('klant.adres.index', $klant)->with('success', 'Adres is succesvol gewijzigd.');
    }

    public function destroy(Klant $klant, KlantAdres $adres): RedirectResponse
    {
        $adres->delete();

        return redirect()->route('klant.adres.index', $klant)->with('success', 'Adres is succesvol verwijderd.');
    }

    /** Validatie voor straat/postcode/stad/opmerking (KlantAdres-model). */
    private function rules(): array
    {
        return [
            'straat'    => ['required', 'string', 'max:150'],
            'postcode'  => ['required', 'string', 'max:10'],
            'stad'      => ['required', 'string', 'max:100'],
            'opmerking' => ['nullable', 'string', 'max:255'],
        ];
    }
}
