<div class="bg-gray-950 border border-white/5 p-8 rounded-3xl mb-10 shadow-2xl relative overflow-hidden">
    {{-- Acento lateral de identidad --}}
    <div class="absolute top-0 left-0 w-1 h-full bg-red-600"></div>
    
    <div class="flex items-center gap-3 mb-6">
        <div class="p-2 bg-red-600/10 rounded-lg">
            <span class="text-lg">👤</span>
        </div>
        <div>
            <h3 class="text-white font-black uppercase tracking-[0.3em] text-[10px]">Añadir Artista</h3>
        </div>
    </div>

    <form id="formCrear" onsubmit="guardarData(event)" class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">
        
        {{-- Campo: Nombre Completo --}}
        <div class="md:col-span-2 space-y-1">
            <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">Nombre Completo</label>
            <div class="relative group">
                <input type="text" id="nombre_completo" placeholder="  EJ: CHRISTOPHER NOLAN" required 
                    class="w-full bg-black border-gray-800 rounded-xl py-3 text-[11px] font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 placeholder-gray-800 transition-all shadow-inner">
            </div>
        </div>

        {{-- Campo: URL de Imagen --}}
        <div class="md:col-span-2 space-y-1">
            <label class="text-[9px] uppercase tracking-[0.2em] text-gray-500 font-black ml-1">URL de la Fotografía</label>
            <div class="relative group">
                <input type="url" id="foto_url" placeholder="  https://media.primecinemas.com/talent/asset.jpg" required 
                    class="w-full bg-black border-gray-800 rounded-xl py-3 text-[11px] font-bold text-white focus:border-red-600 focus:ring-0 placeholder-gray-800 transition-all font-mono shadow-inner">
            </div>
        </div>

        {{-- Botón de Ejecución --}}
        <div class="md:col-span-1">
            <button type="submit" 
                class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-3.5 rounded-xl transition-all uppercase tracking-[0.2em] text-[10px] shadow-[0_10px_20px_rgba(220,38,38,0.2)] active:scale-95 group">
                <span class="group-hover:scale-110 transition-transform inline-block">Guardar</span>
            </button>
        </div>
    </form>

    {{-- Decoración técnica de fondo --}}
    <div class="absolute -right-4 -bottom-4 opacity-[0.02] pointer-events-none select-none">
        <span class="text-8xl font-black italic">PRIME</span>
    </div>
</div>