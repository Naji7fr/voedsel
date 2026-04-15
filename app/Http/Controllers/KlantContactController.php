<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use App\Models\KlantContact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Contactpersonen bij een klant (tabel KlantContact).
 * Vereist dat de database-migratie voor KlantContact is uitgevoerd.
 */
class KlantContactController extends Controller
{
    public function index(Klant $klant): View
    {
        $contacten = $klant->contacten()->orderByDesc('is_primair')->orderBy('achternaam')->get();

        return view('klantcontact.index', compact('klant', 'contacten'));
    }

    public function create(Klant $klant): View
    {
        return view('klantcontact.create', compact('klant'));
    }

    public function store(Request $request, Klant $klant): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $klant->contacten()->create($validated);

        return redirect()
            ->route('klant.contact.index', $klant)
            ->with('success', 'Contact is succesvol toegevoegd.');
    }

    public function edit(Klant $klant, KlantContact $contact): View
    {
        return view('klantcontact.edit', compact('klant', 'contact'));
    }

    public function update(Request $request, Klant $klant, KlantContact $contact): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        $contact->update($validated);

        return redirect()
            ->route('klant.contact.index', $klant)
            ->with('success', 'Contact is succesvol gewijzigd.');
    }

    public function destroy(Klant $klant, KlantContact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()
            ->route('klant.contact.index', $klant)
            ->with('success', 'Contact is succesvol verwijderd.');
    }

    private function rules(): array
    {
        return [
            'voornaam'       => ['required', 'string', 'max:100'],
            'achternaam'     => ['required', 'string', 'max:100'],
            'relatie'        => ['nullable', 'string', 'max:50'],
            'telefoonnummer' => ['required', 'regex:/^[0-9]+$/', 'max:15'],
            'email'          => ['nullable', 'email', 'max:100'],
            'is_primair'     => ['nullable', 'boolean'],
            'opmerking'      => ['nullable', 'string', 'max:255'],
        ];
    }
}
