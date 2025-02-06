<x-app-layout>
        <x-zones
            :zone="$zone"
        />

        <div class="mt-6 flex justify-center space-x-4">
            <a href="{{ route('webzones.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                Tornar a la llista
            </a>
            {{-- @auth
                <a href="{{ route('webzones.edit', $zone->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    Editar
                </a>
            @endauth  --}}
        </div> 
</x-app-layout>