<x-layouts.app title="Voorraad overzicht">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Voorraad overzicht</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4 flex items-center justify-end">
                        <a href="{{ route('products.create') }}"
                           class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                            Product toevoegen
                        </a>
                    </div>

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

                    @if($products->isEmpty())
                        <div class="bg-yellow-50 border border-yellow-400 text-yellow-800 px-4 py-3 rounded">
                            Er is geen voorraad beschikbaar.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-indigo-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Streepjescode</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Productnaam</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Categorie</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aantal op voorraad</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Actie</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->barcode }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $product->name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->category }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->stock }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <div class="flex items-center gap-2">
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
