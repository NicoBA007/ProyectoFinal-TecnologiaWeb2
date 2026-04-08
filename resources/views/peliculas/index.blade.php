<x-admin-layout>
    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8 text-white relative">

        {{-- Monitor de Estado de Carga / Alertas --}}
        <div id="mensajeAlert"
            class="hidden mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center transition-all border shadow-2xl relative overflow-hidden">
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
                    <h3 class="text-gray-400 font-black uppercase tracking-[0.3em] text-[10px]">Inventario General de
                        Títulos</h3>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-[9px] font-mono text-red-600 animate-pulse uppercase tracking-widest">Live
                        Database</span>
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
            alertBox.className =
                `mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center transition-all border shadow-2xl relative overflow-hidden ${esExito ? 'bg-green-600/10 text-green-500 border-green-600/20' : 'bg-red-600/10 text-red-600 border-red-600/20'}`;
            texto.textContent = msg;
            setTimeout(() => alertBox.classList.add('hidden'), 4000);
        }

        // --- CARGA DE TABLA PRINCIPAL ---
        async function cargarTabla() {
            try {
                const res = await fetch('{{ route('peliculas.index') }}', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
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

                    const estadoHTML = item.activo ?
                        `<div class="flex items-center gap-2"><div class="w-1 h-1 rounded-full bg-green-500 shadow-[0_0_5px_#22c55e]"></div><span class="text-green-500 text-[9px] font-black tracking-widest uppercase">Disponible</span></div>` :
                        `<div class="flex items-center gap-2"><div class="w-1 h-1 rounded-full bg-red-600"></div><span class="text-red-600 text-[9px] font-black tracking-widest uppercase">No Listada</span></div>`;

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
        Rating: ${item.clasificacion_codigo}
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
            } catch (e) {
                console.error("Error al cargar tabla:", e);
            }
        }

        // --- GESTIÓN DE MODAL EDITAR (FICHA) ---
        function abrirModal(dataB64) {
            try {
                const p = JSON.parse(decodeURIComponent(escape(atob(dataB64))));
                console.log("Estructura completa recibida:", p);

                // Campos simples
                document.getElementById('edit_id').value = p.id_pelicula;
                document.getElementById('edit_titulo').value = p.titulo;
                document.getElementById('edit_sinopsis').value = p.sinopsis || '';
                document.getElementById('edit_id_clasificacion').value = p.id_clasificacion;
                document.getElementById('edit_duracion_min').value = p.duracion_min;
                document.getElementById('edit_fecha_estreno').value = p.fecha_estreno;
                document.getElementById('edit_poster_url').value = p.poster_url;
                document.getElementById('edit_trailer_url').value = p.trailer_url;
                document.getElementById('edit_estado').value = p.estado;

                // --- PROCESAR GÉNEROS ---
                document.querySelectorAll('.chk-edit-genero').forEach(cb => cb.checked = false);
                const listaGeneros = p.generos || [];
                listaGeneros.forEach(g => {
                    // Buscamos el ID ya sea que venga como objeto o como número directo
                    const id = (typeof g === 'object') ? (g.id_genero || g.id) : g;
                    const cb = document.querySelector(`.chk-edit-genero[value="${id}"]`);
                    if (cb) cb.checked = true;
                });

                // --- PROCESAR PAÍSES ---
                document.querySelectorAll('.chk-edit-pais').forEach(cb => cb.checked = false);
                const listaPaises = p.paises || [];

                console.log("Lista de países extraída:", listaPaises);

                listaPaises.forEach(pais => {
                    // INTENTO 1: id_pais_origen (como en tu DB)
                    // INTENTO 2: id (estándar Laravel/DTO)
                    // INTENTO 3: el valor directo si es un array de IDs
                    const id = (typeof pais === 'object') ? (pais.id_pais_origen || pais.id) : pais;

                    const cb = document.querySelector(`.chk-edit-pais[value="${id}"]`);

                    if (cb) {
                        cb.checked = true;
                    } else {
                        console.warn(
                            `No se encontró el checkbox para el País ID: ${id}. Revisa si el value del HTML coincide.`
                        );
                    }
                });

                document.getElementById('modalEditar').classList.remove('hidden');

            } catch (error) {
                console.error("Error al abrir el modal:", error);
                alert("Error al cargar los datos de la película.");
            }
        }

        function cerrarModal() {
            document.getElementById('modalEditar').classList.add('hidden');
        }

        // --- GESTIÓN DE MODAL ELENCO ---
        async function abrirModalElenco(id_pelicula, tituloB64) {
            try {
                const titulo = decodeURIComponent(escape(atob(tituloB64)));

                // Validamos que los elementos existan antes de asignar
                const elTitulo = document.getElementById('elenco_titulo_pelicula');
                const elId = document.getElementById('elenco_id_pelicula');
                const modal = document.getElementById('modalElenco');

                if (elTitulo) elTitulo.textContent = titulo.toUpperCase();
                if (elId) elId.value = id_pelicula;
                if (modal) modal.classList.remove('hidden');

                await recargarDatosElenco(id_pelicula);
            } catch (e) {
                console.error("Error al abrir modal elenco:", e);
            }
        }

        function cerrarModalElenco() {
            document.getElementById('modalElenco').classList.add('hidden');
            document.getElementById('formAgregarElenco').reset();
        }

        async function recargarDatosElenco(id_pelicula) {
            // URL con prefijo /admin
            const res = await fetch(`/admin/peliculas/${id_pelicula}/detalles`, {
                headers: {
                    'Accept': 'application/json'
                }
            });
            const json = await res.json();

            // 1. Llenar Select de Personas
            const select = document.getElementById('elenco_id_persona');
            select.innerHTML = '<option value="">Seleccionar Talento...</option>';
            json.personas_disponibles.forEach(p => {
                select.innerHTML += `<option value="${p.id_persona}">${p.nombre_completo}</option>`;
            });

            // 2. Llenar Tabla
            const tbody = document.getElementById('tablaElenco');
            tbody.innerHTML = json.elenco.length === 0 ?
                '<tr><td colspan="4" class="py-10 text-center text-gray-600 text-[10px] uppercase italic tracking-widest">Sin registros en el reparto digital</td></tr>' :
                json.elenco.map(p => `
            <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                <td class="py-3 px-4 text-xs font-bold text-white uppercase">${p.nombre_completo}</td>
                <td class="py-3 px-4 text-[10px] text-gray-400 uppercase tracking-widest">${p.pivot.rol_en_pelicula}</td>
                <td class="py-3 px-4 text-[10px] text-gray-500 italic uppercase">${p.pivot.papel_personaje || '-'}</td>
                <td class="py-3 px-4 text-right">
                    <button onclick="removerElenco(${id_pelicula}, ${p.pivot.id})"
                            class="text-red-900 hover:text-red-500 font-black text-[9px] uppercase tracking-widest transition-colors">
                        Remover
                    </button>
                </td>
            </tr>
        `).join('');
        }

        async function guardarElenco(e) {
            e.preventDefault();
            const id_pelicula = document.getElementById('elenco_id_pelicula').value;
            const data = {
                id_persona: document.getElementById('elenco_id_persona').value,
                rol_en_pelicula: document.getElementById('elenco_rol').value,
                papel_personaje: document.getElementById('elenco_personaje').value
            };

            const res = await fetch(`/admin/peliculas/${id_pelicula}/elenco`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            });

            const json = await res.json();
            mostrarMensaje(json.message, res.ok);

            if (res.ok) {
                document.getElementById('formAgregarElenco').reset();
                recargarDatosElenco(id_pelicula);
            }
        }

        async function removerElenco(id_pelicula, pivot_id) {
            if (!confirm("¿Desea remover este talento del registro?")) return;

            const res = await fetch(`/admin/peliculas/${id_pelicula}/elenco/${pivot_id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) recargarDatosElenco(id_pelicula);
        }

        function cerrarModalElenco() {
            document.getElementById('modalElenco').classList.add('hidden');
        }

        async function recargarDatosElenco(id_pelicula) {
            // 1. Corregimos la URL agregando /admin
            const res = await fetch(`/admin/peliculas/${id_pelicula}/detalles`, {
                headers: {
                    'Accept': 'application/json'
                }
            });
            const json = await res.json();

            // 2. Llenar el select de personas disponibles
            const select = document.getElementById('elenco_id_persona');
            select.innerHTML = '<option value="">Seleccionar Talento...</option>';

            // Tu controlador envía "personas_disponibles"
            json.personas_disponibles.forEach(p => {
                // Usamos nombre_completo que es lo que envía tu controlador
                select.innerHTML += `<option value="${p.id_persona}">${p.nombre_completo}</option>`;
            });

            // 3. Llenar la tabla del elenco actual
            const tbody = document.getElementById('tablaElenco');

            // Tu controlador envía la relación bajo la llave "elenco"
            tbody.innerHTML = json.elenco.length === 0 ?
                '<tr><td colspan="4" class="py-4 text-center text-gray-600 text-[10px] uppercase italic">Sin registros en el elenco</td></tr>' :
                json.elenco.map(p => `
            <tr class="border-b border-white/5 hover:bg-white/[0.02]">
                <td class="py-3 px-4 text-xs font-bold text-white uppercase">
                    ${p.nombre_completo || (p.nombres + ' ' + p.apellido_paterno)}
                </td>
                <td class="py-3 px-4 text-[10px] text-gray-400 uppercase tracking-widest">
                    ${p.pivot.rol_en_pelicula}
                </td>
                <td class="py-3 px-4 text-[10px] text-gray-600 italic uppercase">
                    ${p.pivot.papel_personaje || '-'}
                </td>
                <td class="py-3 px-4 text-right">
                    <button onclick="removerElenco(${id_pelicula}, ${p.pivot.id})"
                            class="text-red-600 hover:text-red-400 font-black text-[9px] uppercase tracking-widest">
                        Remover
                    </button>
                </td>
            </tr>`).join('');
        }

        // --- LÓGICA DE ESTADO (ALTA/BAJA) ---
        async function cambiarEstado(id, accion, metodo) {
            // AGREGAMOS /admin antes de la ruta
            const url = accion === 'destroy' ? `/admin/peliculas/${id}` : `/admin/peliculas/${id}/reactivar`;

            const res = await fetch(url, {
                method: metodo,
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            const json = await res.json();
            mostrarMensaje(json.message, res.ok);
            if (res.ok) cargarTabla();
        }

        // --- GUARDADO DE ELENCO ---
        async function guardarElenco(e) {
            e.preventDefault();

            const id_pelicula = document.getElementById('elenco_id_pelicula').value;

            // Obtener los valores de los campos
            const id_persona = document.getElementById('elenco_id_persona').value;
            const rol = document.getElementById('elenco_rol').value;
            const personaje = document.getElementById('elenco_personaje').value;

            if (!id_persona) {
                mostrarMensaje("Selecciona a una persona primero", false);
                return;
            }

            try {
                // LA URL DEBE EMPEZAR CON /admin
                const res = await fetch(`/admin/peliculas/${id_pelicula}/elenco`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Asegúrate de que esta variable esté definida arriba
                    },
                    body: JSON.stringify({
                        id_persona: id_persona,
                        rol_en_pelicula: rol,
                        papel_personaje: personaje
                    })
                });

                const json = await res.json();

                if (res.ok) {
                    mostrarMensaje(json.message || "Actor añadido", true);
                    document.getElementById('formAgregarElenco').reset();
                    await recargarDatosElenco(id_pelicula); // Refresca la lista sin cerrar el modal
                } else {
                    mostrarMensaje(json.message || "Error al añadir", false);
                    console.error("Errores de validación:", json.errors);
                }
            } catch (error) {
                console.error("Error en la petición:", error);
                mostrarMensaje("Error crítico en el servidor", false);
            }
        }
        async function removerElenco(id_pelicula, pivot_id) {
            if (!confirm("¿Desea remover este talento del registro?")) return;

            try {
                // AGREGAR /admin al inicio de la URL
                const res = await fetch(`/admin/peliculas/${id_pelicula}/elenco/${pivot_id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Asegúrate de que esta variable existe
                    }
                });

                const json = await res.json();

                if (res.ok) {
                    mostrarMensaje(json.message, true);
                    await recargarDatosElenco(id_pelicula); // Refrescar la tabla
                } else {
                    mostrarMensaje(json.message || "Error al eliminar", false);
                }
            } catch (error) {
                console.error("Error:", error);
                mostrarMensaje("Error de conexión", false);
            }
        }

        document.addEventListener('DOMContentLoaded', cargarTabla);
        async function actualizarData(event) {
            event.preventDefault(); // Evita que la página se recargue

            const id = document.getElementById('edit_id').value;

            // Capturamos los checkboxes seleccionados de Géneros y Países
            const generos = Array.from(document.querySelectorAll('input[name="edit_generos[]"]:checked'))
                .map(cb => cb.value);
            const paises = Array.from(document.querySelectorAll('input[name="edit_paises[]"]:checked'))
                .map(cb => cb.value);

            // Construimos el objeto con los datos del formulario
            const data = {
                titulo: document.getElementById('edit_titulo').value,
                sinopsis: document.getElementById('edit_sinopsis').value,
                id_clasificacion: document.getElementById('edit_id_clasificacion').value,
                duracion_min: document.getElementById('edit_duracion_min').value,
                fecha_estreno: document.getElementById('edit_fecha_estreno').value,
                estado: document.getElementById('edit_estado').value,
                poster_url: document.getElementById('edit_poster_url').value,
                trailer_url: document.getElementById('edit_trailer_url').value,
                generos: generos,
                paises: paises
            };

            try {
                // IMPORTANTE: Tu controlador está bajo el prefijo /admin
                const response = await fetch(`/admin/peliculas/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                });

                const json = await response.json();

                if (response.ok && json.success) {
                    mostrarMensaje(json.message, true);
                    cerrarModal();
                    cargarTabla(); // Refresca la tabla automáticamente
                } else {
                    // Si hay errores de validación (422), los mostramos
                    const errorMsg = json.message || "Error al actualizar";
                    mostrarMensaje("ERROR: " + errorMsg, false);
                    console.error("Detalles de error:", json.errors);
                }
            } catch (error) {
                console.error("Error en la petición:", error);
                mostrarMensaje("SYSTEM_ERROR: No se pudo conectar con el servidor", false);
            }
        }
        // --- GUARDAR NUEVA PELÍCULA ---
        async function guardarData(event) {
            event.preventDefault();

            // Capturamos los checkboxes manualmente ya que son arreglos
            const generos = Array.from(document.querySelectorAll('input[name="generos[]"]:checked'))
                .map(cb => cb.value);
            const paises = Array.from(document.querySelectorAll('input[name="paises[]"]:checked'))
                .map(cb => cb.value);

            // Construimos el objeto exacto que espera tu StorePeliculaAjaxRequest
            const data = {
                titulo: document.getElementById('titulo').value,
                id_clasificacion: document.getElementById('id_clasificacion').value,
                duracion_min: document.getElementById('duracion_min').value,
                fecha_estreno: document.getElementById('fecha_estreno').value,
                estado: document.getElementById('estado').value,
                poster_url: document.getElementById('poster_url').value,
                trailer_url: document.getElementById('trailer_url').value,
                sinopsis: document.getElementById('sinopsis').value,
                generos: generos,
                paises: paises
            };

            try {
                const response = await fetch('/admin/peliculas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                });

                const json = await response.json();

                if (response.ok && json.success) {
                    mostrarMensaje(json.message, true);
                    event.target.reset(); // Limpia el formulario
                    cargarTabla(); // Refresca la lista de abajo
                } else {
                    // Si hay errores de validación, Laravel envía 422 y un objeto 'errors'
                    const msg = json.message || "Error al validar datos";
                    mostrarMensaje(msg, false);
                    console.error("Errores de validación:", json.errors);
                }
            } catch (error) {
                console.error("Error crítico:", error);
                mostrarMensaje("Error de conexión con el servidor", false);
            }
        }
    </script>
</x-admin-layout>
