<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-white leading-tight tracking-tight uppercase flex items-center gap-2">
            <a href="{{ route('cartelera.show', $pelicula->id_pelicula) }}" class="text-gray-500 hover:text-red-500 transition-colors">⬅️ Volver a {{ $pelicula->titulo }}</a>
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl p-8 md:p-12 relative">
                
                {{-- Adorno visual --}}
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-900 via-red-600 to-red-900"></div>

                <div class="text-center mb-10">
                    <span class="text-5xl mb-4 block">🍿</span>
                    <h1 class="text-3xl font-black text-white uppercase tracking-tighter mb-2">Tu opinión importa</h1>
                    <p class="text-gray-500 font-bold tracking-widest uppercase text-sm">
                        Estás calificando: <span class="text-red-500">{{ $pelicula->titulo }}</span>
                    </p>
                </div>

                {{-- EL FORMULARIO FUNCIONAL --}}
                <form action="{{ route('cartelera.guardar_critica', $pelicula->id_pelicula) }}" method="POST" class="space-y-8">
                    @csrf {{-- Token de seguridad obligatorio en Laravel --}}

                    {{-- 1. Selector de Estrellas interactivo con Alpine.js --}}
                    <div class="flex flex-col items-center">
                        <label class="block text-gray-400 font-bold mb-4 uppercase tracking-widest text-sm">¿Cuántas estrellas le das?</label>
                        
                        {{-- Componente Alpine.js para las estrellas --}}
                        <div x-data="{ rating: 0, hover: 0 }" class="flex items-center gap-2">
                            {{-- Input oculto que Laravel recibirá --}}
                            <input type="hidden" name="puntuacion" x-model="rating" required>
                            
                            <template x-for="star in 5">
                                <button type="button"
                                    @click="rating = star"
                                    @mouseenter="hover = star"
                                    @mouseleave="hover = 0"
                                    class="focus:outline-none transition-transform hover:scale-125"
                                >
                                    <svg class="w-12 h-12 transition-colors duration-200" 
                                         :class="(hover || rating) >= star ? 'text-yellow-500' : 'text-gray-800'" 
                                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </button>
                            </template>
                        </div>
                        
                        {{-- Mensaje de error si intenta enviar sin seleccionar estrellas --}}
                        @error('puntuacion')
                            <p class="mt-2 text-red-500 text-xs font-bold uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 2. Área de Reseña Escrita --}}
                    <div>
                        <label for="comentario" class="block text-gray-400 font-bold mb-2 uppercase tracking-widest text-sm text-center">Escribe tu reseña (Opcional)</label>
                        <textarea id="comentario" name="comentario" rows="4" 
                            class="w-full bg-black border border-gray-800 rounded-xl p-4 text-white focus:ring-2 focus:ring-red-600 focus:border-red-600 transition-all placeholder-gray-700 resize-none"
                            placeholder="¿Qué te pareció la dirección? ¿Las actuaciones? Cuéntale a la comunidad..."></textarea>
                        
                        @error('comentario')
                            <p class="mt-2 text-red-500 text-xs font-bold uppercase">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 3. Botones de Acción --}}
                    <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-800">
                        <a href="{{ route('cartelera.show', $pelicula->id_pelicula) }}" class="w-full sm:w-1/3 text-center bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded-xl transition-colors uppercase tracking-widest text-sm border border-gray-700">
                            Cancelar
                        </a>
                        <button type="submit" class="w-full sm:w-2/3 bg-red-600 hover:bg-red-700 text-white font-black py-3 px-4 rounded-xl transition-all uppercase tracking-widest shadow-[0_0_15px_rgba(220,38,38,0.3)] hover:shadow-[0_0_25px_rgba(220,38,38,0.6)]">
                            Publicar Reseña
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>