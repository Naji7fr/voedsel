<x-layouts.app title="Leverancier wijzigen">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Leverancier wijzigen — {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @php($f = 'mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500')

                    <form method="POST" action="{{ route('products.leverancier.update', [$product, $leverancier]) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Naam leverancier <span class="text-red-500">*</span></label>
                            <input type="text" name="naam" value="{{ old('naam', $leverancier->naam) }}" class="{{ $f }}" required maxlength="150">
                            @error('naam') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Contactpersoon</label>
                                <input type="text" name="contactpersoon" value="{{ old('contactpersoon', $leverancier->contactpersoon) }}" class="{{ $f }}" maxlength="100">
                                @error('contactpersoon') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Telefoonnummer</label>
                                <input type="text" name="telefoonnummer" value="{{ old('telefoonnummer', $leverancier->telefoonnummer) }}" class="{{ $f }}" maxlength="15">
                                @error('telefoonnummer') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $leverancier->email) }}" class="{{ $f }}" maxlength="100">
                            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Opmerking</label>
                            <textarea name="opmerking" rows="2" class="{{ $f }}" maxlength="255">{{ old('opmerking', $leverancier->opmerking) }}</textarea>
                            @error('opmerking') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                                Opslaan
                            </button>
                            <a href="{{ route('products.leverancier.index', $product) }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">Terug</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
