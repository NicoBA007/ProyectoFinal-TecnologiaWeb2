<x-app-layout>
    {{-- Contenedor principal con Alpine.js y Padding Bottom 20 (pb-20) --}}
    <div x-data="{ openModal: false }" class="min-h-screen bg-[#0f0f0f] text-white pb-20">

        {{-- Hero Section con Backdrop Aleatorio --}}
        <div class="relative h-[400px] w-full overflow-hidden flex items-center">
            <div class="absolute inset-0 z-0">
                @if ($backdrop)
                    <img src="{{ $backdrop }}"
                        class="w-full h-full object-cover opacity-40 transition-opacity duration-1000">
                @else
                    <div class="w-full h-full bg-zinc-900"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f0f0f] via-[#0f0f0f]/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#0f0f0f] via-transparent to-transparent"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-8 w-full">
                <div class="flex items-center gap-4 mb-3">
                    <span class="text-red-600 font-black tracking-[0.4em] uppercase text-[10px] block">Género</span>
                    {{-- Botón Disparador del Selector --}}
                    <button @click="openModal = true"
                        class="bg-white/10 hover:bg-red-600 backdrop-blur-md text-[9px] font-black px-3 py-1 rounded-full border border-white/10 transition-all uppercase tracking-widest flex items-center gap-2">
                        Cambiar Género
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>

                <h1
                    class="text-5xl md:text-6xl font-black uppercase tracking-tighter italic leading-none drop-shadow-2xl">
                    {{ $genero['nombre'] }}<span class="text-red-600">.</span>
                </h1>
                <p class="text-gray-400 mt-4 max-w-xl text-sm font-medium leading-relaxed italic">
                    Explora nuestra selección de {{ $total }} títulos de {{ strtolower($genero['nombre']) }}.
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-8 -mt-10 relative z-20">
            {{-- Toolbar --}}
            <div
                class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12 border-b border-white/10 pb-6">
                <a href="{{ route('cartelera.index') }}"
                    class="group flex items-center gap-2 text-zinc-500 hover:text-white transition-colors">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="font-black text-[10px] uppercase tracking-[0.2em]">Volver</span>
                </a>

                <div class="relative">
                    <input type="text" id="movieSearch" placeholder="FILTRAR..."
                        class="bg-[#1a1a1a] border-none text-white text-[10px] font-black rounded-full pl-6 pr-12 py-2.5 w-64 focus:ring-1 focus:ring-red-600 transition-all uppercase placeholder:text-gray-600 outline-none">
                </div>
            </div>

            {{-- Grid de Películas --}}
            <div id="grid-peliculas"
                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-6 gap-y-12 mb-20">
                @foreach ($peliculas as $p)
                    <div
                        class="movie-card group relative bg-[#151515] rounded-2xl overflow-hidden transition-all duration-500 hover:-translate-y-2">
                        <div class="relative aspect-[2/3] overflow-hidden">
                            <img src="{{ $p['poster_url'] }}"
                                class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition-all duration-700">

                            {{-- Etiquetas: Clasificación y Año --}}
                            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                <span
                                    class="bg-black/90 text-[9px] font-black px-2 py-1 rounded-md text-red-600 border border-red-600/20 uppercase tracking-tighter">
                                    {{ $p['clasificacion_codigo'] ?? 'S/E' }}
                                </span>
                                <span
                                    class="bg-zinc-900/90 backdrop-blur-md text-[9px] font-bold px-2 py-1 rounded-md text-zinc-300 border border-white/5 w-fit">
                                    {{ $p['anio'] }}
                                </span>
                            </div>

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black via-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-4">
                                <a href="{{ route('cartelera.show', $p['id_pelicula']) }}"
                                    class="w-full py-3 bg-white text-black text-[10px] font-black rounded-xl uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all text-center">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>

                        <div class="p-5">
                            <h3 class="text-[12px] font-black uppercase tracking-tight truncate mb-3"
                                title="{{ $p['titulo'] }}">
                                {{ $p['titulo'] }}
                            </h3>

                            <div class="flex justify-between items-center">
                                <div
                                    class="flex items-center gap-1.5 bg-black/40 px-2 py-1 rounded-md border border-white/5">
                                    @php
                                        $rating = $p['rating'] ?? 0;
                                        $esProximamente =
                                            str_contains(strtolower($p['estado']), 'proximamente') ||
                                            str_contains(strtolower($p['estado']), 'próximamente');
                                        $starColor =
                                            $esProximamente || $rating == 0 ? 'text-zinc-600' : 'text-yellow-500';
                                    @endphp
                                    <svg class="w-3.5 h-3.5 {{ $starColor }}" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-[10px] font-black {{ $starColor }}">
                                        {{ $esProximamente ? '??' : ($rating > 0 ? number_format($rating, 1) : 'S/C') }}
                                    </span>
                                </div>
                                <span class="text-[9px] text-red-600 font-black tracking-widest italic uppercase">
                                    {{ $p['estado'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginación 100% Tailwind --}}
            <div class="mt-20 flex flex-col items-center gap-8">
                @if ($peliculas->total() > 0)
                    <div class="flex items-center gap-3">

                        {{-- Botón Anterior --}}
                        @if (!$peliculas->onFirstPage())
                            <a href="{{ $peliculas->previousPageUrl() }}"
                                class="group flex items-center justify-center w-12 h-12 bg-zinc-900 border border-white/10 rounded-xl transition-all hover:bg-red-600 hover:border-red-600 hover:shadow-[0_0_20px_rgba(220,38,38,0.3)]">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-zinc-400 group-hover:text-white transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        @else
                            <div
                                class="flex items-center justify-center w-12 h-12 bg-zinc-900/30 border border-white/5 rounded-xl opacity-50 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-zinc-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </div>
                        @endif

                        {{-- Panel de Información Central --}}
                        <div class="relative group">
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-red-600 to-zinc-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000">
                            </div>
                            <div
                                class="relative px-8 py-3 bg-zinc-950 border border-white/10 rounded-2xl flex flex-col items-center min-w-[180px]">
                                <span
                                    class="text-[10px] font-black tracking-[0.2em] text-zinc-500 uppercase leading-none">
                                    Página <span class="text-white">{{ $peliculas->currentPage() }}</span> de <span
                                        class="text-zinc-500">{{ $peliculas->lastPage() }}</span>
                                </span>
                                {{-- Barra de progreso con Tailwind --}}
                                <div class="w-full h-1 bg-zinc-800 rounded-full mt-3 overflow-hidden">
                                    <div class="h-full bg-red-600 transition-all duration-700"
                                        style="width: {{ ($peliculas->currentPage() / $peliculas->lastPage()) * 100 }}%">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botón Siguiente --}}
                        @if ($peliculas->hasMorePages())
                            <a href="{{ $peliculas->nextPageUrl() }}"
                                class="group flex items-center justify-center w-12 h-12 bg-zinc-900 border border-white/10 rounded-xl transition-all hover:bg-red-600 hover:border-red-600 hover:shadow-[0_0_20px_rgba(220,38,38,0.3)]">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-zinc-400 group-hover:text-white transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @else
                            <div
                                class="flex items-center justify-center w-12 h-12 bg-zinc-900/30 border border-white/5 rounded-xl opacity-50 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-zinc-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <p class="text-zinc-600 text-[9px] font-black uppercase tracking-[0.3em] italic">
                        {{ number_format($peliculas->total()) }} Títulos en total
                    </p>
                @endif
            </div>
        </div>

        {{-- MODAL SELECTOR DE GÉNEROS --}}
        <div x-show="openModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-8" style="display: none;">

            {{-- Fondo oscuro con blur --}}
            <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" @click="openModal = false"></div>

            {{-- Contenedor del Modal con Clases Arbitrarias para ocultar scrollbar --}}
            <div
                class="relative bg-[#141414] w-full max-w-5xl max-h-[85vh] overflow-y-auto rounded-3xl border border-white/10 shadow-2xl p-6 md:p-10 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-black uppercase italic tracking-tighter">Explorar <span
                            class="text-red-600">Géneros</span></h2>
                    <button @click="openModal = false" class="text-zinc-500 hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Grid de Géneros --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($todosLosGeneros as $g)
                        <a href="{{ route('genero.show', $g->id_genero) }}"
                            class="group relative h-28 flex items-center justify-center overflow-hidden rounded-xl transition-all duration-500
                               {{ (isset($genero['id']) ? $genero['id'] : $genero['id_genero']) == $g->id_genero ? 'bg-red-600 ring-4 ring-red-600/20' : 'bg-[#222] hover:bg-zinc-800' }}">

                            <div
                                class="absolute inset-0 opacity-0 group-hover:opacity-100 bg-gradient-to-br from-white/5 to-transparent transition-opacity">
                            </div>

                            <div class="relative z-10 text-center">
                                <span
                                    class="block text-lg font-black uppercase italic tracking-tighter group-hover:scale-110 transition-transform duration-500">
                                    {{ $g->nombre }}
                                </span>
                                <span
                                    class="text-[9px] font-black opacity-40 uppercase tracking-[0.2em] group-hover:opacity-80 transition-opacity">
                                    {{ $g->peliculas_count }} Películas
                                </span>
                            </div>

                            <div
                                class="absolute right-0 bottom-0 translate-y-4 translate-x-2 text-white/5 text-6xl font-black italic uppercase select-none">
                                {{ substr($g->nombre, 0, 2) }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('movieSearch').addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                document.querySelectorAll('.movie-card').forEach(card => {
                    const title = card.querySelector('h3').innerText.toLowerCase();
                    card.style.display = title.includes(term) ? 'block' : 'none';
                });
            });
        </script>
    @endpush
</x-app-layout>
