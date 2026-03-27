<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-900 border border-gray-800 shadow-2xl sm:rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-gray-800 bg-gray-800/50">
                    <h2 class="text-2xl font-black text-white tracking-tight uppercase">
                        Editar <span class="text-blue-500">Usuario</span>
                    </h2>
                    <p class="text-sm text-gray-400 mt-1 uppercase tracking-widest text-[10px] font-bold">
                        Modificando a:
                        <strong class="text-blue-400">{{ $usuario->nombres }} {{ $usuario->apellido_paterno }}</strong>
                    </p>
                </div>

                <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label for="nombres"
                                class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-2">Nombres</label>
                            <input type="text" name="nombres" id="nombres"
                                value="{{ old('nombres', $usuario->nombres) }}" required
                                class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-blue-500 focus:border-blue-500 rounded-xl">
                            @error('nombres') <span
                            class="text-red-500 text-sm font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="apellido_paterno"
                                    class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-2">Apellido
                                    Paterno</label>
                                <input type="text" name="apellido_paterno" id="apellido_paterno"
                                    value="{{ old('apellido_paterno', $usuario->apellido_paterno) }}" required
                                    class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-blue-500 focus:border-blue-500 rounded-xl">
                                @error('apellido_paterno') <span
                                class="text-red-500 text-sm font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="apellido_materno"
                                    class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-2">Apellido
                                    Materno</label>
                                <input type="text" name="apellido_materno" id="apellido_materno"
                                    value="{{ old('apellido_materno', $usuario->apellido_materno) }}"
                                    class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-blue-500 focus:border-blue-500 rounded-xl">
                                @error('apellido_materno') <span
                                class="text-red-500 text-sm font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email"
                                class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-2">Correo
                                Electrónico</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}"
                                required
                                class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-blue-500 focus:border-blue-500 rounded-xl">
                            @error('email') <span
                            class="text-red-500 text-sm font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="rol"
                                class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-2">Rol del
                                Sistema</label>
                            <select name="rol" id="rol" required
                                class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-blue-500 focus:border-blue-500 rounded-xl">
                                <option value="cliente" {{ (old('rol', $usuario->rol) == 'cliente') ? 'selected' : '' }}>
                                    Cliente (Solo lee cartelera)</option>
                                <option value="admin" {{ (old('rol', $usuario->rol) == 'admin') ? 'selected' : '' }}>
                                    Administrador (Control total)</option>
                            </select>
                            @error('rol') <span class="text-red-500 text-sm font-bold mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="p-4 bg-gray-800/30 border border-gray-700 rounded-xl">
                        <p class="text-[10px] text-yellow-500 font-black uppercase mb-4 tracking-[0.2em]">⚠️ Zona de
                            Seguridad - Dejar en blanco para mantener actual</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-xs font-bold text-gray-400 mb-2 uppercase">Nueva
                                    Contraseña</label>
                                <input type="password" name="password" id="password"
                                    class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-blue-500 focus:border-blue-500 rounded-xl">
                                @error('password') <span
                                class="text-red-500 text-sm font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-xs font-bold text-gray-400 mb-2 uppercase">Confirmar Nueva</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-blue-500 focus:border-blue-500 rounded-xl">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-800 mt-6">
                        <a href="{{ route('usuarios.index') }}"
                            class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-xl transition-colors uppercase text-xs tracking-widest">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-[0_0_15px_rgba(59,130,246,0.4)] hover:shadow-[0_0_25px_rgba(59,130,246,0.6)] transition-all transform hover:-translate-y-1 uppercase text-xs tracking-widest">
                            ACTUALIZAR DATOS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>