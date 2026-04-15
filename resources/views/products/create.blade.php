<x-layouts.app title="Productbeheer | Product toevoegen">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Productbeheer</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto space-y-6 sm:px-6 lg:px-8">

            {{-- Formulier: product toevoegen --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Product toevoegen</h2>

                    @if(session('status'))
                        <div class="mb-4 rounded border border-green-300 bg-green-50 px-4 py-3 text-green-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 rounded border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 rounded border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @php($f = 'mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500')

                    <form method="POST" action="{{ route('products.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="barcode" class="block text-sm font-medium text-gray-700">Streepjescode <span class="text-red-500">*</span></label>
                            <input id="barcode" name="barcode" type="text" value="{{ old('barcode') }}" class="{{ $f }}">
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Productnaam <span class="text-red-500">*</span></label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" class="{{ $f }}">
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Categorie <span class="text-red-500">*</span></label>
                            <input id="category" name="category" type="text" value="{{ old('category') }}"
                                   pattern="[A-Za-zÀ-ÿ\s]+"
                                   title="Gebruik alleen letters"
                                   oninput="this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '')"
                                   class="{{ $f }}">
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700">Aantal <span class="text-red-500">*</span></label>
                            <input id="stock" name="stock" type="number" min="0" value="{{ old('stock') }}" class="{{ $f }}">
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                                Product opslaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabel: bestaande producten --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="mb-4 text-xl font-bold text-gray-900">Bestaande producten</h2>

                    @if($products->isEmpty())
                        <div class="rounded border border-yellow-300 bg-yellow-50 px-4 py-3 text-yellow-800">
                            Er zijn nog geen producten om te wijzigen.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Streepjescode</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Productnaam</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Categorie</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aantal</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Actie</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach($products as $product)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->barcode }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->category }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->stock }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('products.leverancier.index', $product) }}"
                                                   class="inline-flex items-center rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-600">
                                                    Leveranciers
                                                </a>
                                                <a href="{{ route('products.edit', $product) }}"
                                                   class="inline-flex items-center rounded-md bg-amber-500 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-600">
                                                    Wijzigen
                                                </a>
                                                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">
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
