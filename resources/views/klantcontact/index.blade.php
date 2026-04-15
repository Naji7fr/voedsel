{{-- Contactpersonen bij één klant (optioneel; vereist tabel KlantContact in de database). --}}
<x-layouts.app title="Contacten van {{ $klant->voornaam }} {{ $klant->achternaam }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Contacten — {{ $klant->voornaam }} {{ $klant->achternaam }}
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
                        <a href="{{ route('klant.contact.create', $klant) }}"
                           class="inline-flex w-full sm:w-auto justify-center items-center rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                            Contact toevoegen
                        </a>
                        <a href="{{ route('klant.index') }}"
                           class="text-center sm:text-left text-sm font-semibold text-gray-600 hover:text-gray-900">
                            ← Terug naar klanten
                        </a>
                    </div>

                    @if ($contacten->isEmpty())
                        <p class="text-center text-gray-500 py-8 text-sm sm:text-base">Geen contacten gevonden voor deze klant.</p>
                    @else
                        <div class="space-y-4 lg:hidden">
                            @foreach ($contacten as $contact)
                                <article class="rounded-lg border border-gray-200 p-4 shadow-sm">
                                    <p class="font-semibold text-gray-900">{{ $contact->voornaam }} {{ $contact->achternaam }}</p>
                                    <p class="text-sm text-gray-600 mt-1">Relatie: {{ $contact->relatie ?? '—' }}</p>
                                    <p class="text-sm text-gray-700 mt-2">Tel. {{ $contact->telefoonnummer }}</p>
                                    <p class="text-sm text-gray-700 break-all">{{ $contact->email ?? '—' }}</p>
                                    <p class="mt-2">
                                        @if ($contact->is_primair)
                                            <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Primair</span>
                                        @else
                                            <span class="inline-block px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 rounded">Niet primair</span>
                                        @endif
                                    </p>
                                    <div class="mt-4 flex flex-col gap-2">
                                        <a href="{{ route('klant.contact.edit', [$klant, $contact]) }}"
                                           class="inline-flex justify-center items-center rounded-md bg-amber-500 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-600">Wijzigen</a>
                                        <form method="POST" action="{{ route('klant.contact.destroy', [$klant, $contact]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-full inline-flex justify-center items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                                    onclick="return confirm('Weet je zeker dat je dit contact wilt verwijderen?')">
                                                Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="hidden lg:block overflow-x-auto rounded-md border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Naam</th>
                                        <th class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Relatie</th>
                                        <th class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Telefoon</th>
                                        <th class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                        <th class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Primair</th>
                                        <th class="px-3 lg:px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($contacten as $contact)
                                        <tr>
                                            <td class="px-3 lg:px-4 py-2 text-sm">{{ $contact->voornaam }} {{ $contact->achternaam }}</td>
                                            <td class="px-3 lg:px-4 py-2 text-sm">{{ $contact->relatie ?? '—' }}</td>
                                            <td class="px-3 lg:px-4 py-2 text-sm whitespace-nowrap">{{ $contact->telefoonnummer }}</td>
                                            <td class="px-3 lg:px-4 py-2 text-sm break-all max-w-[12rem]">{{ $contact->email ?? '—' }}</td>
                                            <td class="px-3 lg:px-4 py-2">
                                                @if ($contact->is_primair)
                                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Ja</span>
                                                @else
                                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 rounded">Nee</span>
                                                @endif
                                            </td>
                                            <td class="px-3 lg:px-4 py-2">
                                                <div class="flex flex-col xl:flex-row gap-2">
                                                    <a href="{{ route('klant.contact.edit', [$klant, $contact]) }}"
                                                       class="inline-flex justify-center items-center rounded-md bg-amber-500 px-3 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-amber-600">Wijzigen</a>
                                                    <form method="POST" action="{{ route('klant.contact.destroy', [$klant, $contact]) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="w-full xl:w-auto inline-flex justify-center items-center rounded-md bg-red-600 px-3 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-red-700"
                                                                onclick="return confirm('Weet je zeker dat je dit contact wilt verwijderen?')">
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
