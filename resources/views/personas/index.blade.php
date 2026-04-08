<x-admin-layout>
    {{-- El header se omite para mantener la limpieza, la jerarquía la da el título interno --}}

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8 text-white relative">
        
        {{-- Alerta de Mensajes Consola --}}
        <div id="mensajeAlert" class="hidden mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center transition-all border shadow-2xl overflow-hidden relative">
            <div class="absolute inset-0 opacity-10 bg-current"></div>
            <span id="textoMensaje" class="relative z-10"></span>
        </div>

        <div class="mb-10">
            @include('personas.create')
        </div>

        {{-- TABLA DE REGISTRO DE TALENTO --}}
        <div class="bg-gray-950 border border-white/5 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden">
            <div class="p-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <span class="text-xl">🎭</span>
                    <h3 class="text-gray-400 font-black uppercase tracking-[0.3em] text-[10px]">Registro de Producción</h3>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-gray-600 uppercase tracking-[0.2em] text-[9px] bg-white/[0.01]">
                            <th class="py-4 px-6 border-b border-white/5 w-16">ID</th>
                            <th class="py-4 px-6 border-b border-white/5 w-20">Perfil</th>
                            <th class="py-4 px-6 border-b border-white/5">Estado</th>
                            <th class="py-4 px-6 border-b border-white/5">Nombre Completo</th>
                            <th class="py-4 px-6 border-b border-white/5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaDatos" class="divide-y divide-white/[0.03]">
                        {{-- Se llena vía AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal de Edición --}}
        @include('personas.edit')
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        function mostrarMensaje(msg, esExito) {
            const alertBox = document.getElementById('mensajeAlert');
            const texto = document.getElementById('textoMensaje');
            texto.textContent = msg;
            alertBox.classList.remove('hidden');
            alertBox.className = `mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center transition-all border ${esExito ? 'bg-green-600/10 text-green-500 border-green-600/20 shadow-green-900/10' : 'bg-red-600/10 text-red-600 border-red-600/20 shadow-red-900/10'}`;
            setTimeout(() => alertBox.classList.add('hidden'), 4000);
        }

        async function cargarTabla() {
            const res = await fetch('{{ route('personas.index') }}', { headers: { 'Accept': 'application/json' } });
            const json = await res.json();
            const tbody = document.getElementById('tablaDatos');
            tbody.innerHTML = '';

            json.data.forEach(item => {
                const idFormateado = `#${String(item.id_persona).padStart(4, '0')}`;
                
                const estadoHTML = item.activo 
                    ? `<div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse shadow-[0_0_5px_#22c55e]"></div>
                        <span class="text-green-500 text-[9px] font-black tracking-widest uppercase">Activo</span>
                       </div>` 
                    : `<div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-red-600"></div>
                        <span class="text-red-600 text-[9px] font-black tracking-widest uppercase">Inactivo</span>
                       </div>`;

                const fotoHTML = `
                    <div class="relative w-10 h-10 group">
                        <img src="${item.foto_url}" 
                             onerror="this.src='https://ui-avatars.com/api/?name=${item.nombre_completo}&background=111&color=fff&bold=true'" 
                             class="w-10 h-10 rounded-xl object-cover border border-white/10 group-hover:border-red-600 transition-all shadow-lg">
                    </div>`;

                const btnEditar = `
                    <button onclick="abrirModal(${item.id_persona}, '${item.nombre_completo}', '${item.foto_url}')" 
                            class="text-gray-400 hover:text-white font-black text-[10px] uppercase tracking-tighter mr-4 transition-colors">
                        Editar
                    </button>`;

                const btnEstado = item.activo 
                    ? `<button onclick="cambiarEstado(${item.id_persona}, 'destroy', 'DELETE')" class="text-red-900 hover:text-red-600 font-black text-[10px] uppercase tracking-tighter transition-colors">Desactivar</button>`
                    : `<button onclick="cambiarEstado(${item.id_persona}, 'reactivar', 'PATCH')" class="text-green-900 hover:text-green-500 font-black text-[10px] uppercase tracking-tighter transition-colors">Reactivar</button>`;

                tbody.innerHTML += `
                    <tr class="hover:bg-white/[0.02] transition-all duration-300 ${!item.activo ? 'bg-red-950/[0.02] opacity-60' : ''}">
                        <td class="py-4 px-6 font-mono text-[10px] text-gray-600">${idFormateado}</td>
                        <td class="py-4 px-6">${fotoHTML}</td>
                        <td class="py-4 px-6">${estadoHTML}</td>
                        <td class="py-4 px-6">
                            <div class="flex flex-col">
                                <span class="font-black text-white text-xs uppercase tracking-tight">${item.nombre_completo}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-right">${btnEditar} ${btnEstado}</td>
                    </tr>`;
            });
        }
        
        async function guardarData(e) {
            e.preventDefault();
            const data = { 
                nombre_completo: document.getElementById('nombre_completo').value, 
                foto_url: document.getElementById('foto_url').value 
            };
            const res = await fetch('{{ route('personas.store') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify(data)
            });
            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) { document.getElementById('formCrear').reset(); cargarTabla(); }
        }

        function abrirModal(id, nombre, url) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nombre_completo').value = nombre;
            document.getElementById('edit_foto_url').value = url;
            document.getElementById('modalEditar').classList.remove('hidden');
        }
        
        function cerrarModal() { document.getElementById('modalEditar').classList.add('hidden'); }

        async function actualizarData(e) {
            e.preventDefault();
            const id = document.getElementById('edit_id').value;
            const data = { 
                nombre_completo: document.getElementById('edit_nombre_completo').value, 
                foto_url: document.getElementById('edit_foto_url').value 
            };
            const url = '{{ route("personas.update", ":id") }}'.replace(':id', id);
            const res = await fetch(url, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify(data)
            });
            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) { cerrarModal(); cargarTabla(); }
        }

        async function cambiarEstado(id, accion, metodo) {
            if (accion === 'destroy' && !confirm("¿Confirmar baja del sistema?")) return;
            
            const url = accion === 'destroy' ? `/personas/${id}` : `/personas/${id}/reactivar`;
            const res = await fetch(url, { 
                method: metodo, 
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) cargarTabla();
        }

        document.addEventListener('DOMContentLoaded', cargarTabla);
    </script>
</x-admin-layout>