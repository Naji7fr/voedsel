{{-- Overzicht: alle adressen van één klant (route: klant.adres.index). --}}
<x-layouts.app title="Adressen van {{ $klant->voornaam }} {{ $klant->achternaam }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Adressen — {{ $klant->voornaam }} {{ $klant->achternaam }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-md text-sm sm:text-base">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-md text-sm sm:text-base">{{ session('error') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    <div class="mb-4 flex flex-col sm:flex-row sm:flex-wrap gap-3 sm:items-center">
                        <a href="{{ route('klant.adres.create', $klant) }}"
                           class="inline-flex w-full sm:w-auto justify-center items-center rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                            Adres toevoegen
                        </a>
                        <a href="{{ route('klant.index') }}" class="text-center sm:text-left text-sm font-semibold text-gray-600 hover:text-gray-900">
                            ← Terug naar klanten
                        </a>
                    </div>

                    @if ($adressen->isEmpty())
                        <p class="text-center text-gray-500 py-8 text-sm sm:text-base">Geen adressen gevonden voor deze klant.</p>
                    @else
                        <div class="space-y-4 md:hidden">
                            @foreach ($adressen as $adres)
                                <article class="rounded-lg border border-gray-200 p-4 shadow-sm">
                                    <p class="font-medium text-gray-900">{{ $adres->straat }}</p>
                                    <p class="text-sm text-gray-700">{{ $adres->postcode }} {{ $adres->stad }}</p>
                                    @if ($adres->opmerking)
                                        <p class="text-sm text-gray-500 mt-2">{{ $adres->opmerking }}</p>
                                    @endif
                                    <div class="mt-4 flex flex-col gap-2">
                                        <a href="{{ route('klant.adres.edit', [$klant, $adres]) }}"
                                           class="inline-flex justify-center items-center rounded-md bg-amber-500 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-600">Wijzigen</a>
                                        <form method="POST" action="{{ route('klant.adres.destroy', [$klant, $adres]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full inline-flex justify-center items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                                    onclick="return confirm('Weet je zeker dat je dit adres wilt verwijderen?')">
                                                Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="hidden md:block overflow-x-auto rounded-md border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Straat</th>
                                        <th class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Postcode</th>
                                        <th class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Stad</th>
                                        <th class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Opmerking</th>
                                        <th class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($adressen as $adres)
                                        <tr>
                                            <td class="px-3 lg:px-4 py-2 text-sm">{{ $adres->straat }}</td>
                                            <td class="px-3 lg:px-4 py-2 text-sm whitespace-nowrap">{{ $adres->postcode }}</td>
                                            <td class="px-3 lg:px-4 py-2 text-sm">{{ $adres->stad }}</td>
                                            <td class="px-3 lg:px-4 py-2 text-sm max-w-xs truncate">{{ $adres->opmerking ?? '—' }}</td>
                                            <td class="px-3 lg:px-4 py-2">
                                                <div class="flex flex-col xl:flex-row gap-2">
                                                    <a href="{{ route('klant.adres.edit', [$klant, $adres]) }}"
                                                       class="inline-flex justify-center items-center rounded-md bg-amber-500 px-3 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-amber-600">Wijzigen</a>
                                                    <form method="POST" action="{{ route('klant.adres.destroy', [$klant, $adres]) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="w-full xl:w-auto inline-flex justify-center items-center rounded-md bg-red-600 px-3 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-red-700"
                                                                onclick="return confirm('Weet je zeker dat je dit adres wilt verwijderen?')">
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
