<x-app-layout>
    @vite('resources/css/zones.css')
    <div class="container">
        @auth
            <a href="{{ route('webzones.create') }}" class="create-btn">Crear Equip</a>
        @endauth

        <table class="custom-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zones as $zone)
                    <tr>
                        <td class="zone-name">
                            <a href="{{ route('webzones.show', $zone->id) }}" class="action-link show">{{ $zone->name }}</a>
                        </td>
                        <td data-label="Acciones" class="flex space-x-2">
                            <a href="{{ route('webzones.show', $zone->id) }}" class="action-link show">Mostrar</a>
                            <a href="{{ route('webzones.edit', $zone->id) }}" class="action-link edit">Editar</a>
                            <form action="{{ route('webzones.destroy', $zone->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-link delete">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>            
        </table>
    </div>
</x-app-layout>
