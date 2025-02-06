@vite(['resources/css/index.css', 'resources/js/app.js','resources/css/app.css'])
<header class="bg-gradient-to-r from-gray-300 to-gray-600 shadow-md">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-white">
        {{ config('app.name', 'telefex') }}
    </h1>
         @include('layouts.navigation')
    </div>
</header>
<table class="min-w-full bg-white">
    <thead>
        <tr>
            <th class="border border-gray-300 p-2">Name</th>
            <th class="border border-gray-300 p-2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($zones as $zone)
            <tr class="hover:bg-gray-100">
                <td class="border border-gray-300 p-2">
                    <a href="{{ route('zones.show', $zone->id) }}" class="text-blue-700 hover:underline">{{ $zone->name }}</a>
                </td>
                <td class="border border-gray-300 p-2 flex space-x-2">
                    <a href="{{ route('zones.show', $zone->id) }}" class="text-green-600 hover:underline">Mostrar</a>
                    <a href="{{ route('zones.edit', $zone->id) }}" class="text-yellow-600 hover:underline">Editar</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>