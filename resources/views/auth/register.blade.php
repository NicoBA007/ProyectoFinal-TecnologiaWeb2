<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-white tracking-tight uppercase">Crea tu <span
                    class="text-red-600">Cuenta</span>
            </h2>
            <p class="text-gray-400 text-sm mt-2 uppercase tracking-widest text-[10px] font-bold">Únete a PrimeCinemas y
                califica tus estrenos favoritos</p>
        </div>

        <div class="space-y-4">
            <div>
                <label for="nombres"
                    class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-1">Nombres</label>
                <x-text-input id="nombres"
                    class="block mt-1 w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl"
                    type="text" name="nombres" :value="old('nombres')" required autofocus autocomplete="given-name"
                    placeholder="Ej. Daniel" />
                <x-input-error :messages="$errors->get('nombres')" class="mt-2 text-red-500 font-medium" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="apellido_paterno"
                        class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-1">Apellido
                        Paterno</label>
                    <x-text-input id="apellido_paterno"
                        class="block mt-1 w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl"
                        type="text" name="apellido_paterno" :value="old('apellido_paterno')" required
                        autocomplete="family-name" placeholder="Maldonado" />
                    <x-input-error :messages="$errors->get('apellido_paterno')" class="mt-2 text-red-500 font-medium" />
                </div>

                <div>
                    <label for="apellido_materno"
                        class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-1">Apellido
                        Materno</label>
                    <x-text-input id="apellido_materno"
                        class="block mt-1 w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl"
                        type="text" name="apellido_materno" :value="old('apellido_materno')" autocomplete="family-name"
                        placeholder="Cespedes" />
                    <x-input-error :messages="$errors->get('apellido_materno')" class="mt-2 text-red-500 font-medium" />
                </div>
            </div>
        </div>

        <div class="mt-4">
            <label for="email" class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-1">Correo
                Electrónico</label>
            <x-text-input id="email"
                class="block mt-1 w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl"
                type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="tu@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 font-medium" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <label for="password"
                    class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-1">Contraseña</label>
                <x-text-input id="password"
                    class="block mt-1 w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl"
                    type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 font-medium" />
            </div>

            <div>
                <label for="password_confirmation"
                    class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-1">Confirmar</label>
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl"
                    type="password" name="password_confirmation" required autocomplete="new-password"
                    placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')"
                    class="mt-2 text-red-500 font-medium" />
            </div>
        </div>

        <div class="flex flex-col space-y-4 mt-8">
            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-xl transition-all shadow-[0_0_20px_rgba(220,38,38,0.4)] hover:shadow-[0_0_30px_rgba(220,38,38,0.6)] transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                REGISTRARSE AHORA
            </button>

            <a class="text-center text-xs font-bold uppercase tracking-widest text-gray-500 hover:text-white transition-colors underline decoration-red-600 underline-offset-8"
                href="{{ route('login') }}">
                ¿Ya tienes cuenta? Inicia sesión
            </a>
        </div>
    </form>
</x-guest-layout>