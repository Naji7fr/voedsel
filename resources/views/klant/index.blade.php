{{-- Klant-overzicht: lijst van alle klanten met adres, contact en acties. Op kleine schermen: kaarten; vanaf md: tabel. --}}
<x-layouts.app title="Klant overzicht">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Klant overzicht</h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        {{-- Breedte + horizontale padding voor mobiel (geen afgesneden randen) --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-md text-sm sm:text-base">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-md text-sm sm:text-base">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    {{-- Primaire actie: op mobiel volle breedte voor betere tikbaarheid --}}
                    <div class="mb-4">
                        <a href="{{ route('klant.create') }}"
                           class="inline-flex w-full sm:w-auto justify-center items-center rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                            Klant toevoegen
                        </a>
                    </div>

                    @if ($klanten->isEmpty())
                        {{-- Lege staat (ook voor demo-route /klant/demo-leeg) --}}
                        <p class="text-center text-gray-500 py-8 text-sm sm:text-base">Er zijn geen klanten geregistreerd.</p>
                    @else
                        {{-- Mobiel (< md): één kaart per klant --}}
                        <div class="space-y-4 md:hidden">
                            @foreach ($klanten as $klant)
                                @php($adres = $klant->adressen->first())
                                <article class="rounded-lg border border-gray-200 bg-gray-50/50 p-4 shadow-sm">
                                    <div class="flex justify-between items-start gap-2">
                                        <div>
                                            <p class="text-xs text-gray-500">#{{ $klant->klant_id }}</p>
                                            <p class="font-semibold text-gray-900">{{ $klant->voornaam }} {{ $klant->achternaam }}</p>
                                        </div>
                                        @if ($klant->IsActief)
                                            <span class="shrink-0 inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Actief</span>
                                        @else
                                            <span class="shrink-0 inline-block px-2 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">Inactief</span>
                                        @endif
                                    </div>
                                    <dl class="mt-3 space-y-1 text-sm text-gray-700">
                                        <div><span class="text-gray-500">Adres:</span>
                                            @if ($adres)
                                                {{ $adres->straat }}, {{ $adres->postcode }} {{ $adres->stad }}
                                            @else
                                                <span class="italic text-gray-400">Geen adres</span>
                                            @endif
                                        </div>
                                        <div><span class="text-gray-500">E-mail:</span> {{ $klant->email }}</div>
                                        <div><span class="text-gray-500">Tel.:</span> {{ $klant->telefoonnummer }}</div>
                                    </dl>
                                    <div class="mt-4 flex flex-col gap-2">
                                        <a href="{{ route('klant.edit', $klant) }}"
                                           class="inline-flex justify-center items-center rounded-md bg-amber-500 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-600">Wijzigen</a>
                                        <form method="POST" action="{{ route('klant.destroy', $klant) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full inline-flex justify-center items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                                    onclick="return confirm('Weet je zeker dat je deze klant wilt verwijderen?')">
                                                Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        {{-- Desktop (md+): scrollbare tabel bij smalle vensters --}}
                        <div class="hidden md:block overflow-x-auto -mx-4 sm:mx-0 rounded-md border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">ID</th>
                                        <th scope="col" class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Naam</th>
                                        <th scope="col" class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Adres</th>
                                        <th scope="col" class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">E-mailadres</th>
                                        <th scope="col" class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Telefoonnummer</th>
                                        <th scope="col" class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Status</th>
                                        <th scope="col" class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($klanten as $klant)
                                        @php($adres = $klant->adressen->first())
                                        <tr>
                                            <td class="px-3 lg:px-4 py-2 whitespace-nowrap text-sm">{{ $klant->klant_id }}</td>
                                            <td class="px-3 lg:px-4 py-2 text-sm font-medium">{{ $klant->voornaam }} {{ $klant->achternaam }}</td>
                                            <td class="px-3 lg:px-4 py-2 text-sm max-w-xs truncate" title="{{ $adres ? $adres->straat.', '.$adres->postcode.' '.$adres->stad : '' }}">
                                                @if ($adres)
                                                    {{ $adres->straat }}, {{ $adres->postcode }} {{ $adres->stad }}
                                                @else
                                                    <span class="text-gray-400 text-xs italic">Geen adres</span>
                                                @endif
                                            </td>
                                            <td class="px-3 lg:px-4 py-2 text-sm break-all max-w-[10rem]">{{ $klant->email }}</td>
                                            <td class="px-3 lg:px-4 py-2 text-sm whitespace-nowrap">{{ $klant->telefoonnummer }}</td>
                                            <td class="px-3 lg:px-4 py-2">
                                                @if ($klant->IsActief)
                                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Actief</span>
                                                @else
                                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">Inactief</span>
                                                @endif
                                            </td>
                                            <td class="px-3 lg:px-4 py-2">
                                                <div class="flex flex-col xl:flex-row flex-wrap gap-2">
                                                    <a href="{{ route('klant.edit', $klant) }}"
                                                       class="inline-flex justify-center items-center rounded-md bg-amber-500 px-3 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-amber-600">Wijzigen</a>
                                                    <form method="POST" action="{{ route('klant.destroy', $klant) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="w-full xl:w-auto inline-flex justify-center items-center rounded-md bg-red-600 px-3 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-red-700"
                                                                onclick="return confirm('Weet je zeker dat je deze klant wilt verwijderen?')">
                                                            Verwijderen
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
