<section>
    <header class="mb-8">
        <h2 class="text-xl font-black uppercase tracking-tighter text-white">
            Información del <span class="text-red-600">Perfil</span>
        </h2>
        <p class="mt-2 text-gray-500 uppercase tracking-[0.2em] text-[10px] font-bold leading-relaxed">
            Actualiza tus datos personales y dirección de correo electrónico.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div class="space-y-2">
            <x-input-label for="nombres" value="Nombres"
                class="uppercase text-[10px] font-black tracking-widest text-gray-400" />
            <x-text-input id="nombres" name="nombres" type="text"
                class="block w-full bg-gray-900/50 border-gray-800 text-white focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all py-3 px-4 rounded-xl placeholder-gray-700"
                :value="old('nombres', $user->nombres)" required autofocus />
            <x-input-error class="mt-1" :messages="$errors->get('nombres')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <x-input-label for="apellido_paterno" value="Apellido Paterno"
                    class="uppercase text-[10px] font-black tracking-widest text-gray-400" />
                <x-text-input id="apellido_paterno" name="apellido_paterno" type="text"
                    class="block w-full bg-gray-900/50 border-gray-800 text-white focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all py-3 px-4 rounded-xl"
                    :value="old('apellido_paterno', $user->apellido_paterno)" required />
                <x-input-error class="mt-1" :messages="$errors->get('apellido_paterno')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="apellido_materno" value="Apellido Materno"
                    class="uppercase text-[10px] font-black tracking-widest text-gray-400" />
                <x-text-input id="apellido_materno" name="apellido_materno" type="text"
                    class="block w-full bg-gray-900/50 border-gray-800 text-white focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all py-3 px-4 rounded-xl"
                    :value="old('apellido_materno', $user->apellido_materno)" />
                <x-input-error class="mt-1" :messages="$errors->get('apellido_materno')" />
            </div>
        </div>

        <div class="space-y-2">
            <x-input-label for="email" value="Correo Electrónico"
                class="uppercase text-[10px] font-black tracking-widest text-gray-400" />
            <x-text-input id="email" name="email" type="email"
                class="block w-full bg-gray-900/50 border-gray-800 text-white focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all py-3 px-4 rounded-xl"
                :value="old('email', $user->email)" required />
            <x-input-error class="mt-1" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white font-black py-3 px-8 rounded-xl transition-all uppercase text-[10px] tracking-[0.2em] shadow-lg shadow-red-900/20 transform hover:-translate-y-1">
                Guardar Cambios
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-[10px] text-green-500 font-black uppercase tracking-widest italic animate-pulse">
                    ¡Datos Actualizados!
                </p>
            @endif
        </div>
    </form>
</section>
