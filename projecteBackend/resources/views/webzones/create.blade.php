<x-app-layout>
    <form action="{{ route('webzones.store') }}" method="POST" enctype="multipart/form-data">    
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre:</label>
            <input type="text" name="name" id="name" required
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 
            @error('name') border-red-500 @enderror">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado:</label>
            <select name="status" id="status" required
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 
            @error('status') border-red-500 @enderror">
            <option selected disabled>-- elige una opcion --</option>
            @foreach(\App\Enums\TypeZones::cases() as $status)
                <option>
                    {{ $status->label() }}
                </option>
            @endforeach
            </select>
            @error('status')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Actualizar
        </button>
        <a href="{{ route('webzones.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
            Tornar a la llista
        </a>
    </form>
</x-app-layout>