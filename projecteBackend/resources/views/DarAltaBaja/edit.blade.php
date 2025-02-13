<x-app-layout>
    <form action="{{ route('altabaja.updateAltaAntiguoUser') }}" method="POST" enctype="multipart/form-data">    
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Usuario:</label>
            <select name="user_id" id="user_id" required
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 
            @error('user_id') border-red-500 @enderror">
            @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $user->user_id) == $user->id ? 'selected' : '' }}>
            {{ $user->name }}
            </option>
            @endforeach
            </select>
            @error('user_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Dar de alta
        </button>
        <a href="{{ route('altabaja.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
            Tornar a la llista
        </a>
    </form>
</x-app-layout>