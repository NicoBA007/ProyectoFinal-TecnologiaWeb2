<x-app-layout>
    <div class="bg-black min-h-screen pb-20">
        {{-- 1. CARRUSEL HERO --}}
        @if (isset($carouselItems) && count($carouselItems) > 0)
            <div x-data="{
                active: 0,
                total: {{ count($carouselItems) }},
                loop() {
                    if (this.total > 1) {
                        setInterval(() => { this.active = (this.active + 1) % this.total }, 5000)
                    }
                }
            }" x-init="loop()"
                class="relative h-[450px] md:h-[650px] w-full overflow-hidden bg-black">

                @foreach ($carouselItems as $index => $item)
                    <div x-show="active === {{ $index }}" x-cloak
                        x-transition:enter="transition opacity duration-1000"
                        x-transition:leave="transition opacity duration-1000" class="absolute inset-0">
                        <img src="{{ $item['backdrop'] }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 z-0"></div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-90">
                        </div>
                    </div>
                @endforeach

                <div class="absolute inset-0 flex flex-col justify-center items-center text-center px-6 z-10">
                    <h2
                        class="text-white text-3xl md:text-5xl font-black uppercase tracking-[0.3em] mb-4 drop-shadow-2xl italic">
                        Tu voz le da vida al cine
                    </h2>
                    <p
                        class="text-gray-200 text-sm md:text-lg max-w-2xl font-medium mb-10 drop-shadow-md italic opacity-90">
                        Descubre, califica y comparte tu pasión con la comunidad de PrimeCinemas. Los mejores estrenos y
                        críticas en un solo lugar.
                    </p>
                    <a href="#secciones-contenido"
                        class="bg-red-600 hover:bg-white hover:text-black text-white px-10 py-4 rounded-full font-black uppercase text-[11px] tracking-[0.2em] transition-all duration-300 shadow-[0_0_20px_rgba(220,38,38,0.5)]">
                        Explorar Ahora →
                    </a>
                </div>
            </div>
        @endif

        <div id="secciones-contenido" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24 -mt-10 relative z-30">

            {{-- SECCIÓN PELÍCULAS --}}
            <section x-data="carouselHandler()" x-init="initAutoPlay()">
                <h2
                    class="text-2xl font-black text-white uppercase tracking-widest mb-8 border-l-4 border-red-600 pl-4">
                    En <span class="text-red-600">Cartelera</span>
                </h2>

                <div class="relative group">
                    @if (count($peliculas) > 4)
                        <div
                            class="absolute w-full top-[185px] -translate-y-1/2 flex justify-between pointer-events-none z-40">
                            <button @click="scrollLeft()"
                                class="pointer-events-auto bg-black/80 p-3 rounded-full text-white border border-white/10 hover:bg-red-600 transition-all ml-[-20px]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click="scrollRight()"
                                class="pointer-events-auto bg-black/80 p-3 rounded-full text-white border border-white/10 hover:bg-red-600 transition-all mr-[-20px]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div x-ref="container" @scroll="updateProgress()"
                        class="flex overflow-x-auto gap-6 pb-6 scrollbar-hide snap-x scroll-smooth justify-start">
                        @foreach ($peliculas->take(10) as $pelicula)
                            <div class="w-[200px] md:w-[250px] flex-none snap-start group/card">
                                <div
                                    class="relative aspect-[2/3] rounded-xl overflow-hidden border border-gray-800 group-hover/card:border-red-600 transition-all duration-500 shadow-2xl">
                                    <img src="{{ $pelicula['poster_url'] }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110">
                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-black/60 opacity-0 group-hover/card:opacity-100 transition-opacity">
                                        <a href="{{ route('cartelera.show', $pelicula['id_pelicula']) }}"
                                            class="bg-red-600 text-white font-bold text-[10px] uppercase px-5 py-2 rounded-full hover:scale-105 transition-transform">Ver
                                            Detalles</a>
                                    </div>
                                </div>
                                <h3 class="mt-3 text-white font-bold text-xs uppercase truncate">
                                    {{ $pelicula['titulo'] }}</h3>
                            </div>
                        @endforeach
                    </div>

                    @if (count($peliculas) > 4)
                        <div class="flex justify-center gap-2 mt-4">
                            <template x-for="i in 5">
                                <div :class="currentPage === i ? 'bg-red-600 w-8' : 'bg-gray-800 w-2'"
                                    class="h-2 rounded-full transition-all duration-300"></div>
                            </template>
                        </div>
                    @endif
                </div>
            </section>

            {{-- SECCIÓN CELEBRIDADES --}}
            <section x-data="carouselHandler()" x-init="initAutoPlay()">
                <h2
                    class="text-2xl font-black text-white uppercase tracking-widest mb-8 border-l-4 border-gray-700 pl-4">
                    Celebridades
                </h2>

                <div class="relative group">
                    @if (count($celebridades) > 5)
                        <div
                            class="absolute w-full top-[64px] -translate-y-1/2 flex justify-between pointer-events-none z-40">
                            <button @click="scrollLeft()"
                                class="pointer-events-auto bg-black/80 p-3 rounded-full text-white border border-white/10 hover:bg-red-600 ml-[-20px]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click="scrollRight()"
                                class="pointer-events-auto bg-black/80 p-3 rounded-full text-white border border-white/10 hover:bg-red-600 mr-[-20px]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div x-ref="container" @scroll="updateProgress()"
                        class="flex overflow-x-auto gap-10 pb-6 scrollbar-hide snap-x scroll-smooth justify-start">
                        @foreach ($celebridades->take(10) as $actor)
                            <div class="flex flex-col items-center w-[140px] flex-none snap-center group/actor">
                                <div
                                    class="w-28 h-28 md:w-32 md:h-32 rounded-full overflow-hidden border-2 border-gray-800 group-hover/actor:border-red-600 transition-all duration-500 shadow-lg">
                                    <img src="{{ $actor['foto_url'] }}"
                                        class="w-full h-full object-cover grayscale group-hover/actor:grayscale-0 transition-all duration-700">
                                </div>
                                <span
                                    class="mt-4 text-gray-400 group-hover/actor:text-white text-[10px] font-bold uppercase tracking-widest text-center">{{ $actor['nombre_completo'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    @if (count($celebridades) > 5)
                        <div class="flex justify-center gap-2 mt-4">
                            <template x-for="i in 5">
                                <div :class="currentPage === i ? 'bg-red-600 w-8' : 'bg-gray-800 w-2'"
                                    class="h-2 rounded-full transition-all duration-300"></div>
                            </template>
                        </div>
                    @endif
                </div>
            </section>

            {{-- SECCIÓN GÉNEROS --}}
            <section x-data="carouselHandler()" x-init="initAutoPlay()">
                <h2
                    class="text-2xl font-black text-white uppercase tracking-widest mb-8 border-l-4 border-gray-700 pl-4">
                    Intereses Populares
                </h2>

                <div class="relative group">
                    @if (count($generos) > 4)
                        <div
                            class="absolute w-full top-[56px] -translate-y-1/2 flex justify-between pointer-events-none z-40">
                            <button @click="scrollLeft()"
                                class="pointer-events-auto bg-black/80 p-3 rounded-full text-white border border-white/10 hover:bg-red-600 ml-[-20px]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click="scrollRight()"
                                class="pointer-events-auto bg-black/80 p-3 rounded-full text-white border border-white/10 hover:bg-red-600 mr-[-20px]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div x-ref="container" @scroll="updateProgress()"
                        class="flex overflow-x-auto gap-4 pb-6 scrollbar-hide snap-x scroll-smooth justify-start">
                        @foreach ($generos->take(10) as $genero)
                            @php
                                $name = $genero['nombre'];
                                $colors = [
                                    'from-red-600 to-orange-600',
                                    'from-blue-600 to-cyan-500',
                                    'from-purple-600 to-pink-500',
                                    'from-green-600 to-emerald-500',
                                    'from-yellow-500 to-orange-400',
                                    'from-indigo-600 to-blue-700',
                                ];
                                $estiloColor = $colors[ord($name[0]) % count($colors)];
                            @endphp
                            <a href="#"
                                class="w-[160px] md:w-[200px] flex-none h-28 rounded-xl overflow-hidden relative group/gen snap-start">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br {{ $estiloColor }} opacity-70 group-hover/gen:opacity-100 transition-all duration-500">
                                </div>
                                <div class="absolute inset-0 flex flex-col items-center justify-center z-10 p-4">
                                    <div
                                        class="w-8 h-8 rounded-full border-2 border-white flex items-center justify-center mb-2">
                                        <span class="text-white text-lg font-bold">+</span></div>
                                    <span
                                        class="text-white text-[10px] font-black uppercase tracking-widest text-center">{{ $name }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    @if (count($generos) > 4)
                        <div class="flex justify-center gap-2 mt-4">
                            <template x-for="i in 5">
                                <div :class="currentPage === i ? 'bg-red-600 w-8' : 'bg-gray-800 w-2'"
                                    class="h-2 rounded-full transition-all duration-300"></div>
                            </template>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>

    <script>
        function carouselHandler() {
            return {
                currentPage: 1,
                initAutoPlay() {
                    setInterval(() => {
                        const container = this.$refs.container;
                        if (!container || container.scrollWidth <= container.clientWidth) return;
                        if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
                            container.scrollTo({
                                left: 0,
                                behavior: 'smooth'
                            });
                        } else {
                            this.scrollRight();
                        }
                    }, 6000);
                },
                updateProgress() {
                    const container = this.$refs.container;
                    if (!container) return;
                    const max = container.scrollWidth - container.clientWidth;
                    if (max <= 0) return;
                    const ratio = container.scrollLeft / max;
                    this.currentPage = Math.round(ratio * 4) + 1;
                },
                scrollLeft() {
                    this.$refs.container.scrollBy({
                        left: -300,
                        behavior: 'smooth'
                    });
                },
                scrollRight() {
                    this.$refs.container.scrollBy({
                        left: 300,
                        behavior: 'smooth'
                    });
                }
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-app-layout>
