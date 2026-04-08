<x-app-layout>
    <div class="flex flex-col lg:flex-row h-screen bg-black relative overflow-hidden">

        {{-- COLUMNA IZQUIERDA: ESTATICA --}}
        <div class="hidden lg:flex lg:w-1/2 relative z-0">
            <div class="absolute inset-0">
                <img src="{{ asset('images/login-collage.png') }}" alt="Movie Collage"
                    class="w-full h-full object-cover opacity-40">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-black/20 to-black"></div>
            </div>

            <div class="relative z-10 flex flex-col justify-center px-24">
                <p class="text-red-600 text-xs uppercase tracking-[0.5em] font-black mb-4 italic">Ajustes de cuenta</p>
                <h1 class="text-7xl font-black text-white tracking-tighter uppercase leading-[0.85]">
                    TU ESPACIO <br> <span class="text-gray-600">PRIVADO</span>
                </h1>
            </div>
        </div>

        {{-- COLUMNA DERECHA --}}
        <div class="w-full lg:w-1/2 flex flex-col bg-black lg:bg-transparent relative z-20 h-full overflow-hidden"
            x-data="{ tab: 'profile' }">

            <div class="flex flex-col h-full px-6 md:px-16 lg:px-20 pt-24 pb-8">

                {{-- NAVEGACIÓN DE PESTAÑAS (shrink-0 para que no se mueva) --}}
                <nav
                    class="flex gap-8 border-b border-gray-900 shrink-0 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                    <button @click="tab = 'profile'"
                        :class="tab === 'profile' ? 'text-red-600 border-red-600' : 'text-gray-500 border-transparent'"
                        class="pb-4 border-b-2 font-black uppercase text-[11px] tracking-[0.2em] transition-all whitespace-nowrap">
                        Información
                    </button>
                    <button @click="tab = 'security'"
                        :class="tab === 'security' ? 'text-red-600 border-red-600' : 'text-gray-500 border-transparent'"
                        class="pb-4 border-b-2 font-black uppercase text-[11px] tracking-[0.2em] transition-all whitespace-nowrap">
                        Seguridad
                    </button>
                    <button @click="tab = 'danger'"
                        :class="tab === 'danger' ? 'text-red-900 border-red-900' : 'text-gray-600 border-transparent'"
                        class="pb-4 border-b-2 font-black uppercase text-[11px] tracking-[0.2em] transition-all whitespace-nowrap">
                        Zona Crítica
                    </button>
                </nav>

                {{-- CONTENEDOR DE FORMULARIOS --}}
                <div
                    class="mt-10 flex-1 overflow-y-auto [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden px-2">

                    <div class="max-w-xl w-full">

                        {{-- Tab: Perfil --}}
                        <div x-show="tab === 'profile'" x-transition:enter="transition ease-out duration-300 transform"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0">
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        {{-- Tab: Seguridad --}}
                        <div x-show="tab === 'security'" x-cloak
                            x-transition:enter="transition ease-out duration-300 transform"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0">
                            @include('profile.partials.update-password-form')
                        </div>

                        {{-- Tab: Peligro --}}
                        <div x-show="tab === 'danger'" x-cloak
                            x-transition:enter="transition ease-out duration-300 transform"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0">
                            <div
                                class="p-8 bg-red-950/10 border border-red-900/20 rounded-3xl shadow-2xl shadow-red-900/5">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
