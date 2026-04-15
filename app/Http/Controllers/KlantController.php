<?php

namespace App\Http\Controllers;

use App\Models\Klant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

/**
 * HTTP-laag voor klanten: overzicht, aanmaken, wijzigen, verwijderen.
 * Bij store/update worden klantgegevens en het (eerste) adres gevalideerd en opgeslagen.
 */
class KlantController extends Controller
{
    /** Overzichtspagina: alle klanten met eager-loaded adressen voor de tabel/kaarten. */
    public function index(): View
    {
        $klanten = Klant::with('adressen')
            ->orderBy('achternaam')
            ->orderBy('voornaam')
            ->get();

        return view('klant.index', compact('klanten'));
    }

    /** Formulier "nieuwe klant" (resources/views/klant/create). */
    public function create(): View
    {
        return view('klant.create');
    }

    /**
     * Nieuwe klant + eerste adres in één request.
     * Adresvelden worden uit de validatie gehaald en apart in KlantAdres opgeslagen.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules(), $this->messages());

        $adresData = [
            'straat'   => $validated['straat'],
            'postcode' => $validated['postcode'],
            'stad'     => $validated['stad'],
        ];
        $klantData = array_diff_key($validated, $adresData);

        try {
            $klant = Klant::create($klantData);
            $klant->adressen()->create($adresData);
        } catch (Throwable $e) {
            Log::error('Klant aanmaken mislukt', [
                'exception' => $e::class,
                'message'   => $e->getMessage(),
            ]);

            return redirect()->back()->withInput()->with('error', 'Opslaan is mislukt. Probeer het later opnieuw.');
        }

        return redirect()->route('klant.index')->with('success', 'Klant is succesvol toegevoegd.');
    }

    /** Bewerkformulier voor één klant (inclusief geladen adressen voor het eerste adres). */
    public function edit(Klant $klant): View
    {
        $klant->load('adressen');

        return view('klant.edit', compact('klant'));
    }

    /**
     * Wijzigt klant + het eerste gekoppelde adres (updateOrCreate op klant_id).
     */
    public function update(Request $request, Klant $klant): RedirectResponse
    {
        $validated = $request->validate($this->rules($klant->klant_id), $this->messages());

        $adresData = [
            'straat'   => $validated['straat'],
            'postcode' => $validated['postcode'],
            'stad'     => $validated['stad'],
        ];
        $klantData = array_diff_key($validated, $adresData);

        try {
            $klant->update($klantData);
            $klant->adressen()->updateOrCreate(
                ['klant_id' => $klant->klant_id],
                $adresData
            );
        } catch (Throwable $e) {
            Log::error('Klant wijzigen mislukt', [
                'klant_id'  => $klant->klant_id,
                'exception' => $e::class,
                'message'   => $e->getMessage(),
            ]);

            return redirect()->back()->withInput()->with('error', 'Wijzigen is mislukt. Probeer het later opnieuw.');
        }

        return redirect()->route('klant.index')->with('success', 'Klant is succesvol gewijzigd.');
    }

    /** Verwijderen mag alleen als de klant niet actief is (bedrijfsregel). */
    public function destroy(Klant $klant): RedirectResponse
    {
        if ($klant->IsActief) {
            return redirect()->route('klant.index')->with('error', 'Actieve klanten kunnen niet worden verwijderd.');
        }

        try {
            $klant->delete();
        } catch (Throwable $e) {
            Log::error('Klant verwijderen mislukt', [
                'klant_id'  => $klant->klant_id,
                'exception' => $e::class,
                'message'   => $e->getMessage(),
            ]);

            return redirect()->route('klant.index')->with('error', 'Verwijderen is mislukt. Probeer het later opnieuw.');
        }

        return redirect()->route('klant.index')->with('success', 'Klant is succesvol verwijderd.');
    }

    /**
     * Validatieregels voor store (klantId null) en update (klantId = huidige klant voor unique-ignore).
     * E-mail en telefoon zijn uniek in de tabel Klant.
     */
    private function rules(?int $klantId = null): array
    {
        $telefoonUnique = Rule::unique('Klant', 'telefoonnummer');
        $emailUnique = Rule::unique('Klant', 'email');
        if ($klantId !== null) {
            $telefoonUnique->ignore($klantId, 'klant_id');
            $emailUnique->ignore($klantId, 'klant_id');
        }

        return [
            'voornaam'           => ['required', 'string', 'max:100'],
            'achternaam'         => ['required', 'string', 'max:100'],
            'telefoonnummer'     => ['required', 'regex:/^[0-9]+$/', 'max:15', $telefoonUnique],
            'email'              => ['required', 'email', 'max:100', $emailUnique],
            'aantal_volwassenen' => ['required', 'integer', 'min:0'],
            'aantal_kinderen'    => ['required', 'integer', 'min:0'],
            'aantal_babys'       => ['required', 'integer', 'min:0'],
            'IsActief'           => $klantId === null ? ['accepted'] : ['boolean'],
            'Opmerking'          => ['nullable', 'string', 'max:255'],
            'straat'             => ['required', 'string', 'max:150'],
            'postcode'           => ['required', 'string', 'max:10'],
            'stad'               => ['required', 'string', 'max:100'],
        ];
    }

    /** Nederlandse foutteksten voor bovenstaande regels (o.a. unieke e-mail/telefoon). */
    private function messages(): array
    {
        return [
            'voornaam.required'           => 'Voornaam is verplicht.',
            'achternaam.required'         => 'Achternaam is verplicht.',
            'telefoonnummer.required'     => 'Telefoonnummer is verplicht.',
            'telefoonnummer.regex'        => 'Alleen cijfers zijn toegestaan.',
            'telefoonnummer.unique'       => 'Dit telefoonnummer is al geregistreerd bij een andere klant.',
            'email.required'              => 'E-mailadres is verplicht.',
            'email.email'                 => 'Voer een geldig e-mailadres in.',
            'email.unique'                => 'Dit e-mailadres bestaat al.',
            'aantal_volwassenen.required' => 'Aantal volwassenen is verplicht.',
            'aantal_kinderen.required'    => 'Aantal kinderen is verplicht.',
            'aantal_babys.required'       => 'Aantal babys is verplicht.',
            'IsActief.accepted'           => 'Klant moet actief zijn.',
            'straat.required'             => 'Straat is verplicht.',
            'postcode.required'           => 'Postcode is verplicht.',
            'stad.required'               => 'Stad is verplicht.',
        ];
    }
}
