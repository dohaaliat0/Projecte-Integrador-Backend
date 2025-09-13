<x-guest-layout>
    <!-- Estado de sesión -->
    <x-auth-session-status class="session-status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="cardLogin">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-input" />
            <x-input-error :messages="$errors->get('email')" class="form-error" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="form-input" />
            <x-input-error :messages="$errors->get('password')" class="form-error" />
        </div>

        <!-- Remember Me -->
        <div class="form-group form-remember">
            <input id="remember_me" type="checkbox" name="remember" class="remember-checkbox">
            <label for="remember_me" class="remember-label">{{ __('Remember me') }}</label>
        </div>

        <!-- Acciones -->
        <div class="form-actions">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-password">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="login-button">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>