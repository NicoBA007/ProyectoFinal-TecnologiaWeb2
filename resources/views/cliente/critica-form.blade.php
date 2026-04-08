<template x-teleport="body">
    <div x-show="modalCalificar" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>

        {{-- Overlay --}}
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" x-show="modalCalificar"
            x-transition.opacity @click="modalCalificar = false"></div>

        {{-- Modal Card --}}
        <div class="relative bg-zinc-950 border border-white/10 w-full max-w-2xl rounded-[32px] overflow-hidden shadow-2xl"
            x-show="modalCalificar" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-8"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0">

            <div class="flex flex-col md:flex-row">

                {{-- LADO IZQUIERDO: PÓSTER SIN CORTES --}}
                <div
                    class="hidden md:flex md:w-1/3 relative bg-zinc-900 items-center justify-center border-r border-white/5">
                    <img src="{{ $pelicula['poster_url'] }}" alt="{{ $pelicula['titulo'] }}"
                        class="h-full w-full object-contain p-4 transition-transform duration-500 hover:scale-105">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-zinc-950/50 via-transparent to-transparent pointer-events-none">
                    </div>
                </div>

                {{-- LADO DERECHO: FORMULARIO --}}
                <div class="flex-1 p-8 md:p-10 relative bg-gradient-to-br from-zinc-900 to-black"
                    x-data="{
                        rating: 0,
                        displayValue: '0',
                        {{-- Función para manejar la entrada de texto (acepta comas y puntos) --}}
                        updateFromInput(val) {
                            let normalized = val.replace(',', '.');
                            let n = parseFloat(normalized);

                            if (!isNaN(n)) {
                                this.rating = Math.max(0, Math.min(5, n));
                                this.displayValue = val;
                            } else if (val === '') {
                                this.rating = 0;
                                this.displayValue = '';
                            }
                        },
                        {{-- Sincroniza el texto cuando se usa el deslizador --}}
                        syncDisplay() {
                            this.displayValue = this.rating.toString().replace('.', ',');
                        },
                        {{-- Calcula el llenado visual de cada estrella --}}
                        calculateWidth(starNumber) {
                            let diff = this.rating - (starNumber - 1);
                            if (diff >= 1) return '100%';
                            if (diff <= 0) return '0%';
                            return (diff * 100) + '%';
                        }
                    }">

                    {{-- Botón cerrar --}}
                    <button @click="modalCalificar = false" type="button"
                        class="absolute top-5 right-5 text-zinc-500 hover:text-white transition-colors z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="text-center md:text-left mb-6">
                        <h1 class="text-2xl font-black text-white uppercase tracking-tighter italic leading-none">Tu
                            Reseña</h1>
                        <p class="text-zinc-500 font-bold tracking-widest uppercase text-[9px] mt-2">
                            Calificando: <span class="text-red-500">{{ $pelicula['titulo'] }}</span>
                        </p>
                    </div>

                    <form action="{{ route('cartelera.guardar_critica', $pelicula['id_pelicula']) }}" method="POST"
                        class="space-y-6">
                        @csrf

                        {{-- SECCIÓN DE CALIFICACIÓN --}}
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label
                                    class="text-zinc-500 font-black uppercase tracking-[0.2em] text-[9px]">Puntuación</label>
                                <div class="flex items-center gap-2">
                                    {{-- Input visual (Texto para permitir comas) --}}
                                    <input type="text" x-model="displayValue"
                                        @input="updateFromInput($event.target.value)"
                                        class="w-16 bg-white/5 border border-white/10 rounded-lg py-1 text-center text-yellow-500 font-black text-lg focus:ring-1 focus:ring-red-600 outline-none transition-all"
                                        placeholder="0,0">

                                    {{-- INPUT OCULTO QUE SE ENVÍA A LA DB (Siempre con punto para el servidor) --}}
                                    <input type="hidden" name="puntuacion" :value="rating">
                                    <span class="text-zinc-700 font-bold text-xs">/ 5.0</span>
                                </div>
                            </div>

                            {{-- Estrellas Visuales --}}
                            <div class="flex items-center justify-between px-2">
                                <template x-for="i in 5">
                                    <div class="relative">
                                        {{-- Fondo gris --}}
                                        <svg class="w-10 h-10 text-zinc-800" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                        </svg>
                                        {{-- Capa amarilla dinámica --}}
                                        <div class="absolute inset-0 overflow-hidden pointer-events-none transition-all duration-150"
                                            :style="'width: ' + calculateWidth(i)">
                                            <svg class="w-10 h-10 text-yellow-500 drop-shadow-[0_0_8px_rgba(234,179,8,0.4)]"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                            </svg>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            {{-- Deslizador (Slider) Estilo Volumen con Puro Tailwind --}}
                            <div class="relative flex items-center pt-2">
                                <input type="range" min="0" max="5" step="0.1" x-model="rating"
                                    @input="syncDisplay()"
                                    class="w-full h-1.5 bg-zinc-800 rounded-lg appearance-none cursor-pointer
                                              [&::-webkit-slider-thumb]:appearance-none
                                              [&::-webkit-slider-thumb]:w-5
                                              [&::-webkit-slider-thumb]:h-5
                                              [&::-webkit-slider-thumb]:rounded-full
                                              [&::-webkit-slider-thumb]:bg-red-600
                                              [&::-webkit-slider-thumb]:border-2
                                              [&::-webkit-slider-thumb]:border-zinc-900
                                              [&::-moz-range-thumb]:w-5
                                              [&::-moz-range-thumb]:h-5
                                              [&::-moz-range-thumb]:bg-red-600
                                              [&::-moz-range-thumb]:border-none">
                            </div>
                        </div>

                        {{-- Campo Comentario --}}
                        <div class="space-y-2">
                            <textarea name="comentario" rows="3" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white focus:ring-2 focus:ring-red-600 focus:outline-none transition-all placeholder-zinc-700 resize-none text-sm"
                                placeholder="Comparte qué te pareció la película..."></textarea>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button type="submit"
                                class="order-1 sm:order-2 flex-[2] bg-red-600 hover:bg-red-500 text-white font-black py-4 rounded-xl transition-all uppercase tracking-[0.2em] text-[10px] shadow-lg shadow-red-900/40 active:scale-95">
                                Publicar Reseña
                            </button>
                            <button type="button" @click="modalCalificar = false"
                                class="order-2 sm:order-1 flex-1 bg-zinc-800 hover:bg-zinc-700 text-zinc-400 font-bold py-4 rounded-xl transition-all uppercase tracking-widest text-[10px]">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
