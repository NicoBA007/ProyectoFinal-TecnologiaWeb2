<x-app-layout>
  <x-slot name="header">
    <h2 class="font-black text-2xl text-white tracking-tight uppercase">
      Gestión de <span class="text-red-600">Usuarios (AJAX)</span>
    </h2>
  </x-slot>

  <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 text-white relative">

    <div id="mensajeAlert"
      class="hidden mb-6 p-4 rounded-xl font-bold uppercase tracking-widest text-sm text-center transition-all"></div>

    {{-- FORMULARIO DE INGRESO (Create) --}}
    <div class="bg-gray-900 p-8 rounded-3xl mb-8 border border-gray-800 shadow-2xl">
      <h3 class="text-gray-400 font-bold mb-4 uppercase tracking-widest text-xs">Registrar Nuevo Usuario</h3>
      <form id="usuarioForm" onsubmit="guardarUsuario(event)"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <input type="text" id="nombres" placeholder="Nombres" required
          class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600 focus:ring-red-600">
        <input type="text" id="apellido_paterno" placeholder="Ap. Paterno" required
          class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600 focus:ring-red-600">
        <input type="text" id="apellido_materno" placeholder="Ap. Materno"
          class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600 focus:ring-red-600">
        <input type="email" id="email" placeholder="Correo Electrónico" required
          class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600 focus:ring-red-600">
        <select id="rol" required
          class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600 focus:ring-red-600">
          <option value="cliente">Cliente</option>
          <option value="admin">Administrador</option>
        </select>
        <input type="password" id="password" placeholder="Contraseña" required
          class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600 focus:ring-red-600">
        <input type="password" id="password_confirmation" placeholder="Confirmar Contraseña" required
          class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600 focus:ring-red-600">
        <div class="md:col-span-2">
          <button type="submit"
            class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-2 rounded-lg transition-all uppercase tracking-widest text-sm shadow-[0_0_15px_rgba(220,38,38,0.3)]">Guardar
            Usuario</button>
        </div>
      </form>
    </div>

    {{-- TABLA DE RESULTADOS (Read) --}}
    <div class="bg-gray-900 p-8 rounded-3xl border border-gray-800 shadow-2xl overflow-x-auto">
      <table class="w-full text-left text-sm whitespace-nowrap">
        <thead>
          <tr class="text-gray-500 uppercase tracking-widest text-[10px] border-b border-gray-800">
            <th class="pb-3 px-4">Estado</th>
            <th class="pb-3 px-4">Nombre Completo</th>
            <th class="pb-3 px-4">Email</th>
            <th class="pb-3 px-4">Rol</th>
            <th class="pb-3 px-4 text-right">Acciones</th>
          </tr>
        </thead>
        <tbody id="tablaUsuarios"></tbody>
      </table>
    </div>

    {{-- MODAL DE EDICIÓN (Update) --}}
    <div id="modalEditar"
      class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
      <div class="bg-gray-900 border border-gray-800 p-8 rounded-3xl w-full max-w-2xl shadow-2xl">
        <h3 class="text-white font-black mb-4 uppercase text-lg">Editar Usuario</h3>
        <form id="formEditar" onsubmit="actualizarUsuario(event)" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <input type="hidden" id="edit_id">
          <input type="text" id="edit_nombres" placeholder="Nombres" required
            class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500 focus:ring-blue-500">
          <input type="text" id="edit_apellido_paterno" placeholder="Ap. Paterno" required
            class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500 focus:ring-blue-500">
          <input type="text" id="edit_apellido_materno" placeholder="Ap. Materno"
            class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500 focus:ring-blue-500">
          <input type="email" id="edit_email" placeholder="Correo" required
            class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500 focus:ring-blue-500">
          <select id="edit_rol" required
            class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500 focus:ring-blue-500">
            <option value="cliente">Cliente</option>
            <option value="admin">Administrador</option>
          </select>
          <div class="sm:col-span-2 border-t border-gray-800 mt-2 pt-4">
            <p class="text-[10px] text-yellow-500 uppercase tracking-widest mb-2 font-bold">Cambiar Contraseña
              (Opcional)</p>
            <div class="grid grid-cols-2 gap-4">
              <input type="password" id="edit_password" placeholder="Nueva Contraseña"
                class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500 focus:ring-blue-500">
              <input type="password" id="edit_password_confirmation" placeholder="Confirmar Nueva"
                class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500 focus:ring-blue-500">
            </div>
          </div>
          <div class="sm:col-span-2 flex justify-end gap-2 mt-4">
            <button type="button" onclick="cerrarModal()"
              class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-xs font-bold uppercase tracking-widest">Cancelar</button>
            <button type="submit"
              class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-xs font-bold uppercase tracking-widest text-white shadow-[0_0_15px_rgba(37,99,235,0.4)]">Actualizar</button>
          </div>
        </form>
      </div>
    </div>

  </div>

  <script>
    const csrfToken = '{{ csrf_token() }}';

    function mostrarMensaje(msg, esExito) {
      const alertBox = document.getElementById('mensajeAlert');
      alertBox.textContent = msg;
      alertBox.className = `mb-6 p-4 rounded-xl font-bold uppercase tracking-widest text-sm text-center transition-all border ${esExito ? 'bg-green-500/20 text-green-500 border-green-500/30' : 'bg-red-500/20 text-red-500 border-red-500/30'}`;
      setTimeout(() => alertBox.classList.add('hidden'), 5000); // Ocultar después de 5 seg
    }

    async function cargarUsuarios() {
      const res = await fetch('{{ route('usuarios.index') }}', { headers: { 'Accept': 'application/json' } });
      const json = await res.json();
      const tbody = document.getElementById('tablaUsuarios');
      tbody.innerHTML = '';

      json.data.forEach(u => {
        const estadoHTML = u.activo
          ? `<span class="text-green-500 text-xs font-black">ACTIVO</span>`
          : `<span class="text-red-500 text-xs font-black">INACTIVO</span>`;

        // ¡AQUÍ ESTABA EL DETALLE! Esta línea se había borrado
        const btnEditar = `<button onclick="abrirModal(${u.id_usuario}, '${u.nombres}', '${u.apellido_paterno}', '${u.apellido_materno || ''}', '${u.email}', '${u.rol}')" class="text-blue-500 hover:text-blue-400 font-bold text-xs uppercase tracking-widest mr-3 transition-colors">Editar</button>`;

        // Botones de acción de estado
        const btnEstado = u.activo
          ? `<button onclick="desactivarUsuario(${u.id_usuario})" class="text-red-500 hover:text-red-400 font-bold text-xs uppercase tracking-widest transition-colors">Desactivar</button>`
          : `<button onclick="reactivarUsuario(${u.id_usuario})" class="text-green-500 hover:text-green-400 font-bold text-xs uppercase tracking-widest transition-colors">Reactivar</button>`;

        tbody.innerHTML += `
            <tr class="border-b border-gray-800/50 hover:bg-gray-800/30 transition-colors ${!u.activo ? 'opacity-50' : ''}">
                <td class="py-4 px-4">${estadoHTML}</td>
                <td class="py-4 px-4 font-bold text-white">${u.nombre_completo}</td>
                <td class="py-4 px-4 text-gray-400">${u.email}</td>
                <td class="py-4 px-4"><span class="bg-gray-800 text-gray-300 text-[10px] font-black px-2 py-1 rounded uppercase tracking-widest">${u.rol}</span></td>
                <td class="py-4 px-4 text-right">${btnEditar} ${btnEstado}</td>
            </tr>`;
      });
    }

    async function guardarUsuario(e) {
      e.preventDefault();
      const data = {
        nombres: document.getElementById('nombres').value,
        apellido_paterno: document.getElementById('apellido_paterno').value,
        apellido_materno: document.getElementById('apellido_materno').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        password_confirmation: document.getElementById('password_confirmation').value,
        rol: document.getElementById('rol').value,
      };

      const res = await fetch('{{ route('usuarios.store') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify(data)
      });
      const json = await res.json();
      mostrarMensaje(json.message || (res.ok ? "Guardado" : "Error de validación"), res.ok);

      if (res.ok) {
        document.getElementById('usuarioForm').reset();
        cargarUsuarios();
      }
    }

    // --- NUEVAS FUNCIONES PARA EDITAR Y ELIMINAR ---

    function abrirModal(id, nombres, paterno, materno, email, rol) {
      document.getElementById('edit_id').value = id;
      document.getElementById('edit_nombres').value = nombres;
      document.getElementById('edit_apellido_paterno').value = paterno;
      document.getElementById('edit_apellido_materno').value = materno;
      document.getElementById('edit_email').value = email;
      document.getElementById('edit_rol').value = rol;
      document.getElementById('edit_password').value = '';
      document.getElementById('edit_password_confirmation').value = '';

      document.getElementById('modalEditar').classList.remove('hidden');
    }

    function cerrarModal() {
      document.getElementById('modalEditar').classList.add('hidden');
    }

    async function actualizarUsuario(e) {
      e.preventDefault();
      const id = document.getElementById('edit_id').value;
      const data = {
        nombres: document.getElementById('edit_nombres').value,
        apellido_paterno: document.getElementById('edit_apellido_paterno').value,
        apellido_materno: document.getElementById('edit_apellido_materno').value,
        email: document.getElementById('edit_email').value,
        rol: document.getElementById('edit_rol').value,
      };

      // Solo enviamos la contraseña si el usuario escribió algo
      const pass = document.getElementById('edit_password').value;
      if (pass !== "") {
        data.password = pass;
        data.password_confirmation = document.getElementById('edit_password_confirmation').value;
      }

      const url = '{{ route("usuarios.update", ":id") }}'.replace(':id', id);

      const res = await fetch(url, {
        method: 'PUT', // Método de actualización
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify(data)
      });

      const json = await res.json();
      mostrarMensaje(json.message || (res.ok ? "Actualizado" : "Error al actualizar"), res.ok);

      if (res.ok) {
        cerrarModal();
        cargarUsuarios();
      }
    }

    async function desactivarUsuario(id) {
      if (!confirm("¿Estás seguro de que deseas desactivar a este usuario? Ya no podrá acceder al sistema.")) return;

      const url = '{{ route("usuarios.destroy", ":id") }}'.replace(':id', id);
      const res = await fetch(url, {
        method: 'DELETE', // Método de eliminación
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
      });

      const json = await res.json();
      mostrarMensaje(json.message || "Usuario desactivado", res.ok);
      if (res.ok) cargarUsuarios();
    }
    async function reactivarUsuario(id) {
      if (!confirm("¿Estás seguro de que deseas reactivar a este usuario? Volverá a tener acceso al sistema.")) return;

      const url = '{{ route("usuarios.reactivar", ":id") }}'.replace(':id', id);
      const res = await fetch(url, {
        method: 'PATCH',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
      });

      const json = await res.json();
      mostrarMensaje(json.message || "Usuario reactivado", res.ok);
      if (res.ok) cargarUsuarios();
    }

    document.addEventListener('DOMContentLoaded', cargarUsuarios);
  </script>
</x-app-layout>