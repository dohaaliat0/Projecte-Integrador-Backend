<x-app-layout>

    <form action="{{ route('altabaja.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 
            @error('name') border-red-500 @enderror">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Surnames -->
        <div class="mb-4">
            <label for="surnames" class="block text-sm font-medium text-gray-700 mb-1">Apellidos:</label>
            <input type="text" name="surnames" id="surnames" value="{{ old('surnames', $user->surnames) }}" required
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 
            @error('surnames') border-red-500 @enderror">
            @error('surnames')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone:</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 
            @error('phone') border-red-500 @enderror">
            @error('phone')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required autofocus
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 
            @error('email') border-red-500 @enderror">
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña:</label>
            <input type="password" name="password" id="password"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 
            @error('password') border-red-500 @enderror">
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Contraseña:</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 
            @error('password_confirmation') border-red-500 @enderror">
            @error('password_confirmation')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Actualizar
            </button>

            <a href="{{ route('altabaja.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                Tornar a la llista
            </a>
        </div>
        
    </form>
</x-app-layout>