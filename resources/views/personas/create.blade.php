<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-gray-800 p-8 rounded-2xl shadow-2xl">

                <h2 class="text-2xl font-black text-white mb-6 uppercase tracking-tighter">
                    Registrar Nuevo Talento
                </h2>

                <form action="{{ route('personas.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-gray-500 text-xs font-bold mb-2 uppercase">Nombre Completo</label>
                        <input type="text" name="nombre_completo" value="{{ old('nombre_completo') }}"
                            class="w-full bg-gray-800 border-gray-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-red-600 outline-none transition-all"
                            required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-500 text-xs font-bold mb-2 uppercase">URL de la Foto</label>
                        <input type="url" name="foto_url" value="{{ old('foto_url') }}"
                            placeholder="https://ejemplo.com/foto.jpg"
                            class="w-full bg-gray-800 border-gray-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-red-600 outline-none transition-all"
                            required>
                    </div>

                    <div class="mb-8">
                        <label class="block text-gray-500 text-xs font-bold mb-2 uppercase">Estado en el sistema</label>
                        <select name="activo" class="w-full bg-gray-800 border-gray-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-red-600 outline-none transition-all" required>
                            <option value="1" {{ old('activo', 1) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('activo', 1) == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white font-black py-3 rounded-xl transition-all shadow-lg shadow-red-900/20">
                            AÑADIR AL ELENCO
                        </button>
                        <a href="{{ route('personas.index') }}"
                            class="px-6 py-3 border border-gray-700 text-gray-400 font-bold text-xs tracking-widest uppercase rounded-xl hover:bg-gray-800 transition-all flex items-center justify-center">
                            CANCELAR
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>