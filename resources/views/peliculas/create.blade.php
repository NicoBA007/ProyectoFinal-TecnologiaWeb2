<div class="bg-gray-950 border border-white/5 p-8 rounded-[2.5rem] mb-10 shadow-2xl relative overflow-hidden">
    {{-- Acento decorativo superior --}}
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-red-600 to-transparent opacity-40"></div>
    
    <div class="flex items-center gap-4 mb-8">
        <div class="p-3 bg-red-600/10 rounded-2xl border border-red-600/20">
            <span class="text-xl">🎬</span>
        </div>
        <div>
            <h3 class="text-white font-black uppercase tracking-[0.3em] text-[11px]">Registrar Película</h3>
        </div>
    </div>

    <form id="formCrear" onsubmit="guardarData(event)" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
        
        {{-- Título y Clasificación --}}
        <div class="md:col-span-2 space-y-1">
            <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Título de la Pélicula</label>
            <input type="text" id="titulo" placeholder="Ej: INTERSTELLAR" required
                class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-xs font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 transition-all placeholder-gray-800 shadow-inner">
        </div>

        <div class="space-y-1">
            <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Clasificación</label>
            <select id="id_clasificacion" required
                class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-xs font-bold text-white focus:border-red-600 focus:ring-0 cursor-pointer">
                <option value="">SELECCIONAR...</option>
                @foreach($clasificaciones as $c) 
                    <option value="{{ $c->id_clasificacion }}">{{ $c->codigo }}</option> 
                @endforeach
            </select>
        </div>

        <div class="space-y-1">
            <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Duración (Min)</label>
            <input type="number" id="duracion_min" placeholder="000" required
                class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-xs font-bold text-white focus:border-red-600 focus:ring-0 placeholder-gray-800 shadow-inner">
        </div>

        {{-- Fecha, Estado y URLs --}}
        <div class="space-y-1">
            <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Estreno Mundial</label>
            <input type="date" id="fecha_estreno" required
                class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-xs font-bold text-white focus:border-red-600 focus:ring-0 color-scheme-dark shadow-inner">
        </div>

        <div class="space-y-1">
            <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Estado de la Película</label>
            <select id="estado" required 
                class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-[10px] font-black text-white focus:border-red-600 focus:ring-0 uppercase tracking-tighter cursor-pointer">
                <option value="Proximamente">Próximamente</option>
                <option value="En Emision">En Emisión</option>
                <option value="Ya Emitida">Ya Emitida</option>
            </select>
        </div>

        <div class="space-y-1">
            <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">URL del Poster</label>
            <input type="url" id="poster_url" placeholder="https://..." required
                class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-[10px] text-gray-400 focus:border-red-600 focus:ring-0 font-mono shadow-inner">
        </div>

        <div class="space-y-1">
            <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">URL del Trailer</label>
            <input type="url" id="trailer_url" placeholder="https://..."
                class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-[10px] text-gray-400 focus:border-red-600 focus:ring-0 font-mono shadow-inner">
        </div>

        {{-- Sinopsis --}}
        <div class="md:col-span-4 space-y-1">
            <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Sinopsis</label>
            <textarea id="sinopsis" placeholder="Escriba la sinopsis oficial aquí..." required rows="2"
                class="w-full bg-black border-gray-800 rounded-2xl py-3 px-4 text-xs font-medium text-gray-300 focus:border-red-600 focus:ring-0 transition-all placeholder-gray-800 shadow-inner"></textarea>
        </div>

        {{-- Relaciones Muchos a Muchos --}}
        <div class="md:col-span-2 bg-black/40 border border-white/5 p-5 rounded-2xl space-y-3 shadow-inner">
            <label class="text-[9px] text-red-600 uppercase tracking-[0.3em] font-black block">Géneros</label>
            <div class="max-h-32 overflow-y-auto grid grid-cols-2 gap-2 custom-scrollbar pr-2">
                @foreach($generos as $g)
                    <label class="flex items-center space-x-3 p-2 bg-white/[0.01] rounded-lg cursor-pointer hover:bg-white/[0.05] transition-colors border border-transparent hover:border-white/10 group">
                        <input type="checkbox" name="generos[]" value="{{ $g->id_genero }}"
                            class="w-4 h-4 text-red-600 bg-gray-900 border-gray-700 rounded focus:ring-red-600 focus:ring-offset-black">
                        <span class="text-[10px] font-bold text-gray-500 group-hover:text-gray-300 uppercase tracking-tighter">{{ $g->nombre }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="md:col-span-2 bg-black/40 border border-white/5 p-5 rounded-2xl space-y-3 shadow-inner">
            <label class="text-[9px] text-red-600 uppercase tracking-[0.3em] font-black block">Países de Origen (Producción)</label>
            <div class="max-h-32 overflow-y-auto grid grid-cols-2 gap-2 custom-scrollbar pr-2">
                @foreach($paises as $p)
                    <label class="flex items-center space-x-3 p-2 bg-white/[0.01] rounded-lg cursor-pointer hover:bg-white/[0.05] transition-colors border border-transparent hover:border-white/10 group">
                        <input type="checkbox" name="paises[]" value="{{ $p->id_pais_origen }}"
                            class="w-4 h-4 text-red-600 bg-gray-900 border-gray-700 rounded focus:ring-red-600 focus:ring-offset-black">
                        <span class="text-[10px] font-bold text-gray-500 group-hover:text-gray-300 uppercase tracking-tighter">{{ $p->nombre }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="md:col-span-4 mt-2">
            <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-2xl transition-all uppercase tracking-[0.3em] text-[11px] shadow-[0_15px_30px_rgba(220,38,38,0.2)] active:scale-[0.98]">
                Guardar Película
            </button>
        </div>
    </form>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(220,38,38,0.2); border-radius: 10px; }
    .color-scheme-dark { color-scheme: dark; }
</style>