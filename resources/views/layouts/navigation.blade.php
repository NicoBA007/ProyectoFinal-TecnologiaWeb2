<nav x-data="{
    open: false,
    scrolled: {{ isset($forceSolid) && $forceSolid ? 'true' : 'false' }}
}" x-init="if (!{{ isset($forceSolid) && $forceSolid ? 'true' : 'false' }}) { scrolled = window.pageYOffset > 10 }"
    @scroll.window="if (!{{ isset($forceSolid) && $forceSolid ? 'true' : 'false' }}) { scrolled = window.pageYOffset > 10 }"
    x-cloak
    :class="{
        'bg-transparent border-transparent shadow-none': !scrolled && !open,
        'bg-gray-950/95 backdrop-blur-xl border-gray-800 shadow-[0_10px_30px_rgba(0,0,0,0.5)]': scrolled || open
    }"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-500 border-b">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Altura dinámica del Nav --}}
        <div class="flex justify-between items-center transition-all duration-500"
            :class="(scrolled || open) ? 'h-16' : 'h-24'">

            {{-- Logo y Links Escritorio --}}
            <div class="flex items-center gap-12">
                <div class="shrink-0 flex items-center">
                    <a href="/" class="group flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Prime Cinemas"
                            class="w-auto object-contain transition-all duration-500 group-hover:scale-110 filter drop-shadow-md"
                            :class="(scrolled || open) ? 'h-10' : 'h-14'">
                    </a>
                </div>

                <div class="hidden lg:flex items-center space-x-10">
                    <a href="/"
                        class="text-[12px] font-black uppercase tracking-[0.25em] italic transition-all duration-300 drop-shadow-md {{ request()->is('/') ? 'text-red-600' : 'text-white hover:text-red-500' }}">
                        Inicio
                    </a>
                    <a href="#"
                        class="text-white hover:text-red-500 transition-all duration-300 font-black uppercase text-[12px] tracking-[0.25em] italic drop-shadow-md">
                        Películas
                    </a>
                    <a href="#"
                        class="text-white hover:text-red-500 transition-all duration-300 font-black uppercase text-[12px] tracking-[0.25em] italic drop-shadow-md">
                        Celebridades
                    </a>
                </div>
            </div>

            {{-- Buscador y Auth Escritorio --}}
            <div class="hidden lg:flex lg:items-center gap-8">
                {{-- BUSCADOR ESCRITORIO CON CLASES DINÁMICAS --}}
                <div class="relative group">
                    <input type="text"
                        :class="(scrolled || open) ? 'bg-gray-800 border-gray-600' : 'bg-black/40 border-white/40'"
                        class="border-2 rounded-full py-2 px-5 text-xs w-48 focus:w-64 transition-all duration-500 focus:ring-2 focus:ring-red-600 outline-none text-white placeholder-gray-300 font-bold"
                        placeholder="Buscar película...">
                    <svg class="w-4 h-4 absolute right-4 top-2.5 text-white stroke-[3px]" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                :class="(scrolled || open) ? 'bg-gray-900 border-gray-600' : 'bg-black/40 border-white/30'"
                                class="inline-flex items-center px-5 py-2.5 border-2 text-[11px] font-black uppercase tracking-widest rounded-full text-white hover:bg-red-600 hover:border-red-600 transition-all duration-300 shadow-lg group">
                                <div
                                    class="w-2.5 h-2.5 rounded-full {{ Auth::user()->rol === 'admin' ? 'bg-red-500' : 'bg-green-400' }} animate-pulse mr-2 shadow-[0_0_10px_currentColor]">
                                </div>
                                {{ Auth::user()->nombres }}
                                <svg class="ms-2 h-5 w-5 transition-transform group-hover:rotate-180" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="bg-gray-950 border-2 border-gray-800 rounded-lg overflow-hidden shadow-2xl">
                                <x-dropdown-link :href="route('profile.edit')"
                                    class="text-white hover:bg-red-600 font-bold text-xs uppercase tracking-widest">Mi
                                    Perfil</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        class="text-red-500 hover:bg-red-950 font-black text-xs uppercase tracking-widest border-t border-gray-800"
                                        onclick="event.preventDefault(); this.closest('form').submit();">Cerrar
                                        Sesión</x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-6 text-[12px] font-black uppercase tracking-widest italic">
                        <a href="{{ route('login') }}"
                            class="text-white hover:text-red-500 transition-colors drop-shadow-md">Ingresar</a>
                        <a href="{{ route('register') }}"
                            class="bg-red-600 hover:bg-red-700 text-white px-7 py-3 rounded-full not-italic shadow-[0_5px_20px_rgba(220,38,38,0.5)] transition-all">Registrarse</a>
                    </div>
                @endauth
            </div>

            {{-- Botón Hamburguesa --}}
            <div class="-me-2 flex items-center lg:hidden">
                <button @click="open = ! open"
                    class="p-3 rounded-md text-white hover:bg-red-600 transition-all duration-300 focus:outline-none">
                    <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" stroke-width="3" stroke-linecap="round"
                            stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENÚ MÓVIL --}}
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="lg:hidden bg-gray-950 border-t border-gray-800 shadow-2xl overflow-hidden">

        <div class="pt-4 pb-6 space-y-4 px-4">
            {{-- BUSCADOR MÓVIL --}}
            <div class="relative px-2">
                <input type="text"
                    class="w-full bg-gray-900 border-2 border-gray-700 rounded-full py-3 px-6 text-sm text-white placeholder-gray-400 focus:border-red-600 outline-none font-bold transition-all"
                    placeholder="Buscar una película...">
                <svg class="w-5 h-5 absolute right-6 top-3.5 text-gray-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <div class="space-y-2">
                <a href="/"
                    class="block px-4 py-3 rounded-xl text-sm font-black uppercase tracking-widest transition-all {{ request()->is('/') ? 'bg-red-600 text-white shadow-[0_0_15px_rgba(220,38,38,0.4)]' : 'text-gray-300 hover:bg-gray-900 hover:text-white' }}">
                    🎞️ Cartelera
                </a>
                <a href="#"
                    class="block px-4 py-3 rounded-xl text-sm font-black uppercase tracking-widest text-gray-300 hover:bg-gray-900 hover:text-white transition-all">
                    🎬 Películas
                </a>
                <a href="#"
                    class="block px-4 py-3 rounded-xl text-sm font-black uppercase tracking-widest text-gray-300 hover:bg-gray-900 hover:text-white transition-all">
                    ⭐ Celebridades
                </a>
            </div>

            <div class="pt-4 border-t border-gray-800">
                @auth
                    <div class="px-4 py-2 mb-2 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Cuenta de
                        Usuario</div>
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-3 text-white font-bold text-sm uppercase tracking-widest hover:bg-gray-900 rounded-xl">Mi
                        Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-3 text-red-500 font-black text-sm uppercase tracking-widest hover:bg-red-950/30 rounded-xl">Cerrar
                            Sesión</button>
                    </form>
                @else
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('login') }}"
                            class="text-center py-3 text-white font-black text-[11px] uppercase tracking-widest border-2 border-gray-700 rounded-full">Ingresar</a>
                        <a href="{{ route('register') }}"
                            class="text-center py-3 bg-red-600 text-white font-black text-[11px] uppercase tracking-widest rounded-full">Registro</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
