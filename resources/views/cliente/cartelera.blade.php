<x-app-layout>
    {{-- Cabecera de la página --}}
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight tracking-tight uppercase flex items-center gap-2">
            🍿 <span class="text-red-600">En</span> Cartelera
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Encabezado Visual --}}
            <div class="mb-10 text-center">
                <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter mb-4">
                    Descubre tu próxima <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-red-800">película favorita</span>
                </h1>
                <p class="text-gray-500 uppercase tracking-[0.2em] text-sm font-bold">
                    Explora, califica y comparte tu opinión
                </p>
            </div>

            {{-- Cuadrícula de Películas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                
                @forelse ($peliculas as $pelicula)
                    {{-- Tarjeta de Película --}}
                    <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden hover:border-red-500/50 hover:shadow-2xl hover:shadow-red-900/20 transition-all duration-300 group flex flex-col">
                        
                        {{-- Contenedor del Póster --}}
                        <div class="relative aspect-[2/3] overflow-hidden">
                            <img src="{{ $pelicula->poster_url }}" alt="Póster de {{ $pelicula->titulo }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            {{-- Etiqueta de Estado (Emisión/Ya Emitida) --}}
                            <div class="absolute top-4 left-4 bg-black/80 backdrop-blur-sm text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider border border-gray-700">
                                {{ $pelicula->estado }}
                            </div>
                        </div>

                        {{-- Información de la Película --}}
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-xl font-bold text-white mb-2 leading-tight">{{ $pelicula->titulo }}</h3>
                            
                            {{-- Sección de Estrellas y Promedio --}}
                            <div class="flex items-center gap-2 mb-4">
                                <div class="flex text-red-500">
                                    {{-- Lógica simple para mostrar estrellas --}}
                                    @php
                                        // Laravel guarda el promedio en esta variable gracias a withAvg()
                                        $promedio = $pelicula->criticas_avg_puntuacion ?? 0;
                                        $promedioRedondeado = round($promedio);
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $promedioRedondeado)
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @else
                                            <svg class="w-5 h-5 fill-current text-gray-700" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm font-bold text-gray-400">
                                    {{ $promedio > 0 ? number_format($promedio, 1) : 'S/C' }}
                                </span>
                            </div>

                            {{-- Empujamos el botón hacia abajo --}}
                            <div class="mt-auto">
                                <a href="{{ route('cartelera.show', $pelicula->id_pelicula) }}" class="block w-full text-center bg-gray-800 hover:bg-red-600 text-white text-sm font-black py-3 rounded-xl transition-all border border-gray-700 hover:border-red-500 uppercase tracking-widest">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <span class="text-6xl mb-4 block opacity-50">🎞️</span>
                        <h3 class="text-2xl font-bold text-gray-400 uppercase tracking-widest">No hay películas en cartelera</h3>
                        <p class="text-gray-600 mt-2">Vuelve más tarde para descubrir nuevos estrenos.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>