<x-admin-layout>
    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8 text-white relative">
        
        {{-- Monitor de Estado de Carga / Alertas --}}
        <div id="mensajeAlert" class="hidden mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center transition-all border shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-current"></div>
            <span id="textoMensaje" class="relative z-10"></span>
        </div>

        {{-- Formulario de Registro de Títulos --}}
        <div class="mb-10">
            @include('peliculas.create')
        </div>

        {{-- TABLA DE CATALOGACIÓN DE CINTAS --}}
        <div class="bg-gray-950 border border-white/5 rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.6)] overflow-hidden">
            <div class="p-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <span class="text-xl">🎬</span>
                    <h3 class="text-gray-400 font-black uppercase tracking-[0.3em] text-[10px]">Inventario General de Títulos</h3>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-[9px] font-mono text-red-600 animate-pulse uppercase tracking-widest">Live Database</span>
                    <span class="text-[9px] font-mono text-gray-600 uppercase">PrimeCinemas_Assets</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-gray-600 uppercase tracking-[0.2em] text-[9px] bg-white/[0.01]">
                            <th class="py-4 px-6 border-b border-white/5 w-16">ID</th>
                            <th class="py-4 px-6 border-b border-white/5 w-20">Preview</th>
                            <th class="py-4 px-6 border-b border-white/5">Estado</th>
                            <th class="py-4 px-6 border-b border-white/5">Título de la Obra</th>
                            <th class="py-4 px-6 border-b border-white/5">Clasificación</th>
                            <th class="py-4 px-6 border-b border-white/5 text-right">Módulos de Gestión</th>
                        </tr>
                    </thead>
                    <tbody id="tablaDatos" class="divide-y divide-white/[0.03]">
                        {{-- Inyección vía AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>

        @include('peliculas.edit')
        @include('peliculas.elenco')
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        // --- SISTEMA DE NOTIFICACIONES ---
        function mostrarMensaje(msg, esExito) {
            const alertBox = document.getElementById('mensajeAlert');
            const texto = document.getElementById('textoMensaje');
            alertBox.classList.remove('hidden');
            alertBox.className = `mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center transition-all border shadow-2xl relative overflow-hidden ${esExito ? 'bg-green-600/10 text-green-500 border-green-600/20' : 'bg-red-600/10 text-red-600 border-red-600/20'}`;
            texto.textContent = msg;
            setTimeout(() => alertBox.classList.add('hidden'), 4000);
        }

        // --- CARGA DE TABLA PRINCIPAL ---
        async function cargarTabla() {
            try {
                const res = await fetch('{{ route('peliculas.index') }}', { headers: { 'Accept': 'application/json' } });
                const json = await res.json();

                if (!json.success) {
                    mostrarMensaje("SYSTEM_ERROR: " + json.message, false);
                    return;
                }

                const tbody = document.getElementById('tablaDatos');
                tbody.innerHTML = '';

                json.data.forEach(item => {
                    const idFormateado = `#${String(item.id_pelicula).padStart(4, '0')}`;
                    const dataB64 = btoa(unescape(encodeURIComponent(JSON.stringify(item))));
                    const tituloB64 = btoa(unescape(encodeURIComponent(item.titulo)));

                    const estadoHTML = item.activo 
                        ? `<div class="flex items-center gap-2"><div class="w-1 h-1 rounded-full bg-green-500 shadow-[0_0_5px_#22c55e]"></div><span class="text-green-500 text-[9px] font-black tracking-widest uppercase">Disponible</span></div>` 
                        : `<div class="flex items-center gap-2"><div class="w-1 h-1 rounded-full bg-red-600"></div><span class="text-red-600 text-[9px] font-black tracking-widest uppercase">No Listada</span></div>`;

                    tbody.innerHTML += `
                        <tr class="hover:bg-white/[0.02] transition-all duration-300 ${!item.activo ? 'opacity-40' : ''}">
                            <td class="py-4 px-6 font-mono text-[10px] text-gray-600">${idFormateado}</td>
                            <td class="py-4 px-6">
                                <img src="${item.poster_url}" class="w-10 h-14 rounded-md object-cover border border-white/10 shadow-xl">
                            </td>
                            <td class="py-4 px-6">${estadoHTML}</td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="font-black text-white text-xs uppercase tracking-tight">${item.titulo}</span>
                                    <span class="text-[8px] text-gray-600 uppercase font-bold tracking-[0.1em] mt-0.5">Master Tape / Digital Asset</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-white/5 border border-white/10 text-gray-400 text-[9px] font-black px-2 py-1 rounded uppercase tracking-widest">
                                    Rating: ${item.clasificacion}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button onclick="abrirModalElenco(${item.id_pelicula}, '${tituloB64}')" class="text-yellow-600 hover:text-yellow-400 font-black text-[9px] uppercase tracking-widest mr-4 transition-colors">Elenco</button>
                                <button onclick="abrirModal('${dataB64}')" class="text-gray-400 hover:text-white font-black text-[9px] uppercase tracking-widest mr-4 transition-colors">Ficha</button>
                                <button onclick="cambiarEstado(${item.id_pelicula}, '${item.activo ? 'destroy' : 'reactivar'}', '${item.activo ? 'DELETE' : 'PATCH'}')" class="${item.activo ? 'text-red-900 hover:text-red-500' : 'text-green-900 hover:text-green-500'} font-black text-[9px] uppercase tracking-widest transition-colors">
                                    ${item.activo ? 'Baja' : 'Alta'}
                                </button>
                            </td>
                        </tr>`;
                });
            } catch (e) { console.error("Error al cargar tabla:", e); }
        }

        // --- GESTIÓN DE MODAL EDITAR (FICHA) ---
        function abrirModal(dataB64) {
            const p = JSON.parse(decodeURIComponent(escape(atob(dataB64))));
            document.getElementById('edit_id').value = p.id_pelicula;
            document.getElementById('edit_titulo').value = p.titulo;
            document.getElementById('edit_sinopsis').value = p.sinopsis || '';
            document.getElementById('edit_id_clasificacion').value = p.id_clasificacion;
            document.getElementById('edit_duracion_min').value = p.duracion_min;
            document.getElementById('edit_fecha_estreno').value = p.fecha_estreno;
            document.getElementById('edit_poster_url').value = p.poster_url;
            document.getElementById('edit_trailer_url').value = p.trailer_url;

            document.querySelectorAll('.chk-edit-genero, .chk-edit-pais').forEach(cb => cb.checked = false);
            if (p.generos) p.generos.forEach(g => {
                let cb = document.querySelector(`input[name="edit_generos[]"][value="${g.id_genero}"]`);
                if (cb) cb.checked = true;
            });
            if (p.paises) p.paises.forEach(pais => {
                let cb = document.querySelector(`input[name="edit_paises[]"][value="${pais.id_pais_origen}"]`);
                if (cb) cb.checked = true;
            });

            document.getElementById('modalEditar').classList.remove('hidden');
        }

        function cerrarModal() { document.getElementById('modalEditar').classList.add('hidden'); }

        // --- GESTIÓN DE MODAL ELENCO ---
        async function abrirModalElenco(id_pelicula, tituloB64) {
            const titulo = decodeURIComponent(escape(atob(tituloB64)));
            document.getElementById('elenco_titulo_pelicula').textContent = titulo.toUpperCase();
            document.getElementById('elenco_id_pelicula').value = id_pelicula;
            document.getElementById('modalElenco').classList.remove('hidden');
            await recargarDatosElenco(id_pelicula);
        }

        function cerrarModalElenco() { document.getElementById('modalElenco').classList.add('hidden'); }

        async function recargarDatosElenco(id_pelicula) {
            const res = await fetch(`/peliculas/${id_pelicula}/detalles`, { headers: { 'Accept': 'application/json' } });
            const json = await res.json();

            const select = document.getElementById('elenco_id_persona');
            select.innerHTML = '<option value="">Seleccionar Talento...</option>';
            json.personas_disponibles.forEach(p => {
                select.innerHTML += `<option value="${p.id_persona}">${p.nombre_completo}</option>`;
            });

            const tbody = document.getElementById('tablaElenco');
            tbody.innerHTML = json.elenco.length === 0 
                ? '<tr><td colspan="4" class="py-4 text-center text-gray-600 text-[10px] uppercase italic">Sin registros en el elenco</td></tr>'
                : json.elenco.map(p => `
                    <tr class="border-b border-white/5 hover:bg-white/[0.02]">
                        <td class="py-3 px-4 text-xs font-bold text-white uppercase">${p.nombre_completo}</td>
                        <td class="py-3 px-4 text-[10px] text-gray-400 uppercase tracking-widest">${p.pivot.rol_en_pelicula}</td>
                        <td class="py-3 px-4 text-[10px] text-gray-600 italic uppercase">${p.pivot.papel_personaje || '-'}</td>
                        <td class="py-3 px-4 text-right">
                            <button onclick="removerElenco(${id_pelicula}, ${p.pivot.id})" class="text-red-600 hover:text-red-400 font-black text-[9px] uppercase tracking-widest">Remover</button>
                        </td>
                    </tr>`).join('');
        }

        // --- LÓGICA DE ESTADO (ALTA/BAJA) ---
        async function cambiarEstado(id, accion, metodo) {
            const url = accion === 'destroy' ? `/peliculas/${id}` : `/peliculas/${id}/reactivar`;
            const res = await fetch(url, { method: metodo, headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken } });
            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) cargarTabla();
        }

        // --- GUARDADO DE ELENCO ---
        async function guardarElenco(e) {
            e.preventDefault();
            const id_pelicula = document.getElementById('elenco_id_pelicula').value;
            const data = {
                id_persona: document.getElementById('elenco_id_persona').value,
                rol_en_pelicula: document.getElementById('elenco_rol').value,
                papel_personaje: document.getElementById('elenco_personaje').value
            };
            const res = await fetch(`/peliculas/${id_pelicula}/elenco`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify(data)
            });
            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) { document.getElementById('formAgregarElenco').reset(); recargarDatosElenco(id_pelicula); }
        }

        async function removerElenco(id_pelicula, pivot_id) {
            if (!confirm("¿Desea remover este talento del asset digital?")) return;
            const res = await fetch(`/peliculas/${id_pelicula}/elenco/${pivot_id}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) recargarDatosElenco(id_pelicula);
        }

        document.addEventListener('DOMContentLoaded', cargarTabla);
    </script>
</x-admin-layout>