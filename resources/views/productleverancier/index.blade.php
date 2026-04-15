<x-layouts.app title="Leveranciers van {{ $product->name }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Leveranciers — {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if (session('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex items-center gap-3">
                        <a href="{{ route('products.leverancier.create', $product) }}"
                           class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                            Leverancier toevoegen
                        </a>
                        <a href="{{ route('products.create') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">
                            ← Terug naar producten
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Naam</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Contactpersoon</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Telefoon</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Opmerking</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($leveranciers as $leverancier)
                                    <tr>
                                        <td class="px-4 py-2 font-medium">{{ $leverancier->naam }}</td>
                                        <td class="px-4 py-2">{{ $leverancier->contactpersoon ?? '—' }}</td>
                                        <td class="px-4 py-2">{{ $leverancier->telefoonnummer ?? '—' }}</td>
                                        <td class="px-4 py-2">{{ $leverancier->email ?? '—' }}</td>
                                        <td class="px-4 py-2">{{ $leverancier->opmerking ?? '—' }}</td>
                                        <td class="px-4 py-2">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('products.leverancier.edit', [$product, $leverancier]) }}"
                                                   class="inline-flex items-center rounded-md bg-amber-500 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-600">
                                                    Wijzigen
                                                </a>
                                                <form method="POST" action="{{ route('products.leverancier.destroy', [$product, $leverancier]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700"
                                                            onclick="return confirm('Weet je zeker dat je deze leverancier wilt verwijderen?')">
                                                        Verwijderen
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                            Geen leveranciers gevonden voor dit product.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
