<x-app-layout>
    @vite('resources/css/ShowZones.css')
    <x-zones
        :zone="$zone"
    />

        <div class="zone-buttons">
            <a href="{{ route('webzones.index') }}" class="zone-button back">Tornar a la llista</a>
            <a href="{{ route('webzones.edit', $zone->id) }}" class="zone-button edit">Editar</a>
        </div> 

</x-app-layout>