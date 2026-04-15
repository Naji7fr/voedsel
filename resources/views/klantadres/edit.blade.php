{{-- Bestaand adres van een klant wijzigen (PUT klant.adres.update). --}}
<x-layouts.app title="Adres wijzigen">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Adres wijzigen — {{ $klant->voornaam }} {{ $klant->achternaam }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    @php($f = 'mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-base text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm')

                    <form method="POST" action="{{ route('klant.adres.update', [$klant, $adres]) }}" class="space-y-4">
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Straat <span class="text-red-500">*</span></label>
                            <input type="text" name="straat" value="{{ old('straat', $adres->straat) }}" class="{{ $f }}" required maxlength="150">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Postcode <span class="text-red-500">*</span></label>
                                <input type="text" name="postcode" value="{{ old('postcode', $adres->postcode) }}" class="{{ $f }}" required maxlength="10">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stad <span class="text-red-500">*</span></label>
                                <input type="text" name="stad" value="{{ old('stad', $adres->stad) }}" class="{{ $f }}" required maxlength="100">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Opmerking</label>
                            <textarea name="opmerking" rows="2" class="{{ $f }}" maxlength="255">{{ old('opmerking', $adres->opmerking) }}</textarea>
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row sm:items-center gap-3 pt-2">
                            <a href="{{ route('klant.adres.index', $klant) }}" class="text-center sm:text-left text-sm font-semibold text-gray-600 hover:text-gray-900 py-2">Terug</a>
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
