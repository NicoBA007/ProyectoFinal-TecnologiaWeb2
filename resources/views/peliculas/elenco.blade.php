<div id="modalElenco"
    class="hidden fixed inset-0 bg-black/95 backdrop-blur-md z-[100] flex items-center justify-center p-4">

    <div
        class="bg-gray-950 border border-white/10 p-8 rounded-[2rem] w-full max-w-5xl shadow-[0_0_100px_rgba(0,0,0,1)] flex flex-col max-h-[90vh] relative overflow-hidden">

        {{-- Decoración de Fondo --}}
        <div class="absolute top-0 right-0 p-10 opacity-[0.02] pointer-events-none">
            <span class="text-9xl font-black italic">CAST</span>
        </div>

        {{-- Encabezado --}}
        <div class="flex justify-between items-center mb-8 border-b border-white/5 pb-6">
            <div>
                <p class="text-[9px] font-black text-red-600 uppercase tracking-[0.4em] mb-1">Equipo de Producción y
                    Reparto</p>
                <h3 class="text-white font-black uppercase text-2xl tracking-tighter">
                    Elenco: <span id="elenco_titulo_pelicula" class="text-gray-400"></span>
                </h3>
            </div>
            <button onclick="cerrarModalElenco()"
                class="w-10 h-10 flex items-center justify-center rounded-full bg-white/5 hover:bg-red-600 text-white transition-all group">
                <span class="text-2xl group-hover:rotate-90 transition-transform">&times;</span>
            </button>
        </div>

        {{-- Formulario de Asignación --}}
        <div class="bg-white/[0.02] p-6 rounded-2xl border border-white/5 mb-8 shadow-inner relative z-10">
            <form id="formAgregarElenco" onsubmit="guardarElenco(event)"
                class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                {{-- Campo oculto para el ID de la película --}}
                <input type="hidden" id="elenco_id_pelicula">

                <div class="md:col-span-1 space-y-1">
                    <label class="text-[9px] text-gray-500 uppercase tracking-[0.2em] font-black ml-1">Seleccionar
                        Miembros</label>
                    <select id="elenco_id_persona" required
                        class="w-full bg-black border-gray-800 rounded-xl text-xs font-bold text-white focus:border-red-600 focus:ring-0 py-3 cursor-pointer">
                    </select>
                </div>

                <div class="md:col-span-1 space-y-1">
                    <label class="text-[9px] text-gray-500 uppercase tracking-[0.2em] font-black ml-1">Rol</label>
                    <select id="elenco_rol" required
                        class="w-full bg-black border-gray-800 rounded-xl text-xs font-bold text-white focus:border-red-600 focus:ring-0 py-3 cursor-pointer">
                        <option value="actor">Actor / Actriz</option>
                        <option value="director">Director</option>
                    </select>
                </div>

                <div class="md:col-span-1 space-y-1">
                    <label class="text-[9px] text-gray-500 uppercase tracking-[0.2em] font-black ml-1">Nombre del
                        Personaje</label>
                    <input type="text" id="elenco_personaje" placeholder="Opcional"
                        class="w-full bg-black border-gray-800 rounded-xl text-xs font-bold text-white focus:border-red-600 focus:ring-0 py-3 placeholder-gray-800">
                </div>

                <div class="md:col-span-1">
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-3.5 rounded-xl transition-all uppercase tracking-widest text-[10px] shadow-lg shadow-red-900/20 active:scale-95">
                        Añadir
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabla de Elenco Actual --}}
        <div class="overflow-y-auto flex-1 border border-white/5 rounded-2xl bg-black/20">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="sticky top-0 bg-gray-950 z-10">
                    <tr class="text-gray-600 uppercase tracking-[0.2em] text-[9px] border-b border-white/5">
                        <th class="py-4 px-6">Miembros</th>
                        <th class="py-4 px-6">Rol en la Película</th>
                        <th class="py-4 px-6">Personaje</th>
                        <th class="py-4 px-6 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody id="tablaElenco" class="divide-y divide-white/[0.02]">
                    {{-- Inyección dinámica AJAX --}}
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-center">
            <p class="text-[8px] text-gray-700 uppercase tracking-[0.5em] font-bold">PrimeCinemas Internal Assets
                Management</p>
        </div>
    </div>
</div>
