<x-layouts.app title="Home | Voorraadbeheer">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Home</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Welkom bij Voorraadbeheer</h1>
                    <p class="mb-6 text-gray-600">Welkom in het voorraadbeheer. Open de voorraadpagina om het actuele overzicht van producten te bekijken.</p>
                    <a href="{{ route('inventory.index') }}"
                       class="inline-block px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700 transition">
                        Open voorraadpagina
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
