<x-app-layout>
    @vite('resources/css/CreateEditZones.css');
    <div class="form-container">
        <form action="{{ route('webzones.store') }}" method="POST" enctype="multipart/form-data">    
            @csrf
            @method('POST')

            <div class="mb-4">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" required
                class="@error('name') border-red-500 @enderror">
                @error('name')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status">Estado:</label>
                <select name="status" id="status" required class="@error('status') border-red-500 @enderror">
                    <option selected disabled>-- Elige una opción --</option>
                    @foreach(\App\Enums\TypeZones::cases() as $status)
                        <option value="{{ $status->value }}" {{ old('status') == $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Crear</button>
            <a href="{{ route('webzones.index') }}" class="btn btn-secondary">Tornar a la llista</a>
        </form>
    </div>
</x-app-layout>
