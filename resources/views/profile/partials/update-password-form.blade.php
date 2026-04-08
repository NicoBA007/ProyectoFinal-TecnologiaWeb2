<section x-data="{
    showCurrent: false,
    showNew: false,
    showConfirm: false
}">
    <header class="mb-8">
        <h2 class="text-xl font-black uppercase tracking-tighter text-white">
            Seguridad de la <span class="text-red-600">Cuenta</span>
        </h2>
        <p class="mt-2 text-gray-500 uppercase tracking-[0.2em] text-[10px] font-bold leading-relaxed">
            Cambia tu contraseña periódicamente para mantener tu cuenta protegida.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        {{-- Contraseña Actual --}}
        <div class="space-y-2">
            <x-input-label for="update_password_current_password" value="Contraseña Actual"
                class="uppercase text-[10px] font-black tracking-widest text-gray-400" />
            <div class="relative group">
                <x-text-input id="update_password_current_password" name="current_password" ::type="showCurrent ? 'text' : 'password'"
                    class="block w-full bg-gray-900/50 border-gray-800 text-white focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all py-3 px-4 pr-12 rounded-xl placeholder-gray-800"
                    placeholder="••••••••" />

                <button type="button" @click="showCurrent = !showCurrent"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-600 hover:text-red-500 transition-colors">
                    <template x-if="!showCurrent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </template>
                    <template x-if="showCurrent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.882 9.882L5.146 5.147m13.71 13.71l-4.738-4.736m-4.567-4.567L19.506 3.994z" />
                        </svg>
                    </template>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
        </div>

        {{-- Nueva Contraseña --}}
        <div class="space-y-2">
            <x-input-label for="update_password_password" value="Nueva Contraseña"
                class="uppercase text-[10px] font-black tracking-widest text-gray-400" />
            <div class="relative group">
                <x-text-input id="update_password_password" name="password" ::type="showNew ? 'text' : 'password'"
                    class="block w-full bg-gray-900/50 border-gray-800 text-white focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all py-3 px-4 pr-12 rounded-xl placeholder-gray-800"
                    placeholder="Mínimo 8 caracteres" />

                <button type="button" @click="showNew = !showNew"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-600 hover:text-red-500 transition-colors">
                    <template x-if="!showNew">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </template>
                    <template x-if="showNew">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.882 9.882L5.146 5.147m13.71 13.71l-4.738-4.736m-4.567-4.567L19.506 3.994z" />
                        </svg>
                    </template>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
        </div>

        {{-- Confirmar Contraseña --}}
        <div class="space-y-2">
            <x-input-label for="update_password_password_confirmation" value="Confirmar Nueva"
                class="uppercase text-[10px] font-black tracking-widest text-gray-400" />
            <div class="relative group">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" ::type="showConfirm ? 'text' : 'password'"
                    class="block w-full bg-gray-900/50 border-gray-800 text-white focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all py-3 px-4 pr-12 rounded-xl placeholder-gray-800"
                    placeholder="••••••••" />

                <button type="button" @click="showConfirm = !showConfirm"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-600 hover:text-red-500 transition-colors">
                    <template x-if="!showConfirm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </template>
                    <template x-if="showConfirm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.882 9.882L5.146 5.147m13.71 13.71l-4.738-4.736m-4.567-4.567L19.506 3.994z" />
                        </svg>
                    </template>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="bg-white hover:bg-red-600 hover:text-white text-black font-black py-3 px-8 rounded-xl transition-all uppercase text-[10px] tracking-[0.2em] transform hover:-translate-y-1">
                Actualizar Seguridad
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="text-[10px] text-green-500 font-black uppercase tracking-widest italic animate-pulse">
                    ¡Contraseña Guardada!
                </p>
            @endif
        </div>
    </form>
</section>
