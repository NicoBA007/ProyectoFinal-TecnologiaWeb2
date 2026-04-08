<x-app-layout>
    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8 text-white relative">
        
        {{-- Monitor de Alertas --}}
        <div id="mensajeAlert" class="hidden mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center transition-all border shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-current"></div>
            <span id="textoMensaje" class="relative z-10"></span>
        </div>

        {{-- Encabezado de Sección (Estilo PrimeCinemas) --}}
        <div class="mb-8 flex items-center gap-4">
            <div class="h-12 w-1 bg-red-600 shadow-[0_0_15px_rgba(220,38,38,0.5)]"></div>
            <div>
                <h2 class="text-2xl font-black uppercase tracking-tighter italic">Panel de <span class="text-red-600 text-3xl">Moderación</span></h2>
                <p class="text-[9px] text-gray-500 uppercase tracking-[0.4em] font-bold">User Feedback & Ratings System</p>
            </div>
        </div>

        {{-- TABLA DE CRÍTICAS --}}
        <div class="bg-gray-950 border border-white/5 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.6)] overflow-hidden">
            <div class="p-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <span class="text-xl">📊</span>
                    <h3 class="text-gray-400 font-black uppercase tracking-[0.3em] text-[10px]">Registro Histórico de Críticas</h3>
                </div>
                <div class="flex items-center gap-4 text-[9px] font-mono text-gray-700 uppercase tracking-widest italic">
                    <span>Verified Reviews</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-gray-600 uppercase tracking-[0.2em] text-[9px] bg-white/[0.01]">
                            <th class="py-4 px-6 border-b border-white/5">Fecha</th>
                            <th class="py-4 px-6 border-b border-white/5">Usuario</th>
                            <th class="py-4 px-6 border-b border-white/5">Película</th>
                            <th class="py-4 px-6 border-b border-white/5">Puntuación</th>
                            <th class="py-4 px-6 border-b border-white/5 w-1/3">Comentario</th>
                            <th class="py-4 px-6 border-b border-white/5 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tablaDatos" class="divide-y divide-white/[0.03]">
                        {{-- Inyección vía AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        function mostrarMensaje(msg, esExito) {
            const alertBox = document.getElementById('mensajeAlert');
            alertBox.textContent = msg;
            alertBox.className = `mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center border ${esExito ? 'bg-green-600/10 text-green-500 border-green-600/20' : 'bg-red-600/10 text-red-600 border-red-600/20'}`;
            alertBox.classList.remove('hidden');
            setTimeout(() => alertBox.classList.add('hidden'), 4000);
        }

        // Función para dibujar las estrellas (Mantiene tu lógica de colores)
        function renderEstrellas(puntos) {
            let estrellas = '';
            for(let i = 1; i <= 5; i++) {
                estrellas += i <= puntos 
                    ? '<span class="text-yellow-500">★</span>' 
                    : '<span class="text-gray-800">★</span>';
            }
            return estrellas;
        }

        async function cargarTabla() {
            const res = await fetch('{{ route('criticas.index') }}', { headers: { 'Accept': 'application/json' } });
            const json = await res.json();
            const tbody = document.getElementById('tablaDatos');
            tbody.innerHTML = '';

            json.data.forEach(item => {
                const btnEliminar = `<button onclick="eliminarCritica(${item.id_critica})" class="text-red-900 hover:text-red-500 font-black text-[9px] uppercase tracking-widest transition-colors">Borrar</button>`;

                tbody.innerHTML += `
                    <tr class="hover:bg-white/[0.02] transition-all duration-300">
                        <td class="py-4 px-6 text-gray-500 text-[10px] font-mono italic uppercase">${item.fecha_publicacion}</td>
                        <td class="py-4 px-6">
                            <span class="font-black text-blue-400 text-[11px] uppercase tracking-tighter">${item.usuario}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-gray-300 font-bold text-[11px] uppercase">${item.pelicula}</span>
                        </td>
                        <td class="py-4 px-6 text-base tracking-widest">${renderEstrellas(item.puntuacion)}</td>
                        <td class="py-4 px-6 max-w-xs truncate text-gray-500 italic text-[10px]" title="${item.comentario}">
                            "${item.comentario || 'Sin comentario'}"
                        </td>
                        <td class="py-4 px-6 text-right">${btnEliminar}</td>
                    </tr>`;
            });
        }

        async function eliminarCritica(id) {
            if(!confirm("¿Estás seguro de que deseas eliminar esta crítica PERMANENTEMENTE?")) return;

            const url = `/criticas/${id}`;
            const res = await fetch(url, { 
                method: 'DELETE', 
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) cargarTabla();
        }

        document.addEventListener('DOMContentLoaded', cargarTabla);
    </script>
</x-app-layout>