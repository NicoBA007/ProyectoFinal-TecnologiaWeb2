<x-admin-layout>
    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8 text-white relative">

        {{-- Alerta de Mensajes Estilizada --}}
        <div id="mensajeAlert"
            class="hidden mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center transition-all border shadow-lg">
        </div>

        {{-- SECCIÓN DE REGISTRO (Diseño Compacto y Formal) --}}
        <div class="bg-gray-950 border border-white/5 p-8 rounded-3xl mb-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full bg-red-600"></div>
            
            <div class="flex items-center gap-3 mb-6">
                <span class="text-xl">📥</span>
                <h3 class="text-white font-black uppercase tracking-[0.3em] text-xs">Registrar Nuevo Usuario</h3>
            </div>

            <form id="usuarioForm" onsubmit="guardarUsuario(event)" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <input type="text" id="nombres" placeholder="  Nombres" required
                    class="py-2 bg-black border-gray-800 rounded-lg text-[11px] font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 placeholder-gray-700 transition-all">
                
                <input type="text" id="apellido_paterno" placeholder="  Ap. Paterno" required
                    class="bg-black border-gray-800 rounded-lg text-[11px] font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 placeholder-gray-700 transition-all">
                
                <input type="text" id="apellido_materno" placeholder="  Ap. Materno"
                    class="bg-black border-gray-800 rounded-lg text-[11px] font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 placeholder-gray-700 transition-all">
                
                <input type="email" id="email" placeholder="  Email Corporativo" required
                    class="bg-black border-gray-800 rounded-lg text-[11px] font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 placeholder-gray-700 transition-all">
                
                <select id="rol" required
                    class="bg-black border-gray-800 rounded-lg text-[11px] font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 transition-all">
                    <option value="cliente">Cliente</option>
                    <option value="admin">Administrador</option>
                </select>

                <input type="password" id="password" placeholder="  Contraseña" required
                    class="bg-black border-gray-800 rounded-lg text-[11px] font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 placeholder-gray-700 transition-all">
                
                <input type="password" id="password_confirmation" placeholder="  Confirmar" required
                    class="bg-black border-gray-800 rounded-lg text-[11px] font-bold uppercase tracking-widest text-white focus:border-red-600 focus:ring-0 placeholder-gray-700 transition-all">

                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-black py-3 rounded-lg transition-all uppercase tracking-[0.2em] text-[10px] shadow-[0_10px_20px_rgba(220,38,38,0.2)]">
                    Guardar Registro
                </button>
            </form>
        </div>

        {{-- TABLA DE RESULTADOS (Read) --}}
        <div class="bg-gray-950 border border-white/5 rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                <h3 class="text-gray-400 font-black uppercase tracking-[0.3em] text-[10px]">Datos de los Usuarios</h3>
                <span class="text-[9px] font-mono text-gray-600">Registro PrimeCinemas</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-gray-600 uppercase tracking-[0.2em] text-[9px] bg-white/[0.01]">
                            <th class="py-4 px-6 border-b border-white/5">ID</th>
                            <th class="py-4 px-6 border-b border-white/5">Estado</th>
                            <th class="py-4 px-6 border-b border-white/5">Nombre Completo</th>
                            <th class="py-4 px-6 border-b border-white/5">Email</th>
                            <th class="py-4 px-6 border-b border-white/5">Rol</th>
                            <th class="py-4 px-6 border-b border-white/5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaUsuarios" class="divide-y divide-white/[0.03]">
                        </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL DE EDICIÓN (Update) --}}
        <div id="modalEditar"
            class="hidden fixed inset-0 bg-black/90 backdrop-blur-md z-[100] flex items-center justify-center p-4">
            <div class="bg-gray-950 border border-red-900/30 p-10 rounded-3xl w-full max-w-2xl shadow-[0_0_100px_rgba(220,38,38,0.1)] relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-red-600 to-transparent"></div>
                
                <h3 class="text-white font-black mb-8 uppercase text-xl tracking-tighter text-center">Actualizar <span class="text-red-600">Datos</span></h3>
                
                <form id="formEditar" onsubmit="actualizarUsuario(event)" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <input type="hidden" id="edit_id">
                    
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Nombres</label>
                        <input type="text" id="edit_nombres" required class="w-full py-2 bg-black border-gray-800 rounded-xl text-xs font-bold text-white focus:border-red-600 focus:ring-0 uppercase tracking-widest">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Apellido Paterno</label>
                        <input type="text" id="edit_apellido_paterno" required class="w-full py-2 bg-black border-gray-800 rounded-xl text-xs font-bold text-white focus:border-red-600 focus:ring-0 uppercase tracking-widest">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Apellido Materno</label>
                        <input type="text" id="edit_apellido_materno" class="w-full py-2 bg-black border-gray-800 rounded-xl text-xs font-bold text-white focus:border-red-600 focus:ring-0 uppercase tracking-widest">
                    </div>

                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Email</label>
                        <input type="email" id="edit_email" required class="w-full py-2 bg-black border-gray-800 rounded-xl text-xs font-bold text-white focus:border-red-600 focus:ring-0">
                    </div>

                    <div class="sm:col-span-2 space-y-1">
                        <label class="text-[9px] font-black text-gray-500 uppercase ml-1">Rol</label>
                        <select id="edit_rol" required class="w-full bg-black border-gray-800 rounded-xl text-xs font-bold text-white focus:border-red-600 focus:ring-0 uppercase tracking-widest">
                            <option value="cliente">Cliente</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2 bg-red-950/10 border border-red-900/20 p-5 rounded-2xl mt-4">
                        <p class="text-[9px] text-red-500 uppercase tracking-[0.2em] mb-4 font-black">Cambiar Contraseña</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <input type="password" id="edit_password" placeholder="Nueva Password"
                                class="bg-black py-1 border-gray-800 rounded-lg text-xs text-white focus:border-red-600 focus:ring-0 tracking-widest">
                            <input type="password" id="edit_password_confirmation" placeholder="Confirmar"
                                class="bg-black py-1 border-gray-800 rounded-lg text-xs text-white focus:border-red-600 focus:ring-0 tracking-widest">
                        </div>
                    </div>

                    <div class="sm:col-span-2 flex justify-end gap-3 mt-6">
                        <button type="button" onclick="cerrarModal()"
                            class="px-6 py-3 bg-gray-900 hover:bg-gray-800 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Cancelar</button>
                        <button type="submit"
                            class="px-8 py-3 bg-red-600 hover:bg-red-700 rounded-xl text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-red-900/20 transition-all">Actualizar</button>
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
            alertBox.classList.remove('hidden');
            alertBox.className = `mb-6 p-4 rounded-xl font-black uppercase tracking-[0.2em] text-[10px] text-center transition-all border ${esExito ? 'bg-green-600/10 text-green-500 border-green-600/20' : 'bg-red-600/10 text-red-600 border-red-600/20'}`;
            setTimeout(() => alertBox.classList.add('hidden'), 4000);
        }

        async function cargarUsuarios() {
            const res = await fetch('{{ route('usuarios.index') }}', { headers: { 'Accept': 'application/json' } });
            const json = await res.json();
            const tbody = document.getElementById('tablaUsuarios');
            tbody.innerHTML = '';

            json.data.forEach(u => {
                const estadoHTML = u.activo
                    ? `<div class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></div><span class="text-green-500 text-[9px] font-black tracking-widest">SISTEMA: ACTIVO</span></div>`
                    : `<div class="flex items-center gap-2"><div class="w-1.5 h-1.5 rounded-full bg-red-600"></div><span class="text-red-600 text-[9px] font-black tracking-widest">SISTEMA: INACTIVO</span></div>`;

                const btnEditar = `<button onclick="abrirModal(${u.id_usuario}, '${u.nombres}', '${u.apellido_paterno}', '${u.apellido_materno || ''}', '${u.email}', '${u.rol}')" class="text-gray-400 hover:text-white font-black text-[10px] uppercase tracking-tighter mr-4 transition-colors">Editar</button>`;

                const btnEstado = u.activo
                    ? `<button onclick="desactivarUsuario(${u.id_usuario})" class="text-red-900 hover:text-red-600 font-black text-[10px] uppercase tracking-tighter transition-colors">Baja</button>`
                    : `<button onclick="reactivarUsuario(${u.id_usuario})" class="text-green-900 hover:text-green-500 font-black text-[10px] uppercase tracking-tighter transition-colors">Alta</button>`;

                tbody.innerHTML += `
                    <tr class="hover:bg-white/[0.02] transition-colors ${!u.activo ? 'bg-red-950/5' : ''}">
                        <td class="py-5 px-6 font-mono text-[10px] text-gray-600">#${String(u.id_usuario).padStart(4, '0')}</td>
                        <td class="py-5 px-6">${estadoHTML}</td>
                        <td class="py-5 px-6">
                            <div class="flex flex-col">
                                <span class="font-black text-white text-xs uppercase tracking-tight">${u.nombre_completo}</span>
                                <span class="text-[9px] text-gray-600 uppercase font-bold tracking-[0.1em]">Internal Operator</span>
                            </div>
                        </td>
                        <td class="py-5 px-6 text-gray-500 font-medium text-[11px]">${u.email}</td>
                        <td class="py-5 px-6">
                            <span class="bg-white/5 border border-white/10 text-gray-300 text-[9px] font-black px-2 py-1 rounded uppercase tracking-[0.2em]">
                                ${u.rol}
                            </span>
                        </td>
                        <td class="py-5 px-6 text-right">${btnEditar} ${btnEstado}</td>
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
            mostrarMensaje(json.message || (res.ok ? "Registro Exitoso" : "Error de Parámetros"), res.ok);

            if (res.ok) {
                document.getElementById('usuarioForm').reset();
                cargarUsuarios();
            }
        }

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

            const pass = document.getElementById('edit_password').value;
            if (pass !== "") {
                data.password = pass;
                data.password_confirmation = document.getElementById('edit_password_confirmation').value;
            }

            const url = '{{ route("usuarios.update", ":id") }}'.replace(':id', id);
            const res = await fetch(url, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify(data)
            });

            const json = await res.json();
            mostrarMensaje(json.message || (res.ok ? "Base de datos actualizada" : "Error en proceso"), res.ok);

            if (res.ok) {
                cerrarModal();
                cargarUsuarios();
            }
        }

        async function desactivarUsuario(id) {
            if (!confirm("CONFIRMACIÓN DE SEGURIDAD: ¿Revocar acceso al usuario?")) return;
            const url = '{{ route("usuarios.destroy", ":id") }}'.replace(':id', id);
            const res = await fetch(url, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const json = await res.json();
            mostrarMensaje(json.message || "Baja procesada", res.ok);
            if (res.ok) cargarUsuarios();
        }

        async function reactivarUsuario(id) {
            const url = '{{ route("usuarios.reactivar", ":id") }}'.replace(':id', id);
            const res = await fetch(url, {
                method: 'PATCH',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const json = await res.json();
            mostrarMensaje(json.message || "Acceso restaurado", res.ok);
            if (res.ok) cargarUsuarios();
        }

        document.addEventListener('DOMContentLoaded', cargarUsuarios);
    </script>
</x-admin-layout>