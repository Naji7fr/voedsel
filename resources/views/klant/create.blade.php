{{-- Formulier: nieuwe klant + eerste adres (één record KlantAdres bij opslaan). --}}
<x-layouts.app title="Klant toevoegen">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Klant toevoegen</h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    {{-- Tailwind-classes voor invoervelden (leesbaar op mobiel: text-base voorkomt zoom op iOS) --}}
                    @php($f = 'mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-base text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm')

                    <form method="POST" action="{{ route('klant.store') }}" class="space-y-4">
                        @csrf

                        @if (session('error'))
                            <div class="rounded-md border border-red-300 bg-red-50 px-4 py-3 text-red-800 text-sm" role="alert">{{ session('error') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="rounded-md border border-red-300 bg-red-50 px-4 py-3 text-red-800 text-sm" role="alert">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Voornaam <span class="text-red-500">*</span></label>
                                <input type="text" name="voornaam" value="{{ old('voornaam') }}" class="{{ $f }}" required maxlength="100" autocomplete="given-name">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Achternaam <span class="text-red-500">*</span></label>
                                <input type="text" name="achternaam" value="{{ old('achternaam') }}" class="{{ $f }}" required maxlength="100" autocomplete="family-name">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Telefoonnummer <span class="text-red-500">*</span></label>
                                <input type="text" name="telefoonnummer" value="{{ old('telefoonnummer') }}" class="{{ $f }}" required maxlength="15" inputmode="numeric" autocomplete="tel">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" class="{{ $f }}" required maxlength="100" autocomplete="email">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Aantal volwassenen</label>
                                <input type="number" name="aantal_volwassenen" value="{{ old('aantal_volwassenen', 0) }}" class="{{ $f }}" min="0" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Aantal kinderen</label>
                                <input type="number" name="aantal_kinderen" value="{{ old('aantal_kinderen', 0) }}" class="{{ $f }}" min="0" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Aantal babys</label>
                                <input type="number" name="aantal_babys" value="{{ old('aantal_babys', 0) }}" class="{{ $f }}" min="0" required>
                            </div>
                        </div>

                        {{-- Hoofdadres (wordt in store() los opgeslagen in KlantAdres) --}}
                        <div class="border-t pt-4 mt-2">
                            <p class="text-sm font-semibold text-gray-600 mb-3">Adres</p>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Straat <span class="text-red-500">*</span></label>
                                    <input type="text" name="straat" value="{{ old('straat') }}" class="{{ $f }}" required maxlength="150" autocomplete="street-address">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Postcode <span class="text-red-500">*</span></label>
                                        <input type="text" name="postcode" value="{{ old('postcode') }}" class="{{ $f }}" required maxlength="10" autocomplete="postal-code">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Stad <span class="text-red-500">*</span></label>
                                        <input type="text" name="stad" value="{{ old('stad') }}" class="{{ $f }}" required maxlength="100" autocomplete="address-level2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="IsActief" class="{{ $f }}">
                                <option value="1" {{ old('IsActief', '1') == '1' ? 'selected' : '' }}>Actief</option>
                                <option value="0" {{ old('IsActief') == '0' ? 'selected' : '' }}>Inactief</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Opmerking</label>
                            <textarea name="Opmerking" rows="2" class="{{ $f }}" maxlength="255">{{ old('Opmerking') }}</textarea>
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row sm:items-center gap-3 pt-2">
                            <a href="{{ route('klant.index') }}" class="text-center sm:text-left text-sm font-semibold text-gray-600 hover:text-gray-900 py-2">Terug</a>
                            <button type="submit"
                                    class="inline-flex justify-center items-center rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 w-full sm:w-auto">
                                Klant toevoegen
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
