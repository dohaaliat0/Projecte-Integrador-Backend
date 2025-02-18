<div>
    <h2 class="text-lg font-semibold mb-4">Listado de Llamadas</h2>

    <!-- Filtros -->
    <div class="mb-4">
        <label for="zoneFilter">Filtrar por Zona:</label>
        <div class="filter-container">
            @foreach ($zones as $zone)
                <label class="filter-label">
                    <input type="checkbox" wire:model="filterZones" value="{{ $zone->id }}">
                    <span>{{ $zone->name }}</span>
                </label>
            @endforeach
        </div>

        <label for="dateFilter" class="ml-4">Filtrar por Fecha:</label>
        <input type="date" wire:model="filterDate" id="dateFilter" class="border p-2 rounded">
        
        <button wire:click="applyFilter" class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Aplicar Filtro</button>
        <button wire:click="clearFilters" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Limpiar Filtros</button>
    </div>

    <!-- Tabla de Llamadas -->
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Paciente</th>
                <th class="border border-gray-300 px-4 py-2">Operador</th>
                <th class="border border-gray-300 px-4 py-2">Detalles</th>
                <th class="border border-gray-300 px-4 py-2">Fecha y Hora</th>
                <th class="border border-gray-300 px-4 py-2">Tipo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calls as $call)
                <tr class="border border-gray-300">
                    <td class="border border-gray-300 px-4 py-2">{{ $call['id'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $call['patient'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $call['operator'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $call['details'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $call['dateTime'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $call['type'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
