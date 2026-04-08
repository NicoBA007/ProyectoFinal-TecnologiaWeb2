<div id="modalEditar"
    class="hidden fixed inset-0 bg-black/90 backdrop-blur-md z-[100] flex items-center justify-center p-4">
    
    <div class="bg-gray-950 border border-white/10 p-8 rounded-[2.5rem] w-full max-w-4xl shadow-[0_0_80px_rgba(0,0,0,1)] relative overflow-hidden max-h-[95vh] flex flex-col">
        
        {{-- Header del Modal --}}
        <div class="mb-6 flex justify-between items-center border-b border-white/5 pb-4">
            <div>
                <h3 class="text-white font-black uppercase text-xl tracking-tighter">Editar <span class="text-red-600">Película</span></h3>
            </div>
            <button onclick="cerrarModal()" class="text-gray-500 hover:text-white transition-colors text-2xl">&times;</button>
        </div>

        <form id="formEditar" onsubmit="actualizarData(event)" class="overflow-y-auto pr-2 custom-scrollbar">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <input type="hidden" id="edit_id">

                {{-- Título --}}
                <div class="md:col-span-2 space-y-1">
                    <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Título Original</label>
                    <input type="text" id="edit_titulo" required
                        class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-xs font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 transition-all">
                </div>

                {{-- Clasificación y Duración --}}
                <div class="space-y-1">
                    <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Rating</label>
                    <select id="edit_id_clasificacion" required
                        class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-xs font-bold text-white focus:border-red-600 focus:ring-0">
                        @foreach($clasificaciones as $c) 
                            <option value="{{ $c->id_clasificacion }}">{{ $c->codigo }} ({{ $c->nombre }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Duración (Minutos)</label>
                    <input type="number" id="edit_duracion_min" required
                        class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-xs font-bold text-white focus:border-red-600 focus:ring-0">
                </div>

                {{-- Fecha y Estado --}}
                <div class="space-y-1">
                    <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Fecha de Lanzamiento</label>
                    <input type="date" id="edit_fecha_estreno" required
                        class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-xs font-bold text-white focus:border-red-600 focus:ring-0 color-scheme-dark">
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Estado de Distribución</label>
                    <select id="edit_estado" required
                        class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-xs font-bold text-white focus:border-red-600 focus:ring-0 font-black uppercase">
                        <option value="Proximamente">Próximamente</option>
                        <option value="En Emision">En Emisión</option>
                        <option value="Ya Emitida">Ya Emitida</option>
                    </select>
                </div>

                {{-- URLs --}}
                <div class="space-y-1">
                    <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Poster URL (JPG/PNG)</label>
                    <input type="url" id="edit_poster_url" required
                        class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-[10px] text-gray-400 focus:border-red-600 focus:ring-0 font-mono">
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Trailer URL (YouTube/MP4)</label>
                    <input type="url" id="edit_trailer_url"
                        class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-[10px] text-gray-400 focus:border-red-600 focus:ring-0 font-mono">
                </div>

                {{-- Sinopsis --}}
                <div class="md:col-span-2 space-y-1">
                    <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Resumen Argumental (Sinopsis)</label>
                    <textarea id="edit_sinopsis" required rows="3"
                        class="w-full bg-black border-gray-800 rounded-xl py-3 px-4 text-xs font-medium text-gray-300 focus:border-red-600 focus:ring-0 transition-all"></textarea>
                </div>

                {{-- Selectores de Muchos a Muchos (Géneros y Países) --}}
                <div class="bg-black/40 border border-white/5 p-5 rounded-2xl space-y-3 shadow-inner">
                    <label class="text-[9px] text-red-600 uppercase tracking-[0.3em] font-black block">Géneros</label>
                    <div class="max-h-40 overflow-y-auto grid grid-cols-2 gap-2 custom-scrollbar pr-2">
                        @foreach($generos as $g)
                            <label class="flex items-center space-x-3 p-2 bg-white/[0.02] rounded-lg cursor-pointer hover:bg-white/[0.05] transition-colors border border-transparent hover:border-white/10">
                                <input type="checkbox" name="edit_generos[]" value="{{ $g->id_genero }}"
                                    class="w-4 h-4 text-red-600 bg-gray-900 border-gray-700 rounded focus:ring-red-600 focus:ring-offset-black chk-edit-genero">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $g->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="bg-black/40 border border-white/5 p-5 rounded-2xl space-y-3 shadow-inner">
                    <label class="text-[9px] text-red-600 uppercase tracking-[0.3em] font-black block">Países de Origen</label>
                    <div class="max-h-40 overflow-y-auto grid grid-cols-2 gap-2 custom-scrollbar pr-2">
                        @foreach($paises as $p)
                            <label class="flex items-center space-x-3 p-2 bg-white/[0.02] rounded-lg cursor-pointer hover:bg-white/[0.05] transition-colors border border-transparent hover:border-white/10">
                                <input type="checkbox" name="edit_paises[]" value="{{ $p->id_pais_origen }}"
                                    class="w-4 h-4 text-red-600 bg-gray-900 border-gray-700 rounded focus:ring-red-600 focus:ring-offset-black chk-edit-pais">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $p->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Footer / Botones --}}
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-white/5">
                <button type="button" onclick="cerrarModal()"
                    class="px-8 py-3 bg-transparent hover:bg-white/5 text-gray-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-10 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-red-900/20 transition-all active:scale-95">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Estilo para el scrollbar interno del modal */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(220,38,38,0.3); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(220,38,38,0.5); }
    .color-scheme-dark { color-scheme: dark; }
</style>