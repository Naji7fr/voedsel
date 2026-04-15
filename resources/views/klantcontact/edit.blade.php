{{-- Bestaand contact van een klant bewerken. --}}
<x-layouts.app title="Contact wijzigen">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Contact wijzigen — {{ $klant->voornaam }} {{ $klant->achternaam }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    @php($f = 'mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-base text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm')

                    <form method="POST" action="{{ route('klant.contact.update', [$klant, $contact]) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

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
                                <input type="text" name="voornaam" value="{{ old('voornaam', $contact->voornaam) }}" class="{{ $f }}" required maxlength="100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Achternaam <span class="text-red-500">*</span></label>
                                <input type="text" name="achternaam" value="{{ old('achternaam', $contact->achternaam) }}" class="{{ $f }}" required maxlength="100">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Relatie</label>
                                <input type="text" name="relatie" value="{{ old('relatie', $contact->relatie) }}" class="{{ $f }}" maxlength="50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Telefoonnummer <span class="text-red-500">*</span></label>
                                <input type="text" name="telefoonnummer" value="{{ old('telefoonnummer', $contact->telefoonnummer) }}" class="{{ $f }}" required maxlength="15" inputmode="numeric">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $contact->email) }}" class="{{ $f }}" maxlength="100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Opmerking</label>
                            <textarea name="opmerking" rows="2" class="{{ $f }}" maxlength="255">{{ old('opmerking', $contact->opmerking) }}</textarea>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_primair" id="is_primair" value="1"
                                   {{ old('is_primair', $contact->is_primair) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="is_primair" class="text-sm font-medium text-gray-700">Primair contact</label>
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row sm:items-center gap-3 pt-2">
                            <a href="{{ route('klant.contact.index', $klant) }}" class="text-center sm:text-left text-sm font-semibold text-gray-600 hover:text-gray-900 py-2">Terug</a>
                            <button type="submit"
                                    class="inline-flex justify-center items-center rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 w-full sm:w-auto">
                                Opslaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
