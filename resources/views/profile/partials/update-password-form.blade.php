<section>
    <header>
        <h2 class="text-lg font-black uppercase tracking-tighter text-white">
            Seguridad de la <span class="text-red-600">Cuenta</span>
        </h2>

        <p class="mt-1 text-sm text-gray-500 uppercase tracking-widest text-[10px] font-bold">
            Asegúrate de usar una contraseña larga y aleatoria para mantenerte seguro.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="Contraseña Actual"
                class="uppercase text-[10px] font-black tracking-widest text-gray-400" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 placeholder-gray-600"
                autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')"
                class="mt-2 text-red-500 font-bold text-xs" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="Nueva Contraseña"
                class="uppercase text-[10px] font-black tracking-widest text-gray-400" />
            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-1 block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 placeholder-gray-600"
                autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password')"
                class="mt-2 text-red-500 font-bold text-xs" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Confirmar Nueva Contraseña"
                class="uppercase text-[10px] font-black tracking-widest text-gray-400" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 placeholder-gray-600"
                autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2 text-red-500 font-bold text-xs" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button
                class="bg-red-600 hover:bg-red-700 text-white font-black py-2 px-6 rounded-xl transition-all uppercase text-[10px] tracking-widest border-none">
                Actualizar Contraseña
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs text-green-500 font-black uppercase tracking-widest italic">
                    ¡Contraseña guardada!
                </p>
            @endif
        </div>
    </form>
</section>