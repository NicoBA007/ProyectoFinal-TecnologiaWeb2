<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-white tracking-tight">Bienvenido <span
                    class="text-red-600">Cinéfilo</span></h2>
            <p class="text-gray-400 text-sm mt-2">Ingresa tus credenciales para continuar</p>
        </div>

        <div>
            <label for="email" class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-1">Correo
                Electrónico</label>
            <x-text-input id="email"
                class="block mt-1 w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="tu@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 font-medium" />
        </div>

        <div class="mt-4">
            <label for="password"
                class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-1">Contraseña</label>
            <x-text-input id="password"
                class="block mt-1 w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 font-medium" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded-md bg-gray-800 border-gray-700 text-red-600 shadow-sm focus:ring-red-500 focus:ring-offset-gray-900"
                    name="remember">
                <span
                    class="ms-2 text-sm text-gray-400 hover:text-gray-200 transition-colors">{{ __('Mantener sesión iniciada') }}</span>
            </label>
        </div>

        <div class="flex flex-col space-y-4 mt-8">
            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-3 rounded-xl transition-all shadow-[0_0_20px_rgba(220,38,38,0.4)] hover:shadow-[0_0_30px_rgba(220,38,38,0.6)] transform hover:-translate-y-1">
                {{ __('ENTRAR AHORA') }}
            </button>

            <div class="text-center pt-2">
                <p class="text-sm text-gray-500">
                    ¿Aún no tienes cuenta?
                    <a href="{{ route('register') }}"
                        class="font-bold text-red-500 hover:text-red-400 transition-colors underline decoration-red-900 underline-offset-4">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </form>
</x-guest-layout>