<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Contraseña Actual --}}
            <div class="space-y-1 group/input">
                <x-input-label for="update_password_current_password" value="Contraseña Actual"
                    class="text-[9px] uppercase tracking-[0.2em] text-gray-600 font-black ml-1 group-focus-within/input:text-red-600 transition-colors" />
                <x-text-input id="update_password_current_password" name="current_password" type="password"
                    class="w-full bg-black border-gray-800 rounded-xl py-3 px-5 text-sm text-white focus:border-red-600 focus:ring-0 transition-all shadow-inner"
                    autocomplete="current-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')"
                    class="mt-2 text-[10px] font-bold uppercase tracking-widest text-red-500 italic" />
            </div>

            {{-- Espacio vacío o podrías poner un aviso de seguridad --}}
            <div class="hidden md:flex items-center">
                <p class="text-[9px] text-gray-600 uppercase tracking-widest leading-tight italic border-l border-white/5 pl-4">
                    Se recomienda cambiar la clave cada 90 días para mantener la integridad del sistema.
                </p>
            </div>

            {{-- Nueva Contraseña --}}
            <div class="space-y-1 group/input">
                <x-input-label for="update_password_password" value="Nueva Contraseña"
                    class="text-[9px] uppercase tracking-[0.2em] text-gray-600 font-black ml-1 group-focus-within/input:text-red-600 transition-colors" />
                <x-text-input id="update_password_password" name="password" type="password"
                    class="w-full bg-black border-gray-800 rounded-xl py-3 px-5 text-sm text-white focus:border-red-600 focus:ring-0 transition-all shadow-inner"
                    autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->updatePassword->get('password')"
                    class="mt-2 text-[10px] font-bold uppercase tracking-widest text-red-500 italic" />
            </div>

            {{-- Confirmar Nueva Contraseña --}}
            <div class="space-y-1 group/input">
                <x-input-label for="update_password_password_confirmation" value="Confirmar Nueva Contraseña"
                    class="text-[9px] uppercase tracking-[0.2em] text-gray-600 font-black ml-1 group-focus-within/input:text-red-600 transition-colors" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="w-full bg-black border-gray-800 rounded-xl py-3 px-5 text-sm text-white focus:border-red-600 focus:ring-0 transition-all shadow-inner"
                    autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                    class="mt-2 text-[10px] font-bold uppercase tracking-widest text-red-500 italic" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="px-8 py-3 bg-white/5 hover:bg-white/10 text-white border border-white/10 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all active:scale-95">
                Actualizar Credenciales
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-green-500 italic">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                    ¡Cambio exitoso!
                </div>
            @endif
        </div>
    </form>
</section>