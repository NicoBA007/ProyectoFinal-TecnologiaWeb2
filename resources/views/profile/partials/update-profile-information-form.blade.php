<section>
    <header>
        <h2 class="text-lg font-black uppercase tracking-tighter text-gray-900 dark:text-white">
            Información del <span class="text-red-600">Perfil</span>
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 uppercase tracking-widest text-[10px] font-bold">
            Actualiza tus nombres, apellidos y dirección de correo electrónico.
        </p>
    </header>

    {{-- Eliminamos el formulario de verificación que causaba el error RouteNotFoundException --}}

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="nombres" value="Nombres" class="uppercase text-[10px] font-black tracking-widest" />
            <x-text-input id="nombres" name="nombres" type="text"
                class="mt-1 block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 shadow-sm"
                :value="old('nombres', $user->nombres)" required autofocus autocomplete="given-name" />
            <x-input-error class="mt-2" :messages="$errors->get('nombres')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="apellido_paterno" value="Apellido Paterno"
                    class="uppercase text-[10px] font-black tracking-widest" />
                <x-text-input id="apellido_paterno" name="apellido_paterno" type="text"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 shadow-sm"
                    :value="old('apellido_paterno', $user->apellido_paterno)" required autocomplete="family-name" />
                <x-input-error class="mt-2" :messages="$errors->get('apellido_paterno')" />
            </div>

            <div>
                <x-input-label for="apellido_materno" value="Apellido Materno"
                    class="uppercase text-[10px] font-black tracking-widest" />
                <x-text-input id="apellido_materno" name="apellido_materno" type="text"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 shadow-sm"
                    :value="old('apellido_materno', $user->apellido_materno)" autocomplete="family-name" />
                <x-input-error class="mt-2" :messages="$errors->get('apellido_materno')" />
            </div>
        </div>

        <div>
            <x-input-label for="email" value="Correo Electrónico"
                class="uppercase text-[10px] font-black tracking-widest" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 shadow-sm"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button
                class="bg-red-600 hover:bg-red-700 text-white font-black py-2 px-6 rounded-xl transition-all uppercase text-[10px] tracking-widest border-none shadow-lg shadow-red-900/20 transform hover:-translate-y-0.5">
                Guardar Cambios
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs text-green-500 font-black uppercase tracking-widest italic">
                    ¡Perfil actualizado con éxito!
                </p>
            @endif
        </div>
    </form>
</section>