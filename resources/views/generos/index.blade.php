<x-app-layout>
  <x-slot name="header">
    <h2 class="font-black text-2xl text-white tracking-tight uppercase">Catálogo de <span class="text-red-600">Géneros</span></h2>
  </x-slot>

  <div class="py-12 max-w-5xl mx-auto sm:px-6 lg:px-8 text-white relative">
    <div id="mensajeAlert" class="hidden mb-6 p-4 rounded-xl font-bold uppercase tracking-widest text-sm text-center transition-all"></div>

    {{-- AQUI INCLUIMOS EL ARCHIVO MODULAR CREATE --}}
    @include('generos.create')

    <div class="bg-gray-900 p-8 rounded-3xl border border-gray-800 shadow-2xl overflow-x-auto">
      <table class="w-full text-left text-sm whitespace-nowrap">
        <thead>
          <tr class="text-gray-500 uppercase tracking-widest text-[10px] border-b border-gray-800">
            <th class="pb-3 px-4">Estado</th>
            <th class="pb-3 px-4">Nombre del Género</th>
            <th class="pb-3 px-4 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody id="tablaDatos"></tbody>
      </table>
    </div>

    {{-- AQUI INCLUIMOS EL ARCHIVO MODULAR EDIT --}}
    @include('generos.edit')

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
      const res = await fetch('{{ route('generos.index') }}', { headers: { 'Accept': 'application/json' } });
      const json = await res.json();
      const tbody = document.getElementById('tablaDatos');
      tbody.innerHTML = '';

      json.data.forEach(g => {
        const estadoHTML = g.activo ? `<span class="text-green-500 text-xs font-black">ACTIVO</span>` : `<span class="text-red-500 text-xs font-black">INACTIVO</span>`;
        const btnEditar = `<button onclick="abrirModal(${g.id_genero}, '${g.nombre}')" class="text-blue-500 hover:text-blue-400 font-bold text-xs uppercase tracking-widest mr-3">Editar</button>`;
        const btnEstado = g.activo 
          ? `<button onclick="cambiarEstado(${g.id_genero}, 'destroy', 'DELETE')" class="text-red-500 font-bold text-xs uppercase tracking-widest">Desactivar</button>`
          : `<button onclick="cambiarEstado(${g.id_genero}, 'reactivar', 'PATCH')" class="text-green-500 font-bold text-xs uppercase tracking-widest">Reactivar</button>`;

        tbody.innerHTML += `
            <tr class="border-b border-gray-800/50 hover:bg-gray-800/30 ${!g.activo ? 'opacity-50' : ''}">
                <td class="py-4 px-4">${estadoHTML}</td>
                <td class="py-4 px-4 font-bold text-white">${g.nombre}</td>
                <td class="py-4 px-4 text-right">${btnEditar} ${btnEstado}</td>
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
      const res = await fetch(url, { method: metodo, headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }});
      const json = await res.json();
      mostrarMensaje(json.message, res.ok);
      if (res.ok) cargarTabla();
    }

    document.addEventListener('DOMContentLoaded', cargarTabla);
  </script>
</x-app-layout>