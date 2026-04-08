<nav x-data="{
    open: false,
    scrolled: {{ isset($forceSolid) && $forceSolid ? 'true' : 'false' }},
    showGeneros: false,
    showClasificaciones: false,
    // --- Lógica de Búsqueda ---
    searchQuery: '',
    searchResults: { peliculas: [], celebridades: [] },
    showResults: false,
    isSearching: false,
    async doSearch() {
        if (this.searchQuery.length < 2) {
            this.searchResults = { peliculas: [], celebridades: [] };
            this.showResults = false;
            return;
        }
        this.isSearching = true;
        try {
            const response = await fetch(`{{ route('cartelera.search') }}?query=${encodeURIComponent(this.searchQuery)}`);
            this.searchResults = await response.json();
            this.showResults = true;
        } catch (error) {
            console.error('Error buscando:', error);
        } finally {
            this.isSearching = false;
        }
    }
}" x-init="if (!{{ isset($forceSolid) && $forceSolid ? 'true' : 'false' }}) { scrolled = window.pageYOffset > 10 }"
    @scroll.window="if (!{{ isset($forceSolid) && $forceSolid ? 'true' : 'false' }}) { scrolled = window.pageYOffset > 10 }"
    @click.away="showGeneros = false; showClasificaciones = false; showResults = false" x-cloak
    :class="{
        'bg-transparent border-transparent shadow-none': !scrolled && !open,
        'bg-gray-950/95 backdrop-blur-xl border-gray-800 shadow-[0_10px_30px_rgba(0,0,0,0.5)]': scrolled || open
    }"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-500 border-b">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center transition-all duration-500"
            :class="(scrolled || open) ? 'h-16' : 'h-24'">

            {{-- Logo y Links Escritorio --}}
            <div class="flex items-center gap-8">
                <div class="shrink-0 flex items-center">
                    <a href="/" class="group flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Prime Cinemas"
                            class="w-auto object-contain transition-all duration-500 group-hover:scale-110 filter drop-shadow-md"
                            :class="(scrolled || open) ? 'h-10' : 'h-14'">
                    </a>
                </div>

                {{-- NAVEGACIÓN PC --}}
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="/"
                        class="text-[11px] font-black uppercase tracking-[0.2em] italic transition-all duration-300 {{ request()->is('/') ? 'text-red-600' : 'text-white hover:text-red-500' }}">
                        Inicio
                    </a>

                    <a href="{{ route('peliculas.catalogo.cliente') }}"
                        class="text-[11px] font-black uppercase tracking-[0.2em] italic transition-all duration-300 {{ request()->routeIs('peliculas.catalogo.cliente') ? 'text-red-600' : 'text-white hover:text-red-500' }}">
                        Películas
                    </a>

                    {{-- DROPDOWN GÉNEROS PC --}}
                    <div class="relative">
                        <button @click="showGeneros = !showGeneros; showClasificaciones = false; showResults = false"
                            class="text-[11px] font-black uppercase tracking-[0.2em] italic flex items-center gap-1.5 transition-all duration-300 {{ request()->routeIs('genero.show') ? 'text-red-600' : 'text-white hover:text-red-500' }}">
                            Géneros
                            <svg class="w-3 h-3 transition-transform duration-300"
                                :class="showGeneros ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="showGeneros" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            class="absolute top-full mt-4 w-52 bg-gray-950 border border-gray-800 rounded-xl shadow-2xl z-50 overflow-hidden">
                            <div
                                class="max-h-60 overflow-y-auto py-2 scrollbar-thin scrollbar-thumb-red-600/50 scrollbar-track-transparent hover:scrollbar-thumb-red-600 transition-colors">
                                @foreach (\App\Models\Genero::where('activo', true)->get() as $g)
                                    <a href="{{ route('genero.show', $g->id_genero) }}"
                                        class="block px-5 py-2.5 text-[10px] font-bold uppercase tracking-widest text-gray-300 hover:bg-red-600 hover:text-white transition-colors">
                                        {{ $g->nombre }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- DROPDOWN PÚBLICO PC --}}
                    <div class="relative">
                        <button
                            @click="showClasificaciones = !showClasificaciones; showGeneros = false; showResults = false"
                            class="text-[11px] font-black uppercase tracking-[0.2em] italic flex items-center gap-1.5 transition-all duration-300 {{ request()->routeIs('clasificacion.show') ? 'text-red-600' : 'text-white hover:text-red-500' }}">
                            Público
                            <svg class="w-3 h-3 transition-transform duration-300"
                                :class="showClasificaciones ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="showClasificaciones" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            class="absolute top-full mt-4 w-48 bg-gray-950 border border-gray-800 rounded-xl shadow-2xl py-2 z-50">
                            @foreach (\App\Models\Clasificacion::where('activo', true)->get() as $c)
                                <a href="{{ route('clasificacion.show', $c->id_clasificacion) }}"
                                    class="flex justify-between items-center px-5 py-2.5 text-[10px] font-bold uppercase tracking-widest text-gray-300 hover:bg-red-600 hover:text-white transition-colors group">
                                    {{ $c->nombre }}
                                    <span
                                        class="text-[9px] font-black text-red-500 group-hover:text-white">{{ $c->codigo }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('celebridades.index') }}"
                        class="text-[11px] font-black uppercase tracking-[0.2em] italic transition-all duration-300 {{ request()->routeIs('celebridades.index') ? 'text-red-600' : 'text-white hover:text-red-500' }}">
                        Celebridades
                    </a>
                </div>
            </div>

            {{-- Buscador y Auth Escritorio --}}
            <div class="hidden lg:flex lg:items-center gap-5">
                {{-- BUSCADOR PC --}}
                <div class="relative group">
                    <input type="text" x-model="searchQuery" @input.debounce.300ms="doSearch()"
                        @focus="if(searchQuery.length > 1) showResults = true"
                        :class="(scrolled || open) ? 'bg-gray-800 border-gray-600' : 'bg-black/40 border-white/40'"
                        class="border-2 rounded-full py-2 px-5 text-xs w-36 focus:w-64 transition-all duration-500 outline-none text-white placeholder-gray-400 font-bold"
                        placeholder="Buscar...">

                    <div class="absolute right-4 top-2.5">
                        <svg x-show="!isSearching" class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <svg x-show="isSearching" class="animate-spin h-4 w-4 text-red-600"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>

                    {{-- RESULTADOS BUSQUEDA PC --}}
                    <div x-show="showResults" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        class="absolute right-0 mt-3 w-80 bg-gray-950 border border-gray-800 rounded-2xl shadow-2xl overflow-hidden z-50">

                        <div class="max-h-[400px] overflow-y-auto p-2 scrollbar-thin scrollbar-thumb-gray-800">
                            {{-- Películas --}}
                            <template x-if="searchResults.peliculas.length > 0">
                                <div>
                                    <span
                                        class="block px-3 py-2 text-[9px] font-black text-gray-500 uppercase tracking-widest border-b border-gray-900 mb-1">Películas</span>
                                    <template x-for="peli in searchResults.peliculas" :key="peli.id_pelicula">
                                        <a :href="'/cartelera/' + (peli.id_pelicula || peli.id)"
                                            class="flex items-center gap-3 p-2 hover:bg-white/5 rounded-xl transition-colors group">
                                            <img :src="peli.poster_url"
                                                class="w-10 h-14 object-cover rounded-lg shadow-lg">
                                            <div>
                                                <div class="text-xs font-bold text-white group-hover:text-red-500 transition-colors"
                                                    x-text="peli.titulo"></div>
                                                <div class="text-[10px] text-gray-500"
                                                    x-text="peli.anio + ' • ' + peli.duracion"></div>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </template>

                            {{-- Celebridades --}}
                            <template x-if="searchResults.celebridades.length > 0">
                                <div class="mt-2">
                                    <span
                                        class="block px-3 py-2 text-[9px] font-black text-gray-500 uppercase tracking-widest border-b border-gray-900 mb-1">Celebridades</span>
                                    <template x-for="per in searchResults.celebridades"
                                        :key="per.id_persona || per.id">
                                        {{-- CORRECCIÓN AQUÍ: Soporta tanto 'id' como 'id_persona' --}}
                                        <a :href="'/celebridades/' + (per.id_persona || per.id)"
                                            class="flex items-center gap-3 p-2 hover:bg-white/5 rounded-xl transition-colors group">
                                            <img :src="per.foto_url"
                                                class="w-10 h-10 object-cover rounded-full shadow-md">
                                            <div class="text-xs font-bold text-white group-hover:text-red-500 transition-colors"
                                                x-text="per.nombre_completo"></div>
                                        </a>
                                    </template>
                                </div>
                            </template>

                            <template
                                x-if="searchResults.peliculas.length === 0 && searchResults.celebridades.length === 0">
                                <div class="p-4 text-center text-xs text-gray-500 italic">No se encontraron resultados
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                :class="(scrolled || open) ? 'bg-gray-900 border-gray-600' : 'bg-black/40 border-white/30'"
                                class="inline-flex items-center px-4 py-2 border-2 text-[10px] font-black uppercase tracking-widest rounded-full text-white hover:bg-red-600 hover:border-red-600 transition-all duration-300">
                                {{ Auth::user()->nombres }}
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="bg-gray-950 border border-gray-800 rounded-lg overflow-hidden shadow-2xl">
                                <x-dropdown-link :href="route('profile.edit')"
                                    class="text-white hover:bg-red-600 font-bold text-xs uppercase">Mi
                                    Perfil</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        class="text-red-500 hover:bg-red-950 font-black text-xs uppercase border-t border-gray-800"
                                        onclick="event.preventDefault(); this.closest('form').submit();">Salir</x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}"
                        class="text-[10px] font-black uppercase text-white hover:text-red-500 transition-colors">Entrar</a>
                    <a href="{{ route('register') }}"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-full text-[10px] font-black uppercase transition-all shadow-lg shadow-red-600/20">Registro</a>
                @endauth
            </div>

            {{-- Hamburguesa Móvil --}}
            <div class="lg:hidden flex items-center">
                <button @click="open = ! open" class="p-2 text-white">
                    <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-width="3"
                            stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" stroke-width="3"
                            stroke-linecap="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MENÚ MÓVIL --}}
    <div x-show="open" x-cloak x-transition
        class="lg:hidden bg-gray-950 border-t border-gray-800 max-h-[85vh] overflow-y-auto">

        {{-- BUSCADOR MÓVIL --}}
        <div class="px-4 pt-4 relative">
            <div class="relative">
                <input type="text" x-model="searchQuery" @input.debounce.300ms="doSearch()"
                    class="w-full bg-gray-900 border-2 border-gray-800 rounded-xl py-3 px-5 text-xs text-white placeholder-gray-500 font-bold focus:border-red-600 transition-all outline-none"
                    placeholder="Buscar películas o actores...">

                <div class="absolute right-4 top-3.5">
                    <svg x-show="!isSearching" class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <svg x-show="isSearching" class="animate-spin h-4 w-4 text-red-600"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
            </div>

            {{-- RESULTADOS MÓVIL --}}
            <div x-show="showResults"
                class="mt-2 bg-gray-900 rounded-xl border border-gray-800 divide-y divide-gray-800 overflow-hidden shadow-2xl z-50">
                <template x-for="peli in searchResults.peliculas" :key="peli.id_pelicula || peli.id">
                    <a :href="'/cartelera/' + (peli.id_pelicula || peli.id)"
                        class="flex items-center gap-3 p-3 active:bg-gray-800 transition-colors">
                        <img :src="peli.poster_url" class="w-8 h-10 object-cover rounded shadow">
                        <span class="text-[11px] font-bold text-white" x-text="peli.titulo"></span>
                    </a>
                </template>
                <template x-for="per in searchResults.celebridades" :key="per.id_persona || per.id">
                    <a :href="'/celebridades/' + (per.id_persona || per.id)"
                        class="flex items-center gap-3 p-3 active:bg-gray-800 transition-colors">
                        <img :src="per.foto_url"
                            class="w-8 h-8 rounded-full object-cover shadow border border-gray-700">
                        <span class="text-[11px] font-bold text-gray-300 italic" x-text="per.nombre_completo"></span>
                    </a>
                </template>
            </div>
        </div>

        <div class="pt-4 pb-6 space-y-2 px-4">
            <a href="/"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest {{ request()->is('/') ? 'bg-red-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-900' }}">
                <svg class="w-5 h-5 text-red-600 {{ request()->is('/') ? 'text-white' : '' }}" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Inicio
            </a>

            <a href="{{ route('peliculas.catalogo.cliente') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest {{ request()->routeIs('peliculas.catalogo.cliente') ? 'bg-red-600 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-900' }}">
                <svg class="w-5 h-5 text-red-600 {{ request()->routeIs('peliculas.catalogo.cliente') ? 'text-white' : '' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                </svg>
                Películas
            </a>

            {{-- GÉNEROS MÓVIL --}}
            <div x-data="{ openG: false }">
                <button @click="openG = !openG"
                    class="w-full flex justify-between items-center px-4 py-3 text-gray-300 text-xs font-black uppercase tracking-widest hover:bg-gray-900 rounded-xl transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                        Géneros
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-300" :class="openG ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openG"
                    class="bg-gray-900/40 border border-gray-800/50 rounded-xl mt-1 grid grid-cols-2 gap-1 p-2">
                    @foreach (\App\Models\Genero::where('activo', true)->get() as $g)
                        <a href="{{ route('genero.show', $g->id_genero) }}"
                            class="px-4 py-2.5 text-[10px] text-gray-400 font-bold uppercase hover:text-red-500">
                            {{ $g->nombre }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- PÚBLICO MÓVIL --}}
            <div x-data="{ openC: false }">
                <button @click="openC = !openC"
                    class="w-full flex justify-between items-center px-4 py-3 text-gray-300 text-xs font-black uppercase tracking-widest hover:bg-gray-900 rounded-xl transition-all">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Público
                    </div>
                    <svg class="w-4 h-4 transition-transform duration-300" :class="openC ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openC" class="bg-gray-900/40 border border-gray-800/50 rounded-xl mt-1 space-y-1 p-2">
                    @foreach (\App\Models\Clasificacion::where('activo', true)->get() as $c)
                        <a href="{{ route('clasificacion.show', $c->id_clasificacion) }}"
                            class="flex justify-between px-4 py-2.5 text-[10px] text-gray-400 font-bold uppercase hover:text-white">
                            <span>{{ $c->nombre }}</span>
                            <span class="text-red-600">{{ $c->codigo }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('celebridades.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-black uppercase tracking-widest text-gray-300 hover:bg-gray-900 {{ request()->routeIs('celebridades.index') ? 'text-red-600' : '' }}">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                Celebridades
            </a>

            <div class="pt-4 border-t border-gray-800">
                @auth
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-400 font-bold text-[10px] uppercase tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Perfil ({{ Auth::user()->nombres }})
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 text-red-500 font-black text-[10px] uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Cerrar Sesión
                        </button>
                    </form>
                @else
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <a href="{{ route('login') }}"
                            class="flex justify-center py-3 text-white font-black text-[10px] uppercase border-2 border-gray-800 rounded-xl">Entrar</a>
                        <a href="{{ route('register') }}"
                            class="flex justify-center py-3 bg-red-600 text-white font-black text-[10px] uppercase rounded-xl">Registro</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
