<x-app-layout>
    <div class="min-h-screen bg-[#0f0f0f] text-white antialiased">

        {{-- SECCIÓN HERO --}}
        <div class="relative w-full min-h-[550px] md:h-[750px] flex flex-col justify-end overflow-hidden">

            {{-- Capa de Imagen (Backdrop) --}}
            <div class="absolute inset-0 z-0">
                @if (isset($backdrop) && $backdrop)
                    <img src="{{ $backdrop }}"
                        class="w-full h-full object-cover object-center opacity-60 transition-opacity duration-700"
                        alt="Backdrop">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-gray-800 to-black"></div>
                @endif

                <div class="absolute inset-0 bg-gradient-to-t from-[#0f0f0f] via-[#0f0f0f]/40 to-transparent z-10"></div>
            </div>

            {{-- Contenido Principal --}}
            <div class="relative z-20 w-full max-w-7xl mx-auto px-6 md:px-8 pb-10 md:pb-20">

                <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12">

                    <div class="flex-1 drop-shadow-[0_4px_12px_rgba(0,0,0,0.9)] pt-32 md:pt-0">
                        <h1
                            class="text-3xl sm:text-5xl md:text-6xl font-black uppercase tracking-tighter italic leading-[0.95] drop-shadow-2xl">
                            {{ $pelicula['titulo'] }}
                        </h1>
                        <div
                            class="flex items-center gap-4 text-gray-300 text-[10px] md:text-xs font-bold uppercase tracking-widest mt-6">
                            <span class="bg-white/10 px-3 py-1 rounded-sm backdrop-blur-md border border-white/10">
                                {{ $pelicula['anio'] }}
                            </span>
                            <span class="text-red-600">•</span>
                            <span>{{ \Carbon\Carbon::parse($pelicula['fecha_estreno'])->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    {{-- Stats Box --}}
                    <div
                        class="flex items-center gap-6 md:gap-8 bg-black/40 backdrop-blur-xl p-5 md:p-6 rounded-2xl border border-white/10 shadow-2xl">
                        <div class="text-center">
                            <h4 class="text-gray-400 font-black text-[9px] uppercase tracking-widest mb-1">Duración</h4>
                            <p class="text-sm md:text-lg font-bold italic">
                                @php
                                    $horas = floor($pelicula['duracion_min'] / 60);
                                    $minutos = $pelicula['duracion_min'] % 60;
                                @endphp
                                {{ $horas > 0 ? $horas . 'h ' : '' }}{{ $minutos }}m
                            </p>
                        </div>
                        <div class="w-[1px] h-8 bg-white/10"></div>
                        <div class="text-center">
                            <h4 class="text-gray-400 font-black text-[9px] uppercase tracking-widest mb-1">Estado</h4>
                            <p class="text-sm md:text-lg font-bold italic text-green-400 flex items-center gap-2">
                                <span
                                    class="w-2 h-2 bg-green-500 rounded-full {{ $pelicula['estado'] == 'Cartelera' ? 'animate-pulse' : '' }}"></span>
                                {{ $pelicula['estado'] }}
                            </p>
                        </div>

                        @if ($mostrarCriticas)
                            <div class="w-[1px] h-8 bg-white/10"></div>
                            <div class="text-center">
                                <h4 class="text-gray-400 font-black text-[9px] uppercase tracking-widest mb-1">Rating
                                </h4>
                                <div class="flex items-center justify-center gap-1">
                                    @php $rating = (float)$pelicula['rating']; @endphp
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @php
                                                $percent = max(0, min(100, ($rating - ($i - 1)) * 100));
                                            @endphp
                                            <svg class="w-4 h-4 md:w-5 md:h-5" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient
                                                        id="grad-hero-{{ $pelicula['id_pelicula'] }}-{{ $i }}">
                                                        <stop offset="{{ $percent }}%" stop-color="#eab308" />
                                                        <stop offset="{{ $percent }}%" stop-color="#3f3f46" />
                                                    </linearGradient>
                                                </defs>
                                                <path
                                                    fill="url(#grad-hero-{{ $pelicula['id_pelicula'] }}-{{ $i }})"
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-1 text-sm md:text-lg font-bold italic text-yellow-500">
                                        {{ $rating > 0 ? number_format($rating, 1) : '—' }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Bloque Inferior: Póster y Sinopsis --}}
                <div
                    class="flex flex-col md:flex-row gap-8 md:gap-14 items-center md:items-start text-center md:text-left">
                    <div
                        class="w-48 md:w-56 shrink-0 shadow-[0_20px_50px_rgba(0,0,0,0.8)] rounded-xl overflow-hidden border border-white/10 transform hover:scale-105 transition-transform duration-500">
                        <img src="{{ $pelicula['poster_url'] }}" class="w-full h-auto"
                            alt="Poster de {{ $pelicula['titulo'] }}">
                    </div>

                    <div class="flex-1 space-y-8 drop-shadow-[0_2px_8px_rgba(0,0,0,0.8)] w-full">
                        <div class="max-w-3xl">
                            <h4
                                class="text-white font-black text-xs tracking-[0.4em] uppercase mb-4 flex items-center justify-center md:justify-start gap-3 italic">
                                <span class="w-10 h-[2px] bg-red-600"></span> Sinopsis _
                            </h4>
                            <p class="text-gray-100 leading-relaxed font-medium text-lg md:text-xl italic opacity-95">
                                {{ $pelicula['sinopsis'] }}
                            </p>
                        </div>

                        <div
                            class="flex flex-wrap justify-center md:justify-start gap-x-12 gap-y-6 pt-8 border-t border-white/10">
                            <div class="group">
                                <span
                                    class="text-gray-500 font-black text-[10px] uppercase tracking-widest block mb-1 group-hover:text-red-500 transition-colors">Clasificación</span>
                                <span
                                    class="text-white font-bold text-sm italic border border-white/20 px-2 py-0.5">{{ $pelicula['clasificacion_codigo'] }}</span>
                            </div>

                            {{-- SECCIÓN GÉNEROS --}}
                            <div>
                                <span
                                    class="text-gray-500 font-black text-[10px] uppercase tracking-widest block mb-1">Géneros</span>
                                <p class="text-white font-bold text-sm italic">
                                    {{ collect($pelicula['generos'])->pluck('nombre')->implode(', ') ?: 'No definidos' }}
                                </p>
                            </div>
                            {{-- SECCIÓN PAÍS DE ORIGEN --}}
                            <div>
                                <span
                                    class="text-gray-500 font-black text-[10px] uppercase tracking-widest block mb-1">País
                                    de Origen</span>
                                <p class="text-white font-bold text-sm italic">
                                    @if (count($pelicula['paises']) > 0)
                                        {{ collect($pelicula['paises'])->pluck('nombre')->implode(' & ') }}
                                    @else
                                        No definido
                                    @endif
                                </p>
                            </div>
                            {{-- SECCIÓN DIRECCIÓN --}}
                            <div>
                                <span class="text-gray-500 font-black text-[10px] uppercase tracking-widest block mb-2">
                                    Dirección
                                </span>

                                @php
                                    $directores = collect($pelicula['reparto'])->filter(function ($miembro) {
                                        return isset($miembro['rol']) &&
                                            trim(strtolower($miembro['rol'])) === 'director';
                                    });
                                @endphp

                                <div class="flex flex-col gap-3">
                                    @forelse ($directores as $director)
                                        <a href="{{ route('celebridades.show', $director['id_persona']) }}"
                                            class="flex items-center gap-3 group transition-all duration-300">

                                            {{-- Foto del Director --}}
                                            <div class="relative shrink-0">
                                                <img src="{{ $director['foto_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($director['nombre_completo']) . '&background=333&color=fff' }}"
                                                    class="w-10 h-10 rounded-full object-cover border-2 border-transparent group-hover:border-red-600 transition-all shadow-lg"
                                                    alt="{{ $director['nombre_completo'] }}">
                                            </div>

                                            {{-- Nombre --}}
                                            <p
                                                class="text-white font-bold text-sm italic group-hover:text-red-500 transition-colors">
                                                {{ $director['nombre_completo'] }}
                                            </p>
                                        </a>
                                    @empty
                                        <p class="text-white/50 font-bold text-sm italic">No asignado</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Multimedia y Reparto --}}
        <div class="max-w-7xl mx-auto px-6 md:px-8 py-20 md:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 md:gap-24">

                {{-- Multimedia --}}
                <div class="lg:col-span-2 space-y-10">
                    <h2 class="text-4xl font-black uppercase tracking-tighter italic text-center md:text-left">
                        Multimedia <span class="text-red-600 ml-1">_</span></h2>
                    <div
                        class="aspect-video rounded-3xl overflow-hidden bg-black border border-white/5 shadow-2xl ring-1 ring-white/10">
                        @php
                            $videoId = '';
                            if (!empty($pelicula['trailer_url'])) {
                                $pattern =
                                    '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
                                if (preg_match($pattern, $pelicula['trailer_url'], $matches)) {
                                    $videoId = $matches[1];
                                }
                            }
                        @endphp
                        @if ($videoId)
                            <iframe class="w-full h-full"
                                src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1"
                                frameborder="0" allowfullscreen></iframe>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-zinc-900/50">
                                <svg class="w-12 h-12 text-zinc-700 mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-zinc-600 font-black text-xs uppercase tracking-widest">Trailer no
                                    disponible</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Reparto --}}
                <div class="space-y-10" x-data="{ openModal: false }">
                    <h2 class="text-4xl font-black uppercase tracking-tighter italic text-center md:text-left">
                        Reparto <span class="text-red-600 ml-1">_</span>
                    </h2>

                    <div class="divide-y divide-white/5">
                        @php
                            $todosLosActores = collect($pelicula['reparto'])->filter(function ($miembro) {
                                return strtolower($miembro['rol']) === 'actor';
                            });
                            $visibles = $todosLosActores->take(5);
                            $restantes = $todosLosActores->count() - 5;
                        @endphp

                        {{-- LISTA PRINCIPAL (MÁXIMO 5) --}}
                        @foreach ($visibles as $actor)
                            <a href="{{ route('celebridades.show', $actor['id_persona']) }}"
                                class="flex items-center gap-5 py-5 hover:bg-white/[0.05] transition-all rounded-2xl px-3 group relative overflow-hidden">

                                <div
                                    class="absolute inset-y-0 left-0 w-1 bg-red-600 transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300">
                                </div>

                                <div class="relative shrink-0">
                                    <img src="{{ $actor['foto_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($actor['nombre_completo']) . '&background=111&color=fff&bold=true' }}"
                                        class="w-14 h-14 rounded-full object-cover border border-white/10 shadow-lg group-hover:border-red-600 group-hover:scale-105 transition-all duration-300"
                                        alt="{{ $actor['nombre_completo'] }}">
                                </div>

                                <div class="flex-1">
                                    <h4
                                        class="text-sm md:text-base font-black uppercase italic tracking-tight group-hover:text-red-500 transition-colors">
                                        {{ $actor['nombre_completo'] }}
                                    </h4>
                                    <p
                                        class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest mt-1 group-hover:text-zinc-300 transition-colors">
                                        {{ $actor['personaje'] ?? 'Interpretación' }}
                                    </p>
                                </div>
                            </a>
                        @endforeach

                        {{-- BOTÓN VER MÁS --}}
                        @if ($restantes > 0)
                            <button @click="openModal = true"
                                class="w-full py-6 group flex items-center justify-center gap-3 border-t border-white/5 hover:bg-white/[0.02] transition-all rounded-b-2xl">
                                <span
                                    class="text-zinc-500 font-black uppercase text-xs tracking-[0.3em] group-hover:text-red-600 transition-colors">
                                    Ver reparto completo (+{{ $restantes }})
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 text-zinc-500 group-hover:text-red-600 transition-colors group-hover:translate-x-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        @endif
                    </div>

                    {{-- EL MODAL --}}
                    <div x-show="openModal"
                        class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>

                        <div @click.away="openModal = false"
                            class="bg-zinc-950 border border-white/10 w-full max-w-3xl max-h-[85vh] rounded-3xl overflow-hidden flex flex-col shadow-2xl">

                            {{-- Header --}}
                            <div class="p-6 border-b border-white/5 flex items-center justify-between bg-zinc-900/50">
                                <h3 class="text-xl font-black uppercase italic text-white">
                                    Reparto Completo <span class="text-red-600">_</span>
                                </h3>
                                <button @click="openModal = false"
                                    class="text-zinc-500 hover:text-white transition-colors p-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            {{-- Contenido en Grilla de 2 Columnas --}}
                            <div class="overflow-y-auto p-6 custom-scrollbar">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($todosLosActores as $actor)
                                        <a href="{{ route('celebridades.show', $actor['id_persona']) }}"
                                            class="flex items-center gap-4 p-3 hover:bg-white/[0.05] transition-all rounded-xl group border border-transparent hover:border-white/5">

                                            <img src="{{ $actor['foto_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($actor['nombre_completo']) . '&background=111&color=fff' }}"
                                                class="w-12 h-12 rounded-full object-cover border border-white/10 group-hover:border-red-600 transition-all shrink-0">

                                            <div class="truncate">
                                                <h4
                                                    class="text-white font-black uppercase italic text-sm group-hover:text-red-500 transition-colors truncate">
                                                    {{ $actor['nombre_completo'] }}
                                                </h4>
                                                <p
                                                    class="text-[10px] text-zinc-500 font-bold uppercase tracking-widest truncate">
                                                    {{ $actor['personaje'] ?? 'Interpretación' }}
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COMUNIDAD --}}
            <div class="mt-32 pt-20 border-t border-white/5">
                @if ($mostrarCriticas)
                    <div x-data="{ modalCalificar: false }">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-10 mb-16">
                            <div>
                                <h2 class="text-5xl font-black uppercase tracking-tighter italic">Comunidad <span
                                        class="text-red-600">_</span></h2>
                                <p class="text-zinc-500 font-bold uppercase tracking-[0.3em] text-[10px] mt-2">Reseñas
                                    de la audiencia</p>
                            </div>
                            <div
                                class="flex items-center gap-10 bg-zinc-900/50 p-6 rounded-3xl border border-white/5 backdrop-blur-xl">
                                <div class="text-center">
                                    <span
                                        class="text-4xl font-black text-yellow-500 italic block leading-none">{{ number_format($rating, 1) }}</span>
                                    <span
                                        class="text-[9px] text-zinc-500 font-black uppercase italic tracking-widest mt-1">Score</span>
                                </div>
                                <div class="w-[1px] h-12 bg-white/10"></div>
                                <div>
                                    @auth
                                        @if (!$yaCalifico)
                                            <button @click="modalCalificar = true"
                                                class="relative group overflow-hidden bg-gradient-to-r from-red-600 to-red-800 px-8 py-4 rounded-xl font-black uppercase tracking-widest text-[11px] transition-all duration-300 hover:scale-105 active:scale-95 shadow-[0_0_20px_rgba(220,38,38,0.3)] hover:shadow-[0_0_30px_rgba(220,38,38,0.5)] italic text-white flex items-center gap-2">
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                <span class="relative">Calificar Película</span>
                                            </button>
                                            @include('cliente.critica-form')
                                        @else
                                            <div
                                                class="text-zinc-500 font-black text-[10px] uppercase tracking-widest italic border border-white/5 px-6 py-4 rounded-xl">
                                                Ya has calificado esta película
                                            </div>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="group flex items-center gap-3 text-zinc-500 border border-white/10 px-8 py-4 rounded-xl text-[10px] uppercase font-black tracking-widest hover:bg-white/5 hover:text-white hover:border-white/20 transition-all duration-300 italic">
                                            Inicia sesión para calificar
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>

                        {{-- Lista Críticas --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @forelse($criticas as $critica)
                                <div
                                    class="bg-zinc-900/30 border border-white/5 p-8 rounded-[2rem] hover:bg-zinc-900/50 transition-all duration-300">
                                    <div class="flex justify-between items-start mb-6">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-12 h-12 rounded-2xl bg-gradient-to-br from-zinc-800 to-black border border-white/10 flex items-center justify-center font-black text-red-600 text-xl italic">
                                                {{ strtoupper(substr($critica->usuario->nombres, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-black uppercase tracking-tight italic">
                                                    {{ $critica->usuario->nombres }}
                                                    {{ $critica->usuario->apellidos ?? '' }}
                                                </h4>
                                                <p
                                                    class="text-[9px] text-zinc-600 font-bold uppercase tracking-widest">
                                                    {{ $critica->fecha_publicacion->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="bg-black/60 px-3 py-1.5 rounded-full border border-yellow-500/20 flex items-center gap-1">
                                            @for ($j = 1; $j <= 5; $j++)
                                                @php $p = max(0, min(100, ($critica->puntuacion - ($j - 1)) * 100)); @endphp
                                                <svg class="w-3 h-3" viewBox="0 0 20 20">
                                                    <defs>
                                                        <linearGradient
                                                            id="grad-critica-{{ $critica->id_critica }}-{{ $j }}">
                                                            <stop offset="{{ $p }}%"
                                                                stop-color="#eab308" />
                                                            <stop offset="{{ $p }}%"
                                                                stop-color="#3f3f46" />
                                                        </linearGradient>
                                                    </defs>
                                                    <path
                                                        fill="url(#grad-critica-{{ $critica->id_critica }}-{{ $j }})"
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                            <span
                                                class="text-yellow-500 font-black text-[10px] italic ml-1">{{ number_format($critica->puntuacion, 1) }}</span>
                                        </div>
                                    </div>
                                    <p class="text-zinc-400 leading-relaxed text-sm italic font-medium">
                                        "{{ $critica->comentario }}"</p>
                                </div>
                            @empty
                                <div
                                    class="col-span-full text-center py-24 bg-white/[0.01] rounded-[3rem] border-2 border-dashed border-white/5">
                                    <p class="text-zinc-600 font-black uppercase tracking-[0.5em] text-[10px]">Sin
                                        opiniones todavía</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-12 text-white">{{ $criticas->links() }}</div>
                    </div>
                @else
                    {{-- ESTADO PRÓXIMO --}}
                    <div
                        class="text-center py-24 bg-zinc-900/10 rounded-[3rem] border border-white/5 flex flex-col items-center justify-center">
                        <h2 class="text-3xl font-black uppercase tracking-tighter italic text-zinc-500">Próximamente
                        </h2>
                        <p
                            class="text-zinc-600 font-bold uppercase tracking-[0.3em] text-[10px] mt-4 max-w-xs mx-auto">
                            Las calificaciones y reseñas se habilitarán una vez que la película sea estrenada
                            oficialmente.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
