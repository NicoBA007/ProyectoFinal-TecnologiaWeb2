<section class="space-y-6">
    {{-- Botón Principal que activa el Modal --}}
    <div class="flex items-center justify-between p-6 bg-red-600/5 border border-red-600/10 rounded-2xl">
        <div class="space-y-1">
            <h4 class="text-[11px] font-black uppercase tracking-widest text-white">Eliminación del Operador</h4>
            <p class="text-[9px] text-gray-500 uppercase tracking-tighter">Desactivación de credenciales de acceso</p>
        </div>
        
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-admin-deletion')"
            class="bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white transition-all duration-300 font-black uppercase text-[9px] tracking-widest py-3 px-6 rounded-xl border border-red-600/20">
            Ejecutar
        </button>
    </div>

    {{-- Modal de Confirmación --}}
    <x-modal name="confirm-admin-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profileAdmin.destroy') }}"
            class="p-10 bg-gray-950 border border-white/5 rounded-3xl shadow-2xl">
            @csrf
            @method('delete')

            {{-- El contenido del modal se mantiene igual para seguridad --}}
            <div class="flex items-center gap-4 mb-6">
                <div class="w-10 h-10 rounded-full bg-red-600/20 flex items-center justify-center text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-lg font-black text-white uppercase tracking-tighter">¿Confirmar <span class="text-red-600">Eliminación</span>?</h2>
            </div>

            <div class="group/input">
                <x-text-input id="password" name="password" type="password"
                    class="block w-full bg-black border-gray-800 text-white focus:border-red-600 focus:ring-0 rounded-xl py-4"
                    placeholder="CONTRASEÑA DE SEGURIDAD" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[10px] uppercase font-bold italic" />
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="text-gray-600 hover:text-white font-black uppercase text-[10px] tracking-widest transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-black uppercase text-[10px] tracking-widest py-3 px-8 rounded-xl shadow-lg shadow-red-900/40">
                    Confirmar
                </button>
            </div>
        </form>
    </x-modal>
</section>