<div id="modalEditar"
    class="hidden fixed inset-0 bg-black/90 backdrop-blur-md z-[100] flex items-center justify-center p-4">
    
    <div class="bg-gray-950 border border-white/10 p-8 rounded-[2.5rem] w-full max-w-md shadow-[0_0_80px_rgba(0,0,0,1)] relative overflow-hidden">
        
        {{-- Decoración de fondo sutil --}}
        <div class="absolute -top-10 -right-10 opacity-[0.03] pointer-events-none">
            <span class="text-8xl font-black italic">GENRE</span>
        </div>

        {{-- Encabezado del Modal --}}
        <div class="mb-6 border-b border-white/5 pb-4">
            <h3 class="text-white font-black uppercase text-xl tracking-tighter">Modificar <span class="text-red-600">Género</span></h3>
        </div>

        <form id="formEditar" onsubmit="actualizarData(event)" class="flex flex-col gap-5 relative z-10">
            <input type="hidden" id="edit_id">

            <div class="space-y-2">
                <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Género</label>
                <input type="text" id="edit_nombre" required 
                    placeholder="Ej: CIENCIA FICCIÓN"
                    class="w-full bg-black border-gray-800 rounded-xl py-4 px-5 text-sm font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 transition-all shadow-inner placeholder-gray-800">
            </div>

            {{-- Info de Sistema --}}
            <div class="bg-white/[0.02] border border-white/5 p-4 rounded-xl">
                <div class="flex items-center gap-2 text-[8px] font-mono text-gray-600 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                    Relaciones de metadatos activas
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-4">
                <button type="button" onclick="cerrarModal()" 
                    class="px-6 py-3 bg-transparent hover:bg-white/5 text-gray-500 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all">
                    Cancelar
                </button>
                <button type="submit" 
                    class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-red-900/20 transition-all active:scale-95">
                    Actualizar
                </button>
            </div>
        </form>

        {{-- Pie de modal --}}
        <div class="mt-6 text-center">
            <p class="text-[7px] text-gray-800 uppercase tracking-[0.5em] font-bold">PrimeCinemas Asset Management</p>
        </div>
    </div>
</div>