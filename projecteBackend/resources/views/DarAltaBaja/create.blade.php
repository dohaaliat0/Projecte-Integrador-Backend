<x-app-layout>
    @vite('resources/css/CreateEditDarAltaBaja.css')
    <div class="container">
        <div class="form-container">
            <form action="{{ route('altabaja.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" name="name" id="name" required class="form-input @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Surnames -->
                <div class="mb-4">
                    <label for="surnames" class="form-label">Apellidos:</label>
                    <input type="text" name="surnames" id="surnames" required class="form-input @error('surnames') border-red-500 @enderror">
                    @error('surnames')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label for="phone" class="form-label">Teléfono:</label>
                    <input type="text" name="phone" id="phone" required class="form-input @error('phone') border-red-500 @enderror">
                    @error('phone')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" :value="old('email')" required autofocus class="form-input @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" name="password" id="password" required class="form-input @error('password') border-red-500 @enderror">
                    @error('password')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="form-input @error('password_confirmation') border-red-500 @enderror">
                    @error('password_confirmation')
                    <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="button-primary">
                        Crear
                    </button>

                    <a href="{{ route('altabaja.index') }}" class="button-secondary">
                        Volver
                    </a>
                </div>
                
            </form>
        </div>
    </div>

</x-app-layout>
