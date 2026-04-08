<x-app-layout>
    <div class="py-10 max-w-5xl mx-auto sm:px-6 lg:px-8 text-white relative">
        
        {{-- Monitor de Alertas --}}
        <div id="mensajeAlert" class="hidden mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center transition-all border shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-current"></div>
            <span id="textoMensaje" class="relative z-10"></span>
        </div>

        {{-- Formulario de Registro de Géneros --}}
        <div class="mb-10">
            @include('generos.create')
        </div>

        {{-- TABLA DE REGISTRO DE CATEGORÍAS --}}
        <div class="bg-gray-950 border border-white/5 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.6)] overflow-hidden">
            <div class="p-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <span class="text-xl">🏷️</span>
                    <h3 class="text-gray-400 font-black uppercase tracking-[0.3em] text-[10px]">Clasificación por Género</h3>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-[9px] font-mono text-red-600 animate-pulse uppercase tracking-widest">Live Database</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-gray-600 uppercase tracking-[0.2em] text-[9px] bg-white/[0.01]">
                            <th class="py-4 px-6 border-b border-white/5 w-20">ID</th>
                            <th class="py-4 px-6 border-b border-white/5">Estado</th>
                            <th class="py-4 px-6 border-b border-white/5">Categoría / Género</th>
                            <th class="py-4 px-6 border-b border-white/5 text-right">Módulos</th>
                        </tr>
                    </thead>
                    <tbody id="tablaDatos" class="divide-y divide-white/[0.03]">
                        {{-- Inyección vía AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>

        @include('generos.edit')
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        function mostrarMensaje(msg, esExito) {
            const alertBox = document.getElementById('mensajeAlert');
            alertBox.classList.remove('hidden');
            alertBox.className = `mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center border ${esExito ? 'bg-green-600/10 text-green-500 border-green-600/20' : 'bg-red-600/10 text-red-600 border-red-600/20'}`;
            alertBox.innerHTML = `<span class="relative z-10">${msg}</span>`;
            setTimeout(() => alertBox.classList.add('hidden'), 4000);
        }

        async function cargarTabla() {
            const res = await fetch('{{ route('generos.index') }}', { headers: { 'Accept': 'application/json' } });
            const json = await res.json();
            const tbody = document.getElementById('tablaDatos');
            tbody.innerHTML = '';

            json.data.forEach(g => {
                // Formateo de ID como #0001
                const idFormateado = `#${String(g.id_genero).padStart(4, '0')}`;
                
                const estadoHTML = g.activo 
                    ? `<div class="flex items-center gap-2"><div class="w-1 h-1 rounded-full bg-green-500 shadow-[0_0_5px_#22c55e]"></div><span class="text-green-500 text-[9px] font-black uppercase tracking-widest">Activo</span></div>` 
                    : `<div class="flex items-center gap-2"><div class="w-1 h-1 rounded-full bg-red-600"></div><span class="text-red-600 text-[9px] font-black uppercase tracking-widest">Inactivo</span></div>`;

                const btnEditar = `<button onclick="abrirModal(${g.id_genero}, '${g.nombre}')" class="text-gray-400 hover:text-white font-black text-[9px] uppercase tracking-widest mr-4 transition-colors">Editar</button>`;
                
                const btnEstado = g.activo
                    ? `<button onclick="cambiarEstado(${g.id_genero}, 'destroy', 'DELETE')" class="text-red-900 hover:text-red-500 font-black text-[9px] uppercase tracking-widest transition-colors">Baja</button>`
                    : `<button onclick="cambiarEstado(${g.id_genero}, 'reactivar', 'PATCH')" class="text-green-900 hover:text-green-500 font-black text-[9px] uppercase tracking-widest transition-colors">Alta</button>`;

                tbody.innerHTML += `
                    <tr class="hover:bg-white/[0.02] transition-all duration-300 ${!g.activo ? 'opacity-40' : ''}">
                        <td class="py-4 px-6 font-mono text-[10px] text-gray-600">${idFormateado}</td>
                        <td class="py-4 px-6">${estadoHTML}</td>
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <span class="font-black text-white text-xs uppercase tracking-tight">${g.nombre}</span>
                                <span class="text-[8px] text-gray-700 uppercase font-bold tracking-[0.1em] mt-0.5">Genre Asset</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-right">${btnEditar} ${btnEstado}</td>
                    </tr>`;
            });
        }

        async function guardarData(e) {
            e.preventDefault();
            const res = await fetch('{{ route('generos.store') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ nombre: document.getElementById('nombre').value })
            });
            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) { document.getElementById('formCrear').reset(); cargarTabla(); }
        }

        function abrirModal(id, nombre) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('modalEditar').classList.remove('hidden');
        }

        function cerrarModal() { document.getElementById('modalEditar').classList.add('hidden'); }

        async function actualizarData(e) {
            e.preventDefault();
            const id = document.getElementById('edit_id').value;
            const url = '{{ route("generos.update", ":id") }}'.replace(':id', id);
            const res = await fetch(url, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ nombre: document.getElementById('edit_nombre').value })
            });
            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) { cerrarModal(); cargarTabla(); }
        }

        async function cambiarEstado(id, accion, metodo) {
            const url = `/generos/${id}/${accion === 'destroy' ? '' : 'reactivar'}`;
            const res = await fetch(url, { method: metodo, headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken } });
            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) cargarTabla();
        }

        document.addEventListener('DOMContentLoaded', cargarTabla);
    </script>
</x-app-layout>