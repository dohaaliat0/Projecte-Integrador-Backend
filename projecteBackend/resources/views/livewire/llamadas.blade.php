<div class="calls-wrapper">
    <h2 class="calls-title">Listado de Llamadas</h2>

    <!-- Filtros -->
    <div class="filters">
        <div class="filter-group">
            <label for="zoneSelect" class="filter-label-title">Filtrar por Zona:</label>
            <select id="zoneSelect" wire:model="filterZones" multiple class="filter-select">
                @foreach ($zones as $zone)
                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label for="dateFilter" class="filter-label-title">Filtrar por Fecha:</label>
            <input type="date" wire:model="filterDate" id="dateFilter" class="filter-date-input">
        </div>

        <div class="filter-buttons">
            <button wire:click="applyFilter" class="filter-button apply">Aplicar Filtro</button>
            <button wire:click="clearFilters" class="filter-button clear">Limpiar Filtros</button>
        </div>
    </div>

    <!-- Tabla de Llamadas -->
    <div class="table-responsive">
        <table class="calls-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Operador</th>
                    <th>Detalles</th>
                    <th>Fecha y Hora</th>
                    <th>Tipo de llamada</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($calls as $call)
                    <tr>
                        <td>{{ $call['id'] }}</td>
                        <td>{{ $call['patient'] }}</td>
                        <td>{{ $call['operator'] }}</td>
                        <td>{{ $call['details'] }}</td>
                        <td>{{ $call['dateTime'] }}</td>
                        <td>{{ $call['typeCall'] }}</td>
                        <td>{{ $call['type'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>