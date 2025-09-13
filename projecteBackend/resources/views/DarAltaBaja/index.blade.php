<x-app-layout>
    <div class="container">
        @auth
            <a href="{{ route('altabaja.create') }}" class="btn-primary">Dar de alta nuevo usuario</a>
        @endauth
        @auth
            <a href="{{ route('altabaja.altaAntiguoUser') }}" class="btn-primary">Dar de alta antiguo usuario</a>
        @endauth

        <table class="custom-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>   
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td >
                            <a href="{{ route('altabaja.edit', $user->id) }}" class="edit-link">Editar</a>
                            <form action="{{ route('altabaja.destroy', $user->id) }}" method="POST" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Dar de baja</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
