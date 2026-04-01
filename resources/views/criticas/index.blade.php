<x-app-layout>
  <x-slot name="header">
    <h2 class="font-black text-2xl text-white tracking-tight uppercase">Moderación de <span class="text-yellow-500">Críticas</span></h2>
  </x-slot>

  <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 text-white relative">
    <div id="mensajeAlert" class="hidden mb-6 p-4 rounded-xl font-bold uppercase tracking-widest text-sm text-center transition-all"></div>

    <div class="bg-gray-900 p-8 rounded-3xl border border-gray-800 shadow-2xl overflow-x-auto">
      <table class="w-full text-left text-sm whitespace-nowrap">
        <thead>
          <tr class="text-gray-500 uppercase tracking-widest text-[10px] border-b border-gray-800">
            <th class="pb-3 px-4">Fecha</th>
            <th class="pb-3 px-4">Usuario</th>
            <th class="pb-3 px-4">Película</th>
            <th class="pb-3 px-4">Puntuación</th>
            <th class="pb-3 px-4 w-1/3">Comentario</th>
            <th class="pb-3 px-4 text-right">Acción</th>
          </tr>
        </thead>
        <tbody id="tablaDatos"></tbody>
      </table>
    </div>
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

    // Función para dibujar las estrellas doradas
    function renderEstrellas(puntos) {
      let estrellas = '';
      for(let i = 1; i <= 5; i++) {
        estrellas += i <= puntos ? '<span class="text-yellow-500">★</span>' : '<span class="text-gray-700">★</span>';
      }
      return estrellas;
    }

    async function cargarTabla() {
      const res = await fetch('{{ route('criticas.index') }}', { headers: { 'Accept': 'application/json' } });
      const json = await res.json();
      const tbody = document.getElementById('tablaDatos');
      tbody.innerHTML = '';

      json.data.forEach(item => {
        const btnEliminar = `<button onclick="eliminarCritica(${item.id_critica})" class="text-red-500 hover:text-red-400 font-bold text-xs uppercase tracking-widest transition-colors">Borrar</button>`;

        tbody.innerHTML += `
            <tr class="border-b border-gray-800/50 hover:bg-gray-800/30 transition-colors">
                <td class="py-4 px-4 text-gray-500 text-xs italic">${item.fecha_publicacion}</td>
                <td class="py-4 px-4 font-bold text-blue-400">${item.usuario}</td>
                <td class="py-4 px-4 font-bold text-white">${item.pelicula}</td>
                <td class="py-4 px-4 text-lg">${renderEstrellas(item.puntuacion)}</td>
                <td class="py-4 px-4 text-gray-400 truncate max-w-xs" title="${item.comentario}">${item.comentario || 'Sin comentario'}</td>
                <td class="py-4 px-4 text-right">${btnEliminar}</td>
            </tr>`;
      });
    }

    async function eliminarCritica(id) {
      if(!confirm("¿Estás seguro de que deseas eliminar esta crítica PERMANENTEMENTE?")) return;

      const url = `/criticas/${id}`;
      const res = await fetch(url, { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }});
      const json = await res.json();
      mostrarMensaje(json.message, res.ok);
      if (res.ok) cargarTabla();
    }

    document.addEventListener('DOMContentLoaded', cargarTabla);
  </script>
</x-app-layout>