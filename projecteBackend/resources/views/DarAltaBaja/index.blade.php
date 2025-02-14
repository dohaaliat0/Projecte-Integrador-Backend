@vite(['resources/css/index.css', 'resources/js/app.js','resources/css/app.css'])
<header class="bg-gradient-to-r from-gray-300 to-gray-600 shadow-md">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-white">
        {{ config('app.name', 'telefex') }}
    </h1>
         @include('layouts.navigation')
    </div>
</header>
@auth
    <a href="{{ route('altabaja.create') }}" class="bg-blue-500 text-white font-medium py-2 px-4 rounded-lg shadow hover:bg-blue-600 focus:ring focus:ring-blue-300">Dar de alta nuevo usuario</a>
@endauth
@auth
    <a href="{{ route('altabaja.altaAntiguoUser') }}"  class="bg-blue-500 text-white font-medium py-2 px-4 rounded-lg shadow hover:bg-blue-600 focus:ring focus:ring-blue-300">Dar de alta antiguo usuario</a>
@endauth
<table class="min-w-full bg-white">
    <thead>
        <tr>
            <th class="border border-gray-300 p-2">Name</th>
            <th class="border border-gray-300 p-2">Email</th>   
            <th class="border border-gray-300 p-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr class="hover:bg-gray-100">
                <td class="border border-gray-300 p-2">
                   {{ $user->name }}
                </td>
                <td class="border border-gray-300 p-2">
                    {{ $user->email }}
                </td>
                <td class="border border-gray-300 p-2 flex space-x-2">
                    <a href="{{ route('altabaja.edit', $user->id) }}" class="text-yellow-600 hover:underline">Editar</a>
                    <form action="{{ route('altabaja.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Dar de baja</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>