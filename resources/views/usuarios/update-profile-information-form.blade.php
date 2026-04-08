<section>
    {{-- Eliminamos el header para mantener la estética minimalista del panel --}}

    <form method="post" action="{{ route('profileAdmin.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-6">
            {{-- Nombres --}}
            <div class="space-y-1 group/input">
                <x-input-label for="nombres" value="Nombres del Operador" 
                    class="text-[9px] uppercase tracking-[0.2em] text-gray-600 font-black ml-1 group-focus-within/input:text-red-600 transition-colors" />
                <x-text-input id="nombres" name="nombres" type="text"
                    class="block w-full bg-black border-gray-800 text-white focus:border-red-600 focus:ring-0 rounded-xl py-3 px-5 text-sm transition-all shadow-inner"
                    :value="old('nombres', $user->nombres)" required autofocus autocomplete="given-name" />
                <x-input-error class="mt-2 text-[10px] font-bold uppercase tracking-widest text-red-500 italic" :messages="$errors->get('nombres')" />
            </div>

            {{-- Apellidos (Grid interno) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1 group/input">
                    <x-input-label for="apellido_paterno" value="Apellido Paterno" 
                        class="text-[9px] uppercase tracking-[0.2em] text-gray-600 font-black ml-1 group-focus-within/input:text-red-600 transition-colors" />
                    <x-text-input id="apellido_paterno" name="apellido_paterno" type="text"
                        class="block w-full bg-black border-gray-800 text-white focus:border-red-600 focus:ring-0 rounded-xl py-3 px-5 text-sm transition-all"
                        :value="old('apellido_paterno', $user->apellido_paterno)" required autocomplete="family-name" />
                    <x-input-error class="mt-2 text-[10px] font-bold uppercase tracking-widest text-red-500 italic" :messages="$errors->get('apellido_paterno')" />
                </div>

                <div class="space-y-1 group/input">
                    <x-input-label for="apellido_materno" value="Apellido Materno" 
                        class="text-[9px] uppercase tracking-[0.2em] text-gray-600 font-black ml-1 group-focus-within/input:text-red-600 transition-colors" />
                    <x-text-input id="apellido_materno" name="apellido_materno" type="text"
                        class="block w-full bg-black border-gray-800 text-white focus:border-red-600 focus:ring-0 rounded-xl py-3 px-5 text-sm transition-all"
                        :value="old('apellido_materno', $user->apellido_materno)" autocomplete="family-name" />
                    <x-input-error class="mt-2 text-[10px] font-bold uppercase tracking-widest text-red-500 italic" :messages="$errors->get('apellido_materno')" />
                </div>
            </div>

            {{-- Email --}}
            <div class="space-y-1 group/input">
                <x-input-label for="email" value="Correo Institucional / Usuario" 
                    class="text-[9px] uppercase tracking-[0.2em] text-gray-600 font-black ml-1 group-focus-within/input:text-red-600 transition-colors" />
                <x-text-input id="email" name="email" type="email"
                    class="block w-full bg-black border-gray-800 text-white focus:border-red-600 focus:ring-0 rounded-xl py-3 px-5 text-sm transition-all shadow-inner"
                    :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2 text-[10px] font-bold uppercase tracking-widest text-red-500 italic" :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white font-black py-3 px-8 rounded-xl transition-all uppercase text-[10px] tracking-[0.2em] border-none shadow-lg shadow-red-900/20 active:scale-95">
                Actualizar Registro
            </button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-green-500 italic">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                    Sincronización Exitosa
                </div>
            @endif
        </div>
    </form>
</section>