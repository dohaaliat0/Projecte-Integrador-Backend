<x-app-layout>
    @vite('resources/css/DarAltaAntiguoUser.css')
    <div class="container">
        <div class="form-container">
            <form action="{{ route('altabaja.updateAltaAntiguoUser', ['user' => $user->id])  }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="user_id" class="form-label">Usuario:</label>
                    <select name="user_id" id="user_id" required class="form-select @error('user_id') border-red-500 @enderror">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="button-primary">Dar de alta</button>
                    <a href="{{ route('altabaja.index') }}" class="button-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
