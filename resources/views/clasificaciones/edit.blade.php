<div id="modalEditar"
    class="hidden fixed inset-0 bg-black/90 backdrop-blur-md z-[100] flex items-center justify-center p-4">
    
    <div class="bg-gray-950 border border-white/10 p-8 rounded-[2.5rem] w-full max-w-md shadow-[0_0_80px_rgba(0,0,0,1)] relative overflow-hidden">
        
        {{-- Decoración de fondo sutil --}}
        <div class="absolute -top-10 -right-10 opacity-[0.03] pointer-events-none text-right">
            <span class="text-7xl font-black italic block">RATE</span>
            <span class="text-4xl font-black italic block uppercase">Class</span>
        </div>

        {{-- Encabezado del Modal --}}
        <div class="mb-6 border-b border-white/5 pb-4">
            <h3 class="text-white font-black uppercase text-xl tracking-tighter">Editar <span class="text-red-600">Clasificación</span></h3>
        </div>

        <form id="formEditar" onsubmit="actualizarData(event)" class="flex flex-col gap-5 relative z-10">
            <input type="hidden" id="edit_id">

            {{-- Campo Código --}}
            <div class="space-y-1 relative group/input">
                <label class="text-[9px] uppercase tracking-[0.2em] text-gray-600 font-black ml-1 group-focus-within/input:text-red-600 transition-colors">Código de Restricción</label>
                <input type="text" id="edit_codigo" required 
                    placeholder="Ej: PG-13"
                    class="w-full bg-black border-gray-800 rounded-xl py-3 px-5 text-sm font-black uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 transition-all shadow-inner placeholder-gray-900">
            </div>

            {{-- Campo Descripción --}}
            <div class="space-y-1 relative group/input">
                <label class="text-[9px] uppercase tracking-[0.2em] text-gray-600 font-black ml-1 group-focus-within/input:text-red-600 transition-colors">Descripción del Público</label>
                <input type="text" id="edit_descripcion" required 
                    placeholder="Ej: MAYORES DE 13 AÑOS"
                    class="w-full bg-black border-gray-800 rounded-xl py-3 px-5 text-sm font-bold uppercase tracking-tight text-gray-300 focus:border-red-600 focus:ring-0 transition-all shadow-inner placeholder-gray-900">
            </div>

            {{-- Panel de Status --}}
            <div class="bg-white/[0.02] border border-white/5 p-4 rounded-xl">
                <div class="flex items-center gap-2 text-[8px] font-mono text-gray-600 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse shadow-[0_0_5px_rgba(220,38,38,0.5)]"></span>
                    Edit mode active: System lockdown
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
            <p class="text-[7px] text-gray-800 uppercase tracking-[0.5em] font-bold">PrimeCinemas Regulation Unit</p>
        </div>
    </div>
</div>