<x-app-layout>
  <x-slot name="header">
    <h2 class="font-black text-2xl text-white tracking-tight uppercase">Base de <span class="text-red-600">Talento y Staff</span></h2>
  </x-slot>

  <div class="py-12 max-w-6xl mx-auto sm:px-6 lg:px-8 text-white relative">
    <div id="mensajeAlert" class="hidden mb-6 p-4 rounded-xl font-bold uppercase tracking-widest text-sm text-center transition-all"></div>

    @include('personas.create')

    <div class="bg-gray-900 p-8 rounded-3xl border border-gray-800 shadow-2xl overflow-x-auto">
      <table class="w-full text-left text-sm whitespace-nowrap">
        <thead>
          <tr class="text-gray-500 uppercase tracking-widest text-[10px] border-b border-gray-800">
            <th class="pb-3 px-4 w-16">Foto</th>
            <th class="pb-3 px-4">Estado</th>
            <th class="pb-3 px-4">Nombre Completo</th>
            <th class="pb-3 px-4 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody id="tablaDatos"></tbody>
      </table>
    </div>

    @include('personas.edit')
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
      const res = await fetch('{{ route('personas.index') }}', { headers: { 'Accept': 'application/json' } });
      const json = await res.json();
      const tbody = document.getElementById('tablaDatos');
      tbody.innerHTML = '';

      json.data.forEach(item => {
        const estadoHTML = item.activo ? `<span class="text-green-500 text-xs font-black">ACTIVO</span>` : `<span class="text-red-500 text-xs font-black">INACTIVO</span>`;
        const fotoHTML = `<img src="${item.foto_url}" onerror="this.src='https://ui-avatars.com/api/?name=${item.nombre_completo}&background=random'" class="w-10 h-10 rounded-full object-cover border border-gray-700">`;
        const btnEditar = `<button onclick="abrirModal(${item.id_persona}, '${item.nombre_completo}', '${item.foto_url}')" class="text-blue-500 hover:text-blue-400 font-bold text-xs uppercase tracking-widest mr-3">Editar</button>`;
        const btnEstado = item.activo 
          ? `<button onclick="cambiarEstado(${item.id_persona}, 'destroy', 'DELETE')" class="text-red-500 font-bold text-xs uppercase tracking-widest">Desactivar</button>`
          : `<button onclick="cambiarEstado(${item.id_persona}, 'reactivar', 'PATCH')" class="text-green-500 font-bold text-xs uppercase tracking-widest">Reactivar</button>`;

        tbody.innerHTML += `
            <tr class="border-b border-gray-800/50 hover:bg-gray-800/30 ${!item.activo ? 'opacity-50' : ''}">
                <td class="py-3 px-4">${fotoHTML}</td>
                <td class="py-4 px-4">${estadoHTML}</td>
                <td class="py-4 px-4 font-bold text-white">${item.nombre_completo}</td>
                <td class="py-4 px-4 text-right">${btnEditar} ${btnEstado}</td>
            </tr>`;
      });
    }

    async function guardarData(e) {
      e.preventDefault();
      const data = { nombre_completo: document.getElementById('nombre_completo').value, foto_url: document.getElementById('foto_url').value };
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
      const data = { nombre_completo: document.getElementById('edit_nombre_completo').value, foto_url: document.getElementById('edit_foto_url').value };
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
      const url = accion === 'destroy' ? `/personas/${id}` : `/personas/${id}/reactivar`;
      const res = await fetch(url, { method: metodo, headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }});
      const json = await res.json();
      mostrarMensaje(json.message, res.ok);
      if (res.ok) cargarTabla();
    }

    document.addEventListener('DOMContentLoaded', cargarTabla);
  </script>
</x-app-layout>