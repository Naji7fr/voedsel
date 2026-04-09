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
        $validated = $request->validate($this->rules(), $this->messages());

        Klant::query()->create($validated);

        return redirect()
            ->route('klant.index')
            ->with('success', 'Klant is succesvol toegevoegd.');
    }

    /**
     * Toon het formulier om een bestaande klant te wijzigen.
     */
    public function edit(Klant $klant): View
    {
        return view('klant.edit', compact('klant'));
    }

    /**
     * Sla de gewijzigde klantgegevens op.
     */
    public function update(Request $request, Klant $klant): RedirectResponse
    {
        $validated = $request->validate($this->rules($klant->klant_id), $this->messages());

        $klant->update($validated);

        return redirect()
            ->route('klant.index')
            ->with('success', 'Klant is succesvol gewijzigd.');
    }

    /**
     * Validatieregels voor klant formulieren.
     */
    private function rules(?int $klantId = null): array
    {
        return [
            'gezinsnaam'         => ['required', 'string', 'max:100'],
            'adres'              => ['required', 'string', 'max:150'],
            'postcode'           => ['required', 'string', 'max:10'],
            'telefoonnummer'     => ['required', 'regex:/^[0-9]+$/', 'max:15'],
            // Unique email, but exclude the current klant on update
            'email'              => ['required', 'email', 'max:100', 'unique:Klant,email,' . ($klantId ?? 'NULL') . ',klant_id'],
            'aantal_volwassenen' => ['required', 'integer', 'min:0'],
            'aantal_kinderen'    => ['required', 'integer', 'min:0'],
            'aantal_babys'       => ['required', 'integer', 'min:0'],
            // New clients must be active (accepted = 1/true); on update allow any boolean
            'IsActief'           => $klantId === null ? ['accepted'] : ['boolean'],
            'Opmerking'          => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Nederlandse foutmeldingen voor validatie.
     */
    private function messages(): array
    {
        return [
            'gezinsnaam.required'          => 'Gezinsnaam is verplicht.',
            'adres.required'               => 'Adres is verplicht.',
            'postcode.required'            => 'Postcode is verplicht.',
            'telefoonnummer.required'      => 'Telefoonnummer is verplicht.',
            'telefoonnummer.regex'         => 'Ongeldig telefoonnummer. Alleen cijfers zijn toegestaan.',
            'email.required'               => 'E-mailadres is verplicht.',
            'email.email'                  => 'Voer een geldig e-mailadres in.',
            'email.unique'                 => 'Dit e-mailadres bestaat al.',
            'aantal_volwassenen.required'  => 'Aantal volwassenen is verplicht.',
            'aantal_kinderen.required'     => 'Aantal kinderen is verplicht.',
            'aantal_babys.required'        => 'Aantal babys is verplicht.',
            'IsActief.accepted'            => 'Klant moet actief zijn.',
        ];
    }
}
