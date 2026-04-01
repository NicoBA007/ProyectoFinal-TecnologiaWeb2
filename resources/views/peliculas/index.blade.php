<x-app-layout>
  <x-slot name="header">
    <h2 class="font-black text-2xl text-white tracking-tight uppercase">Catálogo de <span
        class="text-purple-500">Películas</span></h2>
  </x-slot>

  <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 text-white relative">
    <div id="mensajeAlert"
      class="hidden mb-6 p-4 rounded-xl font-bold uppercase tracking-widest text-sm text-center transition-all"></div>

    @include('peliculas.create')

    <div class="bg-gray-900 p-8 rounded-3xl border border-gray-800 shadow-2xl overflow-x-auto">
      <table class="w-full text-left text-sm whitespace-nowrap">
        <thead>
          <tr class="text-gray-500 uppercase tracking-widest text-[10px] border-b border-gray-800">
            <th class="pb-3 px-4">Póster</th>
            <th class="pb-3 px-4">Estado</th>
            <th class="pb-3 px-4">Título</th>
            <th class="pb-3 px-4">Clasificación</th>
            <th class="pb-3 px-4 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody id="tablaDatos"></tbody>
      </table>
    </div>

    @include('peliculas.edit')

    {{-- AQUÍ ESTÁ EL NUEVO MODAL DE ELENCO INCLUIDO --}}
    @include('peliculas.elenco')
  </div>

  <script>
    const csrfToken = '{{ csrf_token() }}';

    function mostrarMensaje(msg, esExito) {
      const alertBox = document.getElementById('mensajeAlert');
      alertBox.textContent = msg;
      alertBox.className = `mb-6 p-4 rounded-xl font-bold uppercase tracking-widest text-sm text-center border ${esExito ? 'bg-green-500/20 text-green-500 border-green-500/30' : 'bg-red-500/20 text-red-500 border-red-500/30'}`;
      alertBox.classList.remove('hidden');
      setTimeout(() => alertBox.classList.add('hidden'), 3000);
    }

    async function cargarTabla() {
      const res = await fetch('{{ route('peliculas.index') }}', { headers: { 'Accept': 'application/json' } });
      const json = await res.json();

      // PROTECCIÓN: Si el servidor falla, mostramos el error real y detenemos el JS
      if (!json.success) {
        mostrarMensaje("Error Servidor: " + json.message, false);
        return;
      }

      const tbody = document.getElementById('tablaDatos');
      tbody.innerHTML = '';

      json.data.forEach(item => {
        const estadoHTML = item.activo ? `<span class="text-green-500 text-xs font-black">ACTIVO</span>` : `<span class="text-red-500 text-xs font-black">INACTIVO</span>`;
        const fotoHTML = `<img src="${item.poster_url}" class="w-10 h-14 rounded object-cover border border-gray-700">`;

        const dataB64 = btoa(unescape(encodeURIComponent(JSON.stringify(item))));
        const btnEditar = `<button onclick="abrirModal('${dataB64}')" class="text-blue-500 hover:text-blue-400 font-bold text-[10px] uppercase tracking-widest mr-3">Editar</button>`;

        // TRUCO SENIOR: Codificamos el título en Base64 para que ninguna comilla o salto de línea rompa el HTML
        const tituloB64 = btoa(unescape(encodeURIComponent(item.titulo)));
        const btnElenco = `<button onclick="abrirModalElenco(${item.id_pelicula}, '${tituloB64}')" class="text-yellow-500 hover:text-yellow-400 font-bold text-[10px] uppercase tracking-widest mr-3">Elenco</button>`;

        const btnEstado = item.activo
          ? `<button onclick="cambiarEstado(${item.id_pelicula}, 'destroy', 'DELETE')" class="text-red-500 font-bold text-[10px] uppercase tracking-widest">Desactivar</button>`
          : `<button onclick="cambiarEstado(${item.id_pelicula}, 'reactivar', 'PATCH')" class="text-green-500 font-bold text-[10px] uppercase tracking-widest">Reactivar</button>`;

        tbody.innerHTML += `
            <tr class="border-b border-gray-800/50 hover:bg-gray-800/30 ${!item.activo ? 'opacity-50' : ''}">
                <td class="py-3 px-4">${fotoHTML}</td>
                <td class="py-4 px-4">${estadoHTML}</td>
                <td class="py-4 px-4 font-bold text-white">${item.titulo}</td>
                <td class="py-4 px-4"><span class="bg-gray-800 px-2 py-1 rounded text-[10px] font-black">${item.clasificacion}</span></td>
                <td class="py-4 px-4 text-right">${btnElenco} ${btnEditar} ${btnEstado}</td>
            </tr>`;
      });
    }
    async function abrirModalElenco(id_pelicula, tituloB64) {
      // Decodificamos el título de forma segura
      const titulo = decodeURIComponent(escape(atob(tituloB64)));
      document.getElementById('elenco_titulo_pelicula').textContent = titulo;
      document.getElementById('elenco_id_pelicula').value = id_pelicula;
      document.getElementById('modalElenco').classList.remove('hidden');
      await recargarDatosElenco(id_pelicula);
    }
    function getCheckboxes(name) {
      return Array.from(document.querySelectorAll(`input[name="${name}"]:checked`)).map(cb => cb.value);
    }

    async function guardarData(e) {
      e.preventDefault();
      const data = {
        titulo: document.getElementById('titulo').value, sinopsis: document.getElementById('sinopsis').value,
        id_clasificacion: document.getElementById('id_clasificacion').value, duracion_min: document.getElementById('duracion_min').value,
        fecha_estreno: document.getElementById('fecha_estreno').value, estado: document.getElementById('estado').value,
        poster_url: document.getElementById('poster_url').value, trailer_url: document.getElementById('trailer_url').value,
        generos: getCheckboxes('generos[]'),
        paises: getCheckboxes('paises[]')
      };
      const res = await fetch('{{ route('peliculas.store') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }, body: JSON.stringify(data) });
      const json = await res.json();
      mostrarMensaje(json.message, res.ok);
      if (res.ok) { document.getElementById('formCrear').reset(); cargarTabla(); }
    }

    function abrirModal(dataB64) {
      const p = JSON.parse(decodeURIComponent(escape(atob(dataB64))));
      document.getElementById('edit_id').value = p.id_pelicula;
      document.getElementById('edit_titulo').value = p.titulo;
      document.getElementById('edit_sinopsis').value = p.sinopsis;
      document.getElementById('edit_id_clasificacion').value = p.id_clasificacion;
      document.getElementById('edit_duracion_min').value = p.duracion_min;
      document.getElementById('edit_fecha_estreno').value = p.fecha_estreno;
      document.getElementById('edit_estado').value = p.estado;
      document.getElementById('edit_poster_url').value = p.poster_url;
      document.getElementById('edit_trailer_url').value = p.trailer_url;

      // Limpiar todos los checkboxes primero
      document.querySelectorAll('.chk-edit-genero, .chk-edit-pais').forEach(cb => cb.checked = false);

      // Marcar los géneros que ya tiene la película
      if (p.generos) p.generos.forEach(g => {
        let cb = document.querySelector(`input[name="edit_generos[]"][value="${g.id_genero}"]`);
        if (cb) cb.checked = true;
      });
      // Marcar los países
      if (p.paises) p.paises.forEach(pais => {
        let cb = document.querySelector(`input[name="edit_paises[]"][value="${pais.id_pais_origen}"]`);
        if (cb) cb.checked = true;
      });

      document.getElementById('modalEditar').classList.remove('hidden');
    }
    function cerrarModal() { document.getElementById('modalEditar').classList.add('hidden'); }

    async function actualizarData(e) {
      e.preventDefault();
      const id = document.getElementById('edit_id').value;
      const data = {
        titulo: document.getElementById('edit_titulo').value, sinopsis: document.getElementById('edit_sinopsis').value,
        id_clasificacion: document.getElementById('edit_id_clasificacion').value, duracion_min: document.getElementById('edit_duracion_min').value,
        fecha_estreno: document.getElementById('edit_fecha_estreno').value, estado: document.getElementById('edit_estado').value,
        poster_url: document.getElementById('edit_poster_url').value, trailer_url: document.getElementById('edit_trailer_url').value,
        // Recolectamos los checkboxes de edición
        generos: getCheckboxes('edit_generos[]'),
        paises: getCheckboxes('edit_paises[]')
      };
      const url = '{{ route("peliculas.update", ":id") }}'.replace(':id', id);
      const res = await fetch(url, { method: 'PUT', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }, body: JSON.stringify(data) });
      const json = await res.json();
      mostrarMensaje(json.message, res.ok);
      if (res.ok) { cerrarModal(); cargarTabla(); }
    }

    async function cambiarEstado(id, accion, metodo) {
      const url = accion === 'destroy' ? `/peliculas/${id}` : `/peliculas/${id}/reactivar`;
      const res = await fetch(url, { method: metodo, headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken } });
      const json = await res.json();
      mostrarMensaje(json.message, res.ok);
      if (res.ok) cargarTabla();
    }

    // ==========================================
    // MAGIA DEL MODAL ELENCO (TABLA PIVOTE)
    // ==========================================

    async function abrirModalElenco(id_pelicula, titulo) {
      document.getElementById('elenco_titulo_pelicula').textContent = titulo;
      document.getElementById('elenco_id_pelicula').value = id_pelicula;
      document.getElementById('modalElenco').classList.remove('hidden');
      await recargarDatosElenco(id_pelicula);
    }

    function cerrarModalElenco() { document.getElementById('modalElenco').classList.add('hidden'); }

    async function recargarDatosElenco(id_pelicula) {
      const res = await fetch(`/peliculas/${id_pelicula}/detalles`, { headers: { 'Accept': 'application/json' } });
      const json = await res.json();

      // 1. Llenamos el select de talentos disponibles
      const select = document.getElementById('elenco_id_persona');
      select.innerHTML = '<option value="">Selecciona un talento...</option>';
      json.personas_disponibles.forEach(p => {
        select.innerHTML += `<option value="${p.id_persona}">${p.nombre_completo}</option>`;
      });

      // 2. Llenamos la tabla del elenco actual
      const tbody = document.getElementById('tablaElenco');
      tbody.innerHTML = '';
      if (json.elenco.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="py-4 text-center text-gray-500 text-xs">Aún no hay talento registrado.</td></tr>';
        return;
      }

      json.elenco.forEach(p => {
        const btnBorrar = `<button onclick="removerElenco(${id_pelicula}, ${p.pivot.id})" class="text-red-500 hover:text-red-400 font-bold text-[10px] uppercase tracking-widest">Remover</button>`;
        tbody.innerHTML += `
                <tr class="border-b border-gray-800/50 hover:bg-gray-800/50">
                    <td class="py-3 px-4 font-bold text-white">${p.nombre_completo}</td>
                    <td class="py-3 px-4 text-gray-300">${p.pivot.rol_en_pelicula}</td>
                    <td class="py-3 px-4 text-gray-500 italic">${p.pivot.papel_personaje || '-'}</td>
                    <td class="py-3 px-4 text-right">${btnBorrar}</td>
                </tr>`;
      });
    }

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
      if (res.ok) {
        document.getElementById('formAgregarElenco').reset();
        recargarDatosElenco(id_pelicula);
      }
    }

    async function removerElenco(id_pelicula, pivot_id) {
      if (!confirm("¿Estás seguro de remover a este talento de la película?")) return;
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
</x-app-layout>