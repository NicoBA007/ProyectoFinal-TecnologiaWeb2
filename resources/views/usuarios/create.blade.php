<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-900 border border-gray-800 shadow-2xl sm:rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-gray-800 bg-gray-800/50">
                    <h2 class="text-2xl font-black text-white tracking-tight">
                        Registrar <span class="text-red-600">Nuevo Usuario</span>
                    </h2>
                    <p class="text-sm text-gray-400 mt-1">Completa los datos para dar acceso al sistema.</p>
                </div>

                <form action="{{ route('usuarios.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <div>
                        <label for="name"
                            class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-2">Nombre
                            Completo</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl"
                            placeholder="Ej. Juan Pérez">
                        @error('name') <span class="text-red-500 text-sm font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="email"
                            class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-2">Correo
                            Electrónico</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl"
                            placeholder="ejemplo@correo.com">
                        @error('email') <span class="text-red-500 text-sm font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="rol"
                            class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-2">Rol del
                            Sistema</label>
                        <select name="rol" id="rol" required
                            class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl">
                            <option value="cliente">Cliente (Solo lee cartelera)</option>
                            <option value="admin">Administrador (Control total)</option>
                        </select>
                        @error('rol') <span class="text-red-500 text-sm font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password"
                                class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-2">Contraseña</label>
                            <input type="password" name="password" id="password" required
                                class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl">
                            @error('password') <span
                            class="text-red-500 text-sm font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-bold text-gray-300 uppercase tracking-widest mb-2">Confirmar
                                Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="block w-full bg-gray-800 border-gray-700 text-white focus:ring-red-600 focus:border-red-600 rounded-xl">
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-800 mt-6">
                        <a href="{{ route('usuarios.index') }}"
                            class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-xl transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-black rounded-xl shadow-[0_0_15px_rgba(220,38,38,0.4)] hover:shadow-[0_0_25px_rgba(220,38,38,0.6)] transition-all transform hover:-translate-y-1">
                            GUARDAR USUARIO
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>