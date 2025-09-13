<div class="content-wrapper">
    <h2 class="title">Lista de Pacientes</h2>

    <!-- Filtros -->
    <div class="filter-section">
        <h3 class="filter-title">Filtrar por idioma</h3>
        <div class="filter-container">
            @foreach ($languages as $language)
                <label class="filter-label">
                    <input type="checkbox" wire:model="filterLanguages" value="{{ $language->id }}">
                    <span>{{ $language->name }}</span>
                </label>
            @endforeach
        </div>
    </div>
    
    <div class="filter-section">
        <h3 class="filter-title">Filtrar por zona</h3>
        <div class="filter-container">
            @foreach ($zones as $zone)
                <label class="filter-label">
                    <input type="checkbox" wire:model="filterZones" value="{{ $zone->id }}">
                    <span>{{ $zone->name }}</span>
                </label>
            @endforeach
        </div>
    </div>
    
    

    <button wire:click="applyFilter" class="button">Aplicar Filtros</button>
    <button wire:click="clearFilters" class="button button-secondary">Limpiar Filtros</button>

    <!-- Tabla de operadores -->
    <h2 class="title">Lista de Operadores</h2>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Seleccionar</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($operators as $operator)
                    <tr>
                        <td class="text-center">
                            <input type="radio" name="operator" wire:model="selectedOperator" value="{{ $operator['id'] }}">
                        </td>
                        <td>{{ $operator['name'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tabla de pacientes -->
    <h2 class="title">Lista de Pacientes</h2>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Seleccionar</th>
                    <th>Nombre</th>
                    <th>Idiomas</th>
                    <th>Zona</th>
                    <th>Operador</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" wire:model="selectedPatients" value="{{ $patient['id'] }}">
                        </td>
                        <td>{{ $patient['fullName'] }}</td>
                        <td>{{ implode(', ', $patient['languages']) }}</td>
                        <td>{{ $patient['zone'] }}</td>
                        <td>{{ $patient['operator'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Botón para asignar operador -->
    <button wire:click="asignarOperador" class="button">Asignar Operador</button>
</div>