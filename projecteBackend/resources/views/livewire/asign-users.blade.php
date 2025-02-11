<div>
    <h2 class="text-xl font-bold mb-4">Lista de Pacientes</h2>

    <!-- Filtros -->
    <div class="mb-4">
        <h3 class="font-semibold">Filtrar por idioma</h3>
        @foreach ($languages as $language)
            <label class="mr-2">
                <input type="checkbox" wire:model="filterLanguages" value="{{ $language->id }}"> {{ $language->name }}
            </label>
        @endforeach
    </div>

    <div class="mb-4">
        <h3 class="font-semibold">Filtrar por zona</h3>
        @foreach ($zones as $zone)
            <label class="mr-2">
                <input type="checkbox" wire:model="filterZones" value="{{ $zone->id }}"> {{ $zone->name }}
            </label>
        @endforeach
    </div>

    <button wire:click="applyFilter" class="bg-blue-500 text-white px-4 py-2 rounded">Aplicar Filtros</button>
    <button wire:click="clearFilters" class="bg-blue-500 text-white px-4 py-2 rounded">Limpiar Filtros</button>

    <!-- Tabla de operadores -->
    <h2 class="text-xl font-bold mt-6 mb-4">Lista de Operadores</h2>
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Seleccionar</th>
                <th class="border px-4 py-2">Nombre</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($operators as $operator)
                <tr>
                    <td class="border px-4 py-2 text-center">
                        <input type="radio" name="operator" wire:model="selectedOperator" value="{{ $operator['id'] }}">
                    </td>
                    <td class="border px-4 py-2">{{ $operator['name'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabla de pacientes -->
    <h2 class="text-xl font-bold mt-6 mb-4">Lista de Pacientes</h2>
    <table class="w-full border mt-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Seleccionar</th>
                <th class="border px-4 py-2">Nombre</th>
                <th class="border px-4 py-2">Idiomas</th>
                <th class="border px-4 py-2">Zona</th>
                <th class="border px-4 py-2">Operador</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td class="border px-4 py-2 text-center">
                        <input type="checkbox" wire:model="selectedPatients" value="{{ $patient['id'] }}">
                    </td>
                    <td class="border px-4 py-2">{{ $patient['fullName'] }}</td>
                    <td class="border px-4 py-2">{{ implode(', ', $patient['languages']) }}</td>
                    <td class="border px-4 py-2">{{ $patient['zone'] }}</td>
                    <td class="border px-4 py-2">{{ $patient['operator'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Botón para asignar operador -->
    <button wire:click="asignarOperador" class="bg-blue-500 text-white px-4 py-2 rounded">Asignar Operador</button>
</div>