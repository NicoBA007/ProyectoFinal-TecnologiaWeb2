<div class="bg-gray-950 border border-white/5 p-8 rounded-[2.5rem] mb-10 shadow-2xl relative overflow-hidden group">
    {{-- Efecto de luz ambiental en la esquina --}}
    <div class="absolute -top-24 -left-24 w-48 h-48 bg-red-600/5 rounded-full blur-[80px] group-hover:bg-red-600/10 transition-all duration-700"></div>

    <div class="flex items-center justify-between mb-6 relative z-10">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-red-600/10 border border-red-600/20 rounded-xl flex items-center justify-center text-lg shadow-inner">
                🔞
            </div>
            <div>
                <h3 class="text-white font-black uppercase tracking-[0.3em] text-[11px]">Registro de Clasificaciones</h3>
            </div>
        </div>
        <div class="hidden md:block text-right">
            <span class="text-[7px] font-mono text-gray-800 uppercase tracking-[0.4em]">Status: Authorized Access</span>
        </div>
    </div>

    <form id="formCrear" onsubmit="guardarData(event)" class="flex flex-col lg:flex-row gap-4 items-stretch relative z-10">
        {{-- Input Código --}}
        <div class="w-full lg:w-1/4 relative group/input">
            <label class="absolute -top-2 left-4 px-2 bg-gray-950 text-[8px] font-black text-gray-600 uppercase tracking-[0.2em] z-10 group-focus-within/input:text-red-600 transition-colors">
                Código
            </label>
            <input type="text" id="codigo" placeholder="EJ: PG-13" required 
                class="w-full bg-black border-gray-800 rounded-2xl py-4 px-6 text-sm font-black uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 transition-all placeholder-gray-900 shadow-inner">
        </div>

        {{-- Input Descripción --}}
        <div class="flex-1 relative group/input">
            <label class="absolute -top-2 left-4 px-2 bg-gray-950 text-[8px] font-black text-gray-600 uppercase tracking-[0.2em] z-10 group-focus-within/input:text-red-600 transition-colors">
                Descripción Detallada
            </label>
            <input type="text" id="descripcion" placeholder="EJ: MAYORES DE 13 AÑOS..." required 
                class="w-full bg-black border-gray-800 rounded-2xl py-4 px-6 text-sm font-bold uppercase tracking-widest text-gray-300 focus:border-red-600 focus:ring-0 transition-all placeholder-gray-900 shadow-inner">
        </div>

        <button type="submit" 
            class="bg-red-600 hover:bg-red-700 text-white font-black px-10 py-4 rounded-2xl transition-all uppercase tracking-[0.3em] text-[11px] shadow-[0_10px_30px_rgba(220,38,38,0.2)] active:scale-95 flex items-center justify-center">
            Guardar
        </button>
    </form>
    
    {{-- Decoración técnica inferior --}}
    <div class="mt-6 flex items-center gap-2 opacity-20">
        <div class="h-[1px] flex-1 bg-gradient-to-r from-transparent to-gray-800"></div>
        <div class="text-[7px] font-mono text-gray-500 uppercase tracking-[0.5em]">Content Regulation Protocol</div>
        <div class="h-[1px] flex-1 bg-gradient-to-l from-transparent to-gray-800"></div>
    </div>
</div>