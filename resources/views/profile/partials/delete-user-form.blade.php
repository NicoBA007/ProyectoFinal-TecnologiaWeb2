<section class="space-y-6">
    <header>
        <h2 class="text-lg font-black uppercase tracking-tighter text-white">
            Desactivar <span class="text-red-600">Cuenta</span>
        </h2>

        <p class="mt-1 text-sm text-gray-500 uppercase tracking-widest text-[10px] font-bold leading-relaxed">
            Al desactivar tu cuenta, ya no podrás acceder a tus beneficios de preventa ni calificar películas. Tus datos
            personales se mantendrán protegidos pero la sesión se cerrará inmediatamente.
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 font-black uppercase text-[10px] tracking-widest py-3 px-6 rounded-xl border-none shadow-lg shadow-red-900/20">Desactivar
        mi cuenta</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}"
            class="p-8 bg-gray-900 border border-gray-800 rounded-2xl">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-white uppercase tracking-tighter">
                ¿Estás seguro de que quieres <span class="text-red-500">ir de la función</span>?
            </h2>

            <p class="mt-4 text-sm text-gray-400 font-medium leading-relaxed">
                Para confirmar la desactivación de tu cuenta, por favor ingresa tu contraseña. Podrás solicitar la
                reactivación contactando a soporte técnico de PrimeCinemas.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Contraseña de confirmación" class="sr-only" />

                <x-text-input id="password" name="password" type="password"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 placeholder-gray-600 rounded-xl"
                    placeholder="Escribe tu contraseña aquí..." />

                <x-input-error :messages="$errors->userDeletion->get('password')"
                    class="mt-2 text-red-500 font-bold text-xs" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')"
                    class="bg-transparent border-gray-700 text-gray-400 hover:bg-gray-800 font-bold uppercase text-[10px] tracking-widest rounded-xl">
                    Volver atrás
                </x-secondary-button>

                <x-danger-button
                    class="ms-3 bg-red-600 hover:bg-red-700 font-black uppercase text-[10px] tracking-widest px-6 rounded-xl border-none shadow-lg shadow-red-900/30">
                    Confirmar Desactivación
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>