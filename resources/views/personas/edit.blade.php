<div id="modalEditar" 
    class="hidden fixed inset-0 bg-black/90 backdrop-blur-md z-[100] flex items-center justify-center p-4">
    
    <div class="bg-gray-950 border border-red-900/30 p-10 rounded-3xl w-full max-w-lg shadow-[0_0_100px_rgba(220,38,38,0.1)] relative overflow-hidden">
        
        {{-- Línea decorativa superior --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-red-600 to-transparent opacity-60"></div>

        {{-- Encabezado del Modal --}}
        <div class="mb-8 text-center">
            <h3 class="text-white font-black uppercase text-xl tracking-tighter">Modificar <span class="text-red-600">Registro</span></h3>
        </div>

        <form id="formEditar" onsubmit="actualizarData(event)" class="flex flex-col gap-6">
            <input type="hidden" id="edit_id">
            
            {{-- Campo: Nombre --}}
            <div class="space-y-1">
                <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Nombre Completo</label>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-700 group-focus-within:text-red-600 transition-colors text-xs font-mono">ID</span>
                    <input type="text" id="edit_nombre_completo" required 
                        class="w-full bg-black border-gray-800 rounded-xl py-3.5 pl-10 pr-4 text-xs font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 placeholder-gray-800 transition-all">
                </div>
            </div>

            {{-- Campo: URL Foto --}}
            <div class="space-y-1">
                <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">URL de la Fotografía</label>
                <div class="relative group">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-700 group-focus-within:text-red-600 transition-colors text-xs">🔗</span>
                    <input type="url" id="edit_foto_url" required 
                        class="w-full bg-black border-gray-800 rounded-xl py-3.5 pl-10 pr-4 text-xs font-bold text-white focus:border-red-600 focus:ring-0 placeholder-gray-800 transition-all font-mono lowercase">
                </div>
            </div>

            {{-- Botonera --}}
            <div class="flex items-center justify-end gap-3 mt-4 pt-6 border-t border-white/5">
                <button type="button" onclick="cerrarModal()" 
                    class="px-6 py-3 bg-transparent hover:bg-white/5 text-gray-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Cancelar
                </button>
                
                <button type="submit" 
                    class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-red-900/20 transition-all active:scale-95">
                    Actualizar
                </button>
            </div>
        </form>

        {{-- Pie de Modal (Decorativo) --}}
        <div class="mt-8 flex justify-center opacity-20">
            <div class="flex gap-2">
                <div class="w-1 h-1 bg-white rounded-full"></div>
                <div class="w-1 h-1 bg-white rounded-full"></div>
                <div class="w-1 h-1 bg-white rounded-full"></div>
            </div>
        </div>
    </div>
</div>