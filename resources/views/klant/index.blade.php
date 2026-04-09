<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Klant Overzicht') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Succesmelding --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Foutmelding bijv. actieve klant verwijderen --}}
            @if (session('error'))
                <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('klant.create') }}" class="btn btn-primary">
                            Klant toevoegen
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Gezinsnaam</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Adres</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Postcode</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Telefoon</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($klanten as $klant)
                                    <tr>
                                        <td class="px-4 py-2">{{ $klant->klant_id }}</td>
                                        <td class="px-4 py-2">{{ $klant->gezinsnaam }}</td>
                                        <td class="px-4 py-2">{{ $klant->adres }}</td>
                                        <td class="px-4 py-2">{{ $klant->postcode }}</td>
                                        <td class="px-4 py-2">{{ $klant->telefoonnummer }}</td>
                                        <td class="px-4 py-2">{{ $klant->email }}</td>
                                        <td class="px-4 py-2">
                                            @if ($klant->IsActief)
                                                <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Actief</span>
                                            @else
                                                <span class="inline-block px-2 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">Inactief</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <div class="action-buttons">
                                                <a href="{{ route('klant.edit', $klant) }}" class="btn btn-edit">Wijzigen</a>
                                                <form method="POST" action="{{ route('klant.destroy', $klant) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Weet je zeker dat je deze klant wilt verwijderen?')">
                                                        Verwijderen
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">
                                            Er zijn geen klanten geregistreerd.
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
</x-app-layout>
