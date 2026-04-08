<x-app-layout>
    <div class="min-h-screen bg-[#0f0f0f] text-white">

        {{-- Hero Section --}}
        <div class="relative h-[450px] w-full overflow-hidden flex items-center">
            <div class="absolute inset-0 z-0">
                @if ($backdrop)
                    <img src="{{ $backdrop }}"
                        class="w-full h-full object-cover opacity-50 transition-opacity duration-700 ease-in"
                        id="hero-bg">
                @else
                    <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=2000"
                        class="w-full h-full object-cover opacity-30">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f0f0f] via-[#0f0f0f]/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#0f0f0f] via-transparent to-transparent"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-8 w-full">
                <h1
                    class="text-6xl md:text-8xl font-black uppercase tracking-tighter italic leading-none drop-shadow-2xl">
                    PELÍ<span class="text-red-600">CULAS</span>
                </h1>
                <p class="text-gray-200 mt-4 max-w-2xl text-lg font-medium leading-relaxed drop-shadow-lg">
                    Donde las grandes historias trascienden la pantalla: descubre, califica y dale vida al cine con tu
                    propia voz en la comunidad de PrimeCinemas.
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-8 -mt-10 relative z-20">
            {{-- Navegación de Filtros --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 border-b border-white/10">

                <div class="relative overflow-hidden group w-full md:w-auto">
                    <div class="flex space-x-8 overflow-x-auto pb-4 scroll-smooth scrollbar-hide" id="statusFilters">
                        <button data-status="Todas"
                            class="filter-btn shrink-0 transition-all font-black text-sm tracking-widest uppercase pb-4 text-white border-b-4 border-red-600">TODAS</button>
                        <button data-status="Ya Emitida"
                            class="filter-btn shrink-0 transition-all font-black text-sm tracking-widest uppercase pb-4 text-gray-500 hover:text-white">YA
                            EMITIDAS</button>
                        <button data-status="En Emision"
                            class="filter-btn shrink-0 transition-all font-black text-sm tracking-widest uppercase pb-4 text-gray-500 hover:text-white">EN
                            EMISIÓN</button>
                        <button data-status="Proximamente"
                            class="filter-btn shrink-0 transition-all font-black text-sm tracking-widest uppercase pb-4 text-gray-500 hover:text-white">PRÓXIMAMENTE</button>
                    </div>

                    <div id="scroll-indicator"
                        class="absolute right-0 top-0 h-full w-16 bg-gradient-to-l from-[#0f0f0f] to-transparent pointer-events-none md:hidden transition-opacity duration-300">
                    </div>
                </div>

                <div class="relative mb-4">
                    <input type="text" id="movieSearch" placeholder="BUSCAR POR TÍTULO..."
                        class="bg-[#1a1a1a] border-none text-white text-xs font-bold rounded-full pl-6 pr-12 py-3 w-72 focus:ring-2 focus:ring-red-600 transition-all uppercase placeholder:text-gray-600">
                    <svg class="w-4 h-4 absolute right-4 top-3 text-gray-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            {{-- Grid de Películas --}}
            <div id="grid-peliculas"
                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-x-6 gap-y-12">
                {{-- Loader inicial --}}
                <div class="col-span-full py-20 flex flex-col items-center justify-center">
                    <div class="w-10 h-10 border-4 border-red-600 border-t-transparent rounded-full animate-spin mb-4">
                    </div>
                    <p class="text-gray-500 font-black text-xs tracking-widest uppercase italic">Sincronizando
                        Archivos...</p>
                </div>
            </div>

            {{-- Controles de Paginación --}}
            <div id="pagination-container" class="mt-16 mb-20 flex justify-center items-center gap-2"></div>
        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    @push('scripts')
        <script>
            // Estado global de la aplicación cliente
            let todasLasPeliculas = [];
            let currentStatus = 'Todas';
            let searchQuery = '';

            document.addEventListener('DOMContentLoaded', function() {
                const filtersContainer = document.getElementById('statusFilters');
                const indicator = document.getElementById('scroll-indicator');
                const searchInput = document.getElementById('movieSearch');

                // 1. Carga Inicial
                cargarPeliculas(1);

                // 2. Función de Carga (Fetch)
                async function cargarPeliculas(page = 1) {
                    try {
                        const response = await fetch(`{{ route('api.peliculas.index') }}?page=${page}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        const result = await response.json();

                        if (result.success) {
                            todasLasPeliculas = result.data;
                            actualizarInterfaz(result.pagination);

                            if (page > 1) {
                                window.scrollTo({
                                    top: 400,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    } catch (error) {
                        console.error("Error cargando películas:", error);
                    }
                }

                // 3. Renderizado Lógico (Filtros + Búsqueda)
                function actualizarInterfaz(paginationData = null) {
                    // Filtrar localmente lo que ya descargamos
                    let filtradas = todasLasPeliculas;

                    // Filtro por Estado
                    if (currentStatus !== 'Todas') {
                        filtradas = filtradas.filter(p => p.estado === currentStatus);
                    }

                    // Filtro por Búsqueda
                    if (searchQuery) {
                        filtradas = filtradas.filter(p =>
                            p.titulo.toLowerCase().includes(searchQuery.toLowerCase())
                        );
                    }

                    renderizarGrid(filtradas);

                    if (paginationData) {
                        renderizarPaginacion(paginationData);
                    }
                }

                function renderizarGrid(peliculas) {
                    const contenedor = document.getElementById('grid-peliculas');
                    contenedor.innerHTML = '';

                    if (peliculas.length === 0) {
                        contenedor.innerHTML =
                            `<p class="col-span-full text-center text-gray-600 py-10 font-black uppercase tracking-widest italic">No hay resultados coincidentes</p>`;
                        return;
                    }

                    peliculas.forEach(p => {
                        const estadoLower = p.estado.toLowerCase();
                        const esProximamente = estadoLower.includes('proximamente') || estadoLower.includes(
                            'próximamente');

                        // Rating: Priorizamos 'rating' que viene del withAvg del controlador
                        const valorRating = p.rating ?? 0;

                        let ratingText = 'S/C';
                        if (!esProximamente && valorRating > 0) {
                            ratingText = parseFloat(valorRating).toFixed(1);
                        } else if (esProximamente) {
                            ratingText = '??';
                        }

                        const starColor = (esProximamente || valorRating == 0) ? 'text-zinc-600' :
                            'text-yellow-500';

                        contenedor.innerHTML += `
                            <div class="group relative bg-[#151515] rounded-2xl overflow-hidden transition-all duration-500 hover:-translate-y-3 hover:ring-1 hover:ring-white/20">
                                <div class="relative aspect-[2/3] overflow-hidden">
                                    <img src="${p.poster_url}" class="w-full h-full object-cover grayscale-[0.3] group-hover:grayscale-0 transition-all duration-500" loading="lazy">
                                    <div class="absolute top-3 left-3 flex flex-col gap-2">
                                        <span class="bg-black/90 text-[9px] font-black px-2 py-1 rounded-md text-red-600 border border-red-600/20 uppercase tracking-tighter">
                                            ${p.clasificacion_codigo ?? 'S/E'}
                                        </span>
                                        <span class="bg-zinc-900/90 backdrop-blur-md text-[9px] font-bold px-2 py-1 rounded-md text-zinc-300 border border-white/5">
                                            ${p.anio}
                                        </span>
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-4">
                                         <a href="/cartelera/${p.id_pelicula}" class="w-full py-3 bg-white text-black text-[11px] font-black rounded-xl uppercase tracking-widest hover:bg-red-600 hover:text-white transition-colors text-center">Ver Detalles</a>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-[13px] font-black uppercase tracking-tight truncate mb-2" title="${p.titulo}">${p.titulo}</h3>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center gap-1.5 bg-black/40 px-2 py-1 rounded-md border border-white/5">
                                            <svg class="w-3.5 h-3.5 ${starColor}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-[11px] font-black ${starColor}">${ratingText}</span>
                                        </div>
                                        <span class="text-[9px] text-red-600 font-black tracking-widest italic uppercase border-b border-red-600/30">
                                            ${p.estado}
                                        </span>
                                    </div>
                                </div>
                            </div>`;
                    });
                }

                function renderizarPaginacion(nav) {
                    const pagContainer = document.getElementById('pagination-container');
                    pagContainer.innerHTML = '';
                    if (nav.total_pages <= 1) return;

                    const btnClass =
                        "px-4 py-2 bg-zinc-900 text-zinc-500 font-black text-[10px] rounded-lg transition-all hover:bg-zinc-800 hover:text-white uppercase tracking-widest border border-white/5";
                    const activeClass =
                        "bg-red-600 text-white border-red-500 shadow-lg shadow-red-900/20 hover:bg-red-700";

                    if (nav.current_page > 1) {
                        const prevBtn = document.createElement('button');
                        prevBtn.className = btnClass;
                        prevBtn.innerText = '←';
                        prevBtn.onclick = () => cargarPeliculas(nav.current_page - 1);
                        pagContainer.appendChild(prevBtn);
                    }

                    for (let i = 1; i <= nav.total_pages; i++) {
                        if (i === 1 || i === nav.total_pages || (i >= nav.current_page - 1 && i <= nav.current_page +
                            1)) {
                            const pBtn = document.createElement('button');
                            pBtn.className = `${btnClass} ${i === nav.current_page ? activeClass : ''}`;
                            pBtn.innerText = i;
                            pBtn.onclick = () => cargarPeliculas(i);
                            pagContainer.appendChild(pBtn);
                        } else if (i === nav.current_page - 2 || i === nav.current_page + 2) {
                            const dots = document.createElement('span');
                            dots.className = "text-zinc-700 font-black px-1";
                            dots.innerText = '...';
                            pagContainer.appendChild(dots);
                        }
                    }

                    if (nav.current_page < nav.total_pages) {
                        const nextBtn = document.createElement('button');
                        nextBtn.className = btnClass;
                        nextBtn.innerText = '→';
                        nextBtn.onclick = () => cargarPeliculas(nav.current_page + 1);
                        pagContainer.appendChild(nextBtn);
                    }
                }

                // Eventos de Filtros
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.filter-btn').forEach(b => {
                            b.classList.remove('text-white', 'border-b-4', 'border-red-600');
                            b.classList.add('text-gray-500');
                        });

                        this.classList.add('text-white', 'border-b-4', 'border-red-600');
                        this.classList.remove('text-gray-500');

                        currentStatus = this.getAttribute('data-status');
                        actualizarInterfaz(); // Filtrado local rápido
                    });
                });

                // Evento de Búsqueda
                searchInput.addEventListener('input', (e) => {
                    searchQuery = e.target.value;
                    actualizarInterfaz(); // Filtrado local instantáneo
                });

                // Scroll del indicador
                filtersContainer.addEventListener('scroll', () => {
                    const maxScroll = filtersContainer.scrollWidth - filtersContainer.clientWidth;
                    indicator.classList.toggle('opacity-0', filtersContainer.scrollLeft >= maxScroll - 20);
                });
            });
        </script>
    @endpush
</x-app-layout>
