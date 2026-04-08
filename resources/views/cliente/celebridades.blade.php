<x-app-layout>
    <div class="min-h-screen bg-[#0f0f0f] text-white">

        {{-- Hero Section --}}
        <div class="relative h-[450px] w-full overflow-hidden flex items-center">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=2000"
                    class="w-full h-full object-cover opacity-40 transition-transform duration-[20000ms] ease-linear scale-100 hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f0f0f] via-[#0f0f0f]/60 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#0f0f0f] via-transparent to-transparent"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-8 w-full">
                <span class="text-red-600 font-bold tracking-[0.3em] text-xs mb-4 block uppercase animate-pulse">
                    Backstage Access
                </span>
                <h1
                    class="text-6xl md:text-8xl font-black uppercase tracking-tighter italic leading-none drop-shadow-2xl">
                    PRIME <span class="text-red-600">TALENT</span>
                </h1>
                <p class="text-gray-300 mt-4 max-w-2xl text-lg font-medium leading-relaxed drop-shadow-lg text-balance">
                    Explora los perfiles de los artistas y directores que definen la narrativa visual de nuestra era.
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-8 -mt-10 relative z-20">

            {{-- Navegación de Filtros --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12 border-b border-white/10">
                <div class="relative overflow-hidden group w-full md:w-auto">
                    {{-- Scroll horizontal con scrollbar oculto mediante clases arbitrarias de Tailwind --}}
                    <div class="flex space-x-8 overflow-x-auto pb-4 scroll-smooth [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden"
                        id="roleFilters">
                        @php $currentRole = request('rol', 'todos'); @endphp

                        {{-- AQUÍ ESTÁ LA CORRECCIÓN: usamos celebridades.index --}}
                        <a href="{{ route('celebridades.index', ['rol' => 'todos']) }}"
                            class="shrink-0 transition-all font-black text-sm tracking-widest uppercase pb-4 {{ $currentRole === 'todos' ? 'text-white border-b-4 border-red-600' : 'text-gray-500 hover:text-white' }}">
                            TODOS
                        </a>

                        <a href="{{ route('celebridades.index', ['rol' => 'actor']) }}"
                            class="shrink-0 transition-all font-black text-sm tracking-widest uppercase pb-4 {{ $currentRole === 'actor' ? 'text-white border-b-4 border-red-600' : 'text-gray-500 hover:text-white' }}">
                            ACTORES
                        </a>

                        <a href="{{ route('celebridades.index', ['rol' => 'director']) }}"
                            class="shrink-0 transition-all font-black text-sm tracking-widest uppercase pb-4 {{ $currentRole === 'director' ? 'text-white border-b-4 border-red-600' : 'text-gray-500 hover:text-white' }}">
                            DIRECTORES
                        </a>
                    </div>
                </div>

                {{-- Buscador --}}
                <div class="relative mb-4">
                    <input type="text" id="celebSearch" placeholder="BUSCAR ARTISTA..."
                        class="bg-[#1a1a1a] border-none text-white text-xs font-bold rounded-full pl-6 pr-12 py-3 w-72 focus:ring-2 focus:ring-red-600 transition-all uppercase placeholder:text-gray-600 outline-none">
                    <svg class="w-4 h-4 absolute right-4 top-3 text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- Grid de Celebridades --}}
            <div id="grid-celebridades"
                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-y-12 gap-x-8">
                @forelse ($celebridades as $persona)
                    <div class="celeb-card group relative transition-all duration-500"
                        data-nombre="{{ strtolower($persona['nombre_completo']) }}">
                        <div
                            class="relative aspect-[3/4.5] overflow-hidden rounded-xl ring-1 ring-white/10 transition-all duration-500 group-hover:ring-red-600/50 group-hover:-translate-y-2 shadow-2xl">
                            <img src="{{ $persona['foto_url'] ?: asset('images/default-avatar.png') }}"
                                alt="{{ $persona['nombre_completo'] }}"
                                class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80 group-hover:opacity-100 transition-opacity">
                            </div>

                            <div class="absolute top-4 left-4">
                                <span
                                    class="bg-black/60 backdrop-blur-md border border-white/10 text-white text-[8px] font-black px-3 py-1.5 uppercase tracking-widest rounded-md">
                                    {{ $persona['total_peliculas'] ?? 0 }} FILMS
                                </span>
                            </div>

                            <div
                                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500">
                                <a href="{{ route('celebridades.show', $persona['id']) }}"
                                    class="bg-white text-black text-[9px] font-black px-6 py-3 tracking-widest uppercase rounded-full hover:bg-red-600 hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 duration-500 shadow-xl">
                                    Ver Perfil
                                </a>
                            </div>
                        </div>

                        <div class="mt-5 space-y-1 text-center md:text-left">
                            <h3
                                class="text-white font-bold uppercase tracking-tight text-md leading-none group-hover:text-red-500 transition-colors">
                                {{ $persona['nombre_completo'] }}
                            </h3>
                            <p class="text-zinc-500 text-[9px] font-black uppercase tracking-[0.2em]">
                                {{ $persona['rol'] ?? 'CREATIVE' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <p class="text-zinc-600 font-black uppercase tracking-[0.3em] italic">No se encontraron
                            resultados.</p>
                    </div>
                @endforelse
            </div>

            {{-- Paginación Mejorada --}}
            <div class="mt-24 pb-10 flex flex-col items-center gap-8"> {{-- Aumentado mb-32 para más aire al final --}}
                @if ($celebridades->total() > 0)
                    <div class="flex items-center gap-3">

                        {{-- Botón Anterior --}}
                        @if (!$celebridades->onFirstPage())
                            <a href="{{ $celebridades->appends(['rol' => request('rol')])->previousPageUrl() }}"
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

                        {{-- Panel Central de Información --}}
                        <div class="relative group">
                            {{-- Efecto de resplandor sutil de fondo --}}
                            <div
                                class="absolute -inset-0.5 bg-gradient-to-r from-red-600 to-zinc-600 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000">
                            </div>

                            <div
                                class="relative px-8 py-3 bg-zinc-950 border border-white/10 rounded-2xl flex flex-col items-center min-w-[180px]">
                                <span
                                    class="text-[10px] font-black tracking-[0.2em] text-zinc-500 uppercase leading-none">
                                    Página <span class="text-white">{{ $celebridades->currentPage() }}</span> de <span
                                        class="text-zinc-500">{{ $celebridades->lastPage() }}</span>
                                </span>

                                {{-- Barra de progreso visual --}}
                                <div class="w-full h-1 bg-zinc-800 rounded-full mt-3 overflow-hidden">
                                    <div class="h-full bg-red-600 transition-all duration-500"
                                        style="width: {{ ($celebridades->currentPage() / $celebridades->lastPage()) * 100 }}%">
                                    </div>
                                </div>

                                <span
                                    class="text-[9px] font-bold text-red-600 tracking-tighter uppercase mt-2 opacity-80">
                                    {{ number_format($celebridades->total()) }} Artistas Registrados
                                </span>
                            </div>
                        </div>

                        {{-- Botón Siguiente --}}
                        @if ($celebridades->hasMorePages())
                            <a href="{{ $celebridades->appends(['rol' => request('rol')])->nextPageUrl() }}"
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
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('celebSearch');
                const cards = document.querySelectorAll('.celeb-card');

                searchInput.addEventListener('input', (e) => {
                    const term = e.target.value.toLowerCase();
                    cards.forEach(card => {
                        const name = card.getAttribute('data-nombre');
                        // Usamos clases de Tailwind 'hidden' y 'block'
                        if (name.includes(term)) {
                            card.classList.remove('hidden');
                            card.classList.add('block');
                        } else {
                            card.classList.remove('block');
                            card.classList.add('hidden');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
