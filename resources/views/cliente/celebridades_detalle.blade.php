<x-app-layout>
    <div class="min-h-screen bg-[#050505] text-zinc-100 font-sans selection:bg-yellow-500/30">

        {{-- Hero Section --}}
        @php $mainBackdrop = $celebridad['peliculas']->first()['backdrop'] ?? null; @endphp

        <div class="relative min-h-[65vh] w-full overflow-hidden flex items-end">
            {{-- Background Layer --}}
            <div class="absolute inset-0">
                <img src="{{ $mainBackdrop }}" class="w-full h-full object-cover opacity-40"
                    onerror="this.src='{{ asset('images/placeholder-backdrop.jpg') }}';">
                <div class="absolute inset-0 bg-gradient-to-b from-[#050505]/80 via-transparent to-[#050505]"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-[#050505] via-transparent to-transparent"></div>
            </div>

            {{-- Content Layer --}}
            <div class="relative z-10 max-w-7xl mx-auto px-6 w-full pb-12">
                <div class="flex flex-col lg:flex-row gap-10 items-center lg:items-end pt-32">

                    {{-- Foto de la Celebridad --}}
                    <div class="relative shrink-0">
                        <div
                            class="relative w-44 md:w-56 aspect-[2/3] overflow-hidden rounded-2xl border border-white/10 shadow-2xl shadow-black bg-zinc-900">
                            <img src="{{ $celebridad['foto_url'] }}" class="w-full h-full object-cover"
                                alt="{{ $celebridad['nombre'] }}"
                                onerror="this.src='{{ asset('images/placeholder-avatar.jpg') }}';">
                        </div>
                    </div>

                    <div class="flex-1 text-center lg:text-left">
                        <div class="flex flex-wrap justify-center lg:justify-start gap-2 mb-6">
                            <span
                                class="bg-yellow-500 text-black px-2.5 py-1 rounded text-[10px] font-black uppercase tracking-tighter">Star
                                Talent</span>
                            <span
                                class="bg-white/5 backdrop-blur-md px-2.5 py-1 rounded text-[10px] font-bold text-zinc-400 uppercase border border-white/5">Perfil
                                Verificado</span>
                        </div>

                        <h1
                            class="text-5xl md:text-7xl font-black tracking-tighter leading-none mb-8 drop-shadow-2xl text-white">
                            {{ $celebridad['nombre'] }}
                        </h1>

                        <div
                            class="flex flex-wrap justify-center lg:justify-start items-center gap-8 text-sm border-t border-white/5 pt-8">
                            <div class="flex flex-col">
                                <span
                                    class="text-zinc-500 text-[10px] uppercase tracking-widest font-black mb-1">Nacimiento</span>
                                <span class="font-bold text-zinc-200">
                                    @if ($celebridad['nacimiento'])
                                        {{ ucfirst(\Carbon\Carbon::parse($celebridad['nacimiento'])->locale('es')->translatedFormat('d \d\e F, Y')) }}
                                    @else
                                        No disponible
                                    @endif
                                </span>
                            </div>

                            <div class="flex flex-col border-l border-white/10 pl-8">
                                <span
                                    class="text-zinc-500 text-[10px] uppercase tracking-widest font-black mb-1">Filmografía</span>
                                <span class="font-bold text-zinc-200">{{ count($celebridad['peliculas']) }}
                                    Proyectos</span>
                            </div>

                            @if ($celebridad['lugar_nacimiento'])
                                <div class="flex flex-col border-l border-white/10 pl-8">
                                    <span
                                        class="text-zinc-500 text-[10px] uppercase tracking-widest font-black mb-1">Origen</span>
                                    <span
                                        class="font-bold text-zinc-200 italic">{{ $celebridad['lugar_nacimiento'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Grid --}}
        <main class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                {{-- Sidebar: Redes --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-32 flex lg:flex-col items-center justify-center lg:justify-start gap-5">
                        @php
                            $redesDisponibles = [
                                'instagram' => ['icon' => 'fa-brands fa-instagram', 'color' => 'hover:text-pink-500'],
                                'twitter' => ['icon' => 'fa-brands fa-x-twitter', 'color' => 'hover:text-blue-400'],
                                'facebook' => ['icon' => 'fa-brands fa-facebook-f', 'color' => 'hover:text-blue-600'],
                                'tiktok' => ['icon' => 'fa-brands fa-tiktok', 'color' => 'hover:text-teal-400'],
                            ];
                        @endphp

                        @foreach ($redesDisponibles as $key => $data)
                            @if (!empty($celebridad['redes'][$key]))
                                <a href="{{ $celebridad['redes'][$key] }}" target="_blank"
                                    class="w-12 h-12 flex items-center justify-center rounded-2xl bg-zinc-900/50 border border-white/5 text-zinc-400 {{ $data['color'] }} hover:bg-zinc-800 hover:border-white/20 transition-all group">
                                    <i
                                        class="{{ $data['icon'] }} text-xl group-hover:scale-110 transition-transform"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Content --}}
                <div class="lg:col-span-11">
                    <h3 class="flex items-center gap-4 text-white font-black text-2xl mb-10 uppercase tracking-tighter">
                        <span class="w-1.5 h-8 bg-yellow-500 rounded-full"></span>
                        Filmografía Destacada
                    </h3>

                    {{-- Horizontal Scroll --}}
                    <div
                        class="flex gap-6 overflow-x-auto pb-10 snap-x [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                        @foreach ($celebridad['peliculas'] as $peli)
                            <a href="{{ route('cartelera.show', $peli['id']) }}"
                                class="snap-start shrink-0 w-64 group bg-zinc-900/40 rounded-2xl overflow-hidden border border-white/5 hover:border-yellow-500/50 transition-all duration-300">
                                <div class="relative aspect-[2/3] overflow-hidden bg-zinc-800">
                                    <img src="{{ $peli['poster'] }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                        onerror="this.src='{{ asset('images/placeholder-poster.jpg') }}';">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-60">
                                    </div>
                                    <div class="absolute bottom-3 left-3">
                                        <span
                                            class="bg-yellow-500 text-black text-[9px] px-2 py-0.5 rounded font-black uppercase shadow-lg">
                                            {{ $peli['rol'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h4
                                        class="font-bold text-zinc-100 group-hover:text-yellow-500 transition-colors line-clamp-1 mb-1 text-lg">
                                        {{ $peli['titulo'] }}
                                    </h4>
                                    <p class="text-xs text-zinc-500 font-bold uppercase tracking-widest">
                                        {{ $peli['anio'] }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Historial Detallado: Enfoque en Personaje --}}
                    <div class="mt-8 space-y-3">
                        @foreach ($celebridad['peliculas'] as $peli)
                            <a href="{{ route('cartelera.show', $peli['id']) }}"
                                class="relative grid grid-cols-12 gap-4 p-4 md:p-5 bg-zinc-900/40 hover:bg-zinc-800/60 border border-white/5 hover:border-yellow-500/40 rounded-2xl transition-all duration-300 group items-center shadow-lg">

                                {{-- Año (Estilo Minimalista Lateral) --}}
                                <div
                                    class="col-span-2 md:col-span-1 flex flex-col items-center border-r border-white/10 group-hover:border-yellow-500/30 transition-colors">
                                    <span
                                        class="text-zinc-500 font-black text-sm md:text-base tracking-tighter group-hover:text-yellow-500">
                                        {{ $peli['anio'] }}
                                    </span>
                                </div>

                                {{-- Contenido Principal: Personaje > Película --}}
                                <div class="col-span-7 md:col-span-8 flex items-center gap-6 pl-2">
                                    {{-- Poster Mini --}}
                                    <div
                                        class="relative shrink-0 w-12 h-16 md:w-14 md:h-20 rounded-lg overflow-hidden shadow-2xl bg-zinc-800">
                                        <img src="{{ $peli['poster'] }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                            onerror="this.src='{{ asset('images/placeholder-poster.jpg') }}';">
                                    </div>

                                    <div class="flex flex-col">
                                        {{-- PERSONAJE (Grande y Destacado) --}}
                                        <h4
                                            class="text-lg md:text-2xl font-black text-white leading-none mb-1 group-hover:text-yellow-500 transition-colors">
                                            {{ $peli['personaje'] ?: 'Reparto' }}
                                        </h4>

                                        {{-- PELÍCULA (Subtítulo con icono) --}}
                                        <div
                                            class="flex items-center gap-2 text-zinc-400 group-hover:text-zinc-200 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-3 w-3 md:h-4 md:w-4 text-yellow-500/50" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M2 6a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM2 12a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2z" />
                                            </svg>
                                            <span class="text-sm md:text-base font-medium italic">
                                                {{ $peli['titulo'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Rol y Botón de Acción --}}
                                <div class="col-span-3 flex items-center justify-end gap-4 pr-2">
                                    {{-- Badge de Rol --}}
                                    <span
                                        class="hidden lg:inline-block text-[9px] font-black uppercase tracking-[0.2em] text-zinc-500 bg-black/40 px-3 py-1.5 rounded-md border border-white/5 group-hover:text-zinc-300 transition-all">
                                        {{ $peli['rol'] }}
                                    </span>

                                    {{-- Indicador de flecha --}}
                                    <div
                                        class="text-zinc-600 group-hover:text-yellow-500 transform group-hover:translate-x-1 transition-all duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
