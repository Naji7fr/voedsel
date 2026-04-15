<x-layouts.app title="Productbeheer | Product wijzigen">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Product wijzigen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="mb-6 text-2xl font-bold text-gray-900">Product wijzigen</h1>

                    @if(session('status'))
                        <div class="mb-4 rounded border border-green-300 bg-green-50 px-4 py-3 text-green-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 rounded border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @php($f = 'mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500')

                    <form method="POST" action="{{ route('products.update', $product) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="barcode" class="block text-sm font-medium text-gray-700">Streepjescode <span class="text-red-500">*</span></label>
                            <input id="barcode" name="barcode" type="text" value="{{ old('barcode', $product->barcode) }}" class="{{ $f }}">
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Productnaam <span class="text-red-500">*</span></label>
                            <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" class="{{ $f }}">
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Categorie <span class="text-red-500">*</span></label>
                            <input id="category" name="category" type="text" value="{{ old('category', $product->category) }}"
                                   pattern="[A-Za-zÀ-ÿ\s]+"
                                   title="Gebruik alleen letters"
                                   oninput="this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '')"
                                   class="{{ $f }}">
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700">Aantal <span class="text-red-500">*</span></label>
                            <input id="stock" name="stock" type="number" min="0" value="{{ old('stock', $product->stock) }}" class="{{ $f }}">
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                    class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                                Wijzigingen opslaan
                            </button>
                            <a href="{{ route('products.create') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">
                                Terug naar productbeheer
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
