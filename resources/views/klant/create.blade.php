<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klant toevoegen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('klant.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gezinsnaam</label>
                            <input type="text" name="gezinsnaam" value="{{ old('gezinsnaam') }}" class="mt-1 block w-full rounded border-gray-300" required maxlength="100">
                            @error('gezinsnaam') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Adres</label>
                            <input type="text" name="adres" value="{{ old('adres') }}" class="mt-1 block w-full rounded border-gray-300" required maxlength="150">
                            @error('adres') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Postcode</label>
                            <input type="text" name="postcode" value="{{ old('postcode') }}" class="mt-1 block w-full rounded border-gray-300" required maxlength="10">
                            @error('postcode') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Telefoonnummer</label>
                            <input type="text" name="telefoonnummer" value="{{ old('telefoonnummer') }}" class="mt-1 block w-full rounded border-gray-300" required maxlength="15">
                            @error('telefoonnummer') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded border-gray-300" required maxlength="100">
                            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Aantal volwassenen</label>
                                <input type="number" name="aantal_volwassenen" value="{{ old('aantal_volwassenen', 0) }}" class="mt-1 block w-full rounded border-gray-300" min="0" required>
                                @error('aantal_volwassenen') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Aantal kinderen</label>
                                <input type="number" name="aantal_kinderen" value="{{ old('aantal_kinderen', 0) }}" class="mt-1 block w-full rounded border-gray-300" min="0" required>
                                @error('aantal_kinderen') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Aantal babys</label>
                                <input type="number" name="aantal_babys" value="{{ old('aantal_babys', 0) }}" class="mt-1 block w-full rounded border-gray-300" min="0" required>
                                @error('aantal_babys') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="IsActief" class="mt-1 block w-full rounded border-gray-300">
                                <option value="1" {{ old('IsActief', '1') == '1' ? 'selected' : '' }}>Actief</option>
                                <option value="0" {{ old('IsActief') == '0' ? 'selected' : '' }}>Inactief</option>
                            </select>
                            @error('IsActief') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Opmerking</label>
                            <textarea name="Opmerking" rows="2" class="mt-1 block w-full rounded border-gray-300" maxlength="255">{{ old('Opmerking') }}</textarea>
                            @error('Opmerking') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit" class="btn btn-primary">
                                Klant toevoegen
                            </button>
                            <a href="{{ route('klant.index') }}" class="btn-link">Terug</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
