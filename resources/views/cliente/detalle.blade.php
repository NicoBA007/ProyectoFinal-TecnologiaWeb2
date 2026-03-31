<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight tracking-tight uppercase flex items-center gap-2">
            <a href="{{ route('cartelera.index') }}" class="text-gray-500 hover:text-red-500 transition-colors">🍿 Cartelera</a> 
            <span class="text-gray-600">/</span> 
            <span class="text-red-600 truncate">{{ $pelicula->titulo }}</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Contenedor Principal: Poster e Información --}}
            <div class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row mb-12">
                
                {{-- Columna Izquierda: Poster --}}
                <div class="w-full md:w-1/3 lg:w-1/4 relative">
                    <img src="{{ $pelicula->poster_url }}" alt="Póster de {{ $pelicula->titulo }}" class="w-full h-full object-cover">
                    <div class="absolute top-4 left-4 bg-red-600 text-white text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-lg">
                        {{ $pelicula->clasificacion->codigo }}
                    </div>
                </div>

                {{-- Columna Derecha: Detalles --}}
                <div class="w-full md:w-2/3 lg:w-3/4 p-8 md:p-12 flex flex-col justify-center">
                    
                    <div class="flex flex-wrap items-center gap-4 mb-4">
                        <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter">{{ $pelicula->titulo }}</h1>
                        
                        {{-- Promedio de Estrellas General --}}
                        <div class="flex items-center gap-1 bg-gray-800 px-4 py-2 rounded-full border border-gray-700">
                            <span class="text-yellow-500 text-xl">⭐</span>
                            <span class="text-white font-bold text-lg">
                                {{ $pelicula->criticas_avg_puntuacion ? number_format($pelicula->criticas_avg_puntuacion, 1) : 'S/C' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="text-gray-400 text-sm font-bold uppercase tracking-widest border-r border-gray-700 pr-4">{{ $pelicula->fecha_estreno->format('Y') }}</span>
                        <span class="text-gray-400 text-sm font-bold uppercase tracking-widest border-r border-gray-700 pr-4 pl-2">{{ $pelicula->duracion_min }} min</span>
                        <div class="flex gap-2 pl-2">
                            @foreach($pelicula->generos as $genero)
                                <span class="bg-gray-800 text-gray-300 text-[10px] font-black px-2 py-1 rounded-md uppercase tracking-widest">{{ $genero->nombre }}</span>
                            @endforeach
                        </div>
                    </div>

                    <p class="text-gray-300 text-lg leading-relaxed mb-8">
                        {{ $pelicula->sinopsis }}
                    </p>

                    {{-- Elenco y Equipo --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 border-t border-gray-800 pt-8">
                        <div>
                            <h3 class="text-gray-500 font-bold uppercase text-xs tracking-[0.2em] mb-3">Dirección</h3>
                            <div class="flex flex-col gap-2">
                                @foreach($pelicula->personas->where('pivot.rol_en_pelicula', 'Director') as $director)
                                    <span class="text-white font-medium">{{ $director->nombre_completo }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <h3 class="text-gray-500 font-bold uppercase text-xs tracking-[0.2em] mb-3">Reparto Principal</h3>
                            <div class="flex flex-col gap-2">
                                @foreach($pelicula->personas->where('pivot.rol_en_pelicula', 'Actor')->take(4) as $actor)
                                    <div class="flex justify-between items-center border-b border-gray-800/50 pb-1">
                                        <span class="text-white font-medium">{{ $actor->nombre_completo }}</span>
                                        <span class="text-gray-500 text-sm italic">{{ $actor->pivot->papel_personaje }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Sección de Comunidad y Reseñas --}}
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8 md:p-12">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-10 pb-6 border-b border-gray-800">
                    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Reseñas de la <span class="text-red-600">Comunidad</span></h2>
                    
                    {{-- LÓGICA DEL BOTÓN CALIFICAR --}}
                    @guest
                        <div class="text-center sm:text-right mt-4 sm:mt-0">
                            <p class="text-gray-500 text-sm mb-2 font-medium">¿Ya viste esta película?</p>
                            <a href="{{ route('login') }}" class="inline-block bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 rounded-full text-sm font-bold transition-all border border-gray-700 uppercase tracking-widest">
                                Ingresa para calificar
                            </a>
                        </div>
                    @endguest

                    @auth
                        @if(!$yaCalifico)
                            <a href="{{ route('cartelera.calificar', $pelicula->id_pelicula) }}" class="mt-4 sm:mt-0 bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-full font-black transition-all shadow-[0_0_15px_rgba(220,38,38,0.3)] hover:shadow-[0_0_25px_rgba(220,38,38,0.6)] uppercase tracking-widest hover:-translate-y-1">
                                ✍️ Calificar Película
                            </a>
                        @else
                            <div class="mt-4 sm:mt-0 bg-green-500/10 border border-green-500/30 text-green-400 px-6 py-3 rounded-full font-bold uppercase tracking-widest flex items-center gap-2 text-sm">
                                ✅ Ya dejaste tu reseña
                            </div>
                        @endif
                    @endauth
                </div>

                {{-- Lista de Reseñas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($pelicula->criticas as $critica)
                        <div class="bg-black/50 border border-gray-800 p-6 rounded-2xl">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-white font-black border border-gray-700">
                                        {{ substr($critica->usuario->nombres, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-white font-bold">{{ $critica->usuario->nombres }} {{ $critica->usuario->apellido_paterno }}</h4>
                                        <span class="text-gray-500 text-xs uppercase tracking-widest">{{ $critica->fecha_publicacion->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="flex text-red-500 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $critica->puntuacion)
                                            ⭐
                                        @else
                                            <span class="grayscale opacity-30">⭐</span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-400 text-sm italic">
                                "{{ $critica->comentario }}"
                            </p>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <span class="text-4xl mb-4 block opacity-50">😶‍🌫️</span>
                            <h3 class="text-xl font-bold text-gray-500 uppercase tracking-widest">Aún no hay reseñas</h3>
                            <p class="text-gray-600 mt-2 text-sm">Sé el primero en compartir tu opinión sobre esta película.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</x-app-layout>