<section>
    <header class="mb-6">
        <h2 class="text-xl font-black uppercase tracking-tighter text-white">
            Desactivar <span class="text-red-600">Cuenta</span>
        </h2>
        <p class="mt-2 text-gray-500 uppercase tracking-widest text-[10px] font-bold leading-relaxed">
            Al finalizar tu cuenta, perderás el acceso a tus beneficios y preventas exclusivas.
        </p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="group flex items-center gap-3 bg-red-950/20 hover:bg-red-600 border border-red-900/50 text-red-600 hover:text-white font-black uppercase text-[10px] tracking-widest py-3 px-6 rounded-xl transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:animate-bounce" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        Desactivar mi cuenta
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}"
            class="p-10 bg-gray-950 border border-red-900/30 rounded-3xl overflow-hidden relative">

            {{-- Fondo decorativo del modal --}}
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-red-600/10 blur-3xl rounded-full"></div>

            <h2 class="text-2xl font-black text-white uppercase tracking-tighter leading-none mb-4">
                ¿ESTÁS SEGURO DE QUE <br> QUIERES <span class="text-red-600">IRTE</span>?
            </h2>

            <p class="text-sm text-gray-500 font-medium leading-relaxed mb-8">
                Esta acción es definitiva. Para confirmar la desactivación, ingresa tu contraseña. Podrás contactar a
                soporte si deseas volver en el futuro.
            </p>

            <div class="space-y-2">
                <x-input-label for="password" value="Tu Contraseña"
                    class="uppercase text-[10px] font-black tracking-[0.3em] text-gray-500" />
                <x-text-input id="password" name="password" type="password"
                    class="block w-full bg-gray-900 border-gray-800 text-white focus:ring-2 focus:ring-red-600 py-4 px-5 rounded-2xl"
                    placeholder="Confirma tu identidad" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex flex-col md:flex-row justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')"
                    class="order-2 md:order-1 px-8 py-4 text-gray-500 hover:text-white font-black uppercase text-[10px] tracking-widest transition-colors">
                    Cancelar y Volver
                </button>

                <button type="submit"
                    class="order-1 md:order-2 bg-red-600 hover:bg-red-700 text-white font-black uppercase text-[10px] tracking-widest px-10 py-4 rounded-2xl shadow-xl shadow-red-900/40 transform hover:scale-105 transition-all">
                    Confirmar Desactivación
                </button>
            </div>
        </form>
    </x-modal>
</section>
