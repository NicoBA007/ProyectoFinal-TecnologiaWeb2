<x-app-layout>
    <div class="py-12 bg-black min-h-screen text-gray-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">
                        Elenco de <span class="text-red-600">Actores</span>
                    </h2>
                    <p class="text-sm text-gray-500 uppercase tracking-widest font-bold">Gestión de reparto de
                        PrimeCinemas</p>
                </div>

                <a href="{{ route('actores.create') }}"
                    class="bg-red-600 hover:bg-red-700 text-white font-black py-3 px-8 rounded-xl transition-all transform hover:scale-105 shadow-lg shadow-red-900/40 uppercase text-sm">
                    + Registrar Actor
                </a>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-800/50 text-red-500 uppercase text-xs font-black tracking-widest border-b border-gray-800">
                            <th class="p-5">ID</th>
                            <th class="p-5">Nombre del Actor</th>
                            <th class="p-5">Nacionalidad</th>
                            <th class="p-5 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse ($actores as $actor)
                            <tr class="hover:bg-red-900/5 transition-colors group">
                                <td class="p-5 font-mono text-gray-500 text-sm italic">
                                    #{{ $actor->id_actor }}
                                </td>

                                <td class="p-5 text-white font-bold text-lg tracking-tight">
                                    {{ $actor->nombre_completo }}
                                </td>

                                <td class="p-5 text-gray-400">
                                    {{ $actor->nacionalidad }}
                                </td>

                                <td class="p-5 flex justify-center gap-3">
                                    <a href="{{ route('actores.edit', $actor->id_actor) }}"
                                        class="text-blue-400 hover:text-white border border-blue-500/20 hover:bg-blue-600 p-2 px-4 rounded-xl transition-all text-xs font-black uppercase tracking-widest">
                                        Editar
                                    </a>

                                    <form action="{{ route('actores.destroy', $actor->id_actor) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar a este integrante del elenco?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:text-white border border-red-500/20 hover:bg-red-600 p-2 px-4 rounded-xl transition-all text-xs font-black uppercase tracking-widest">
                                            Borrar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="p-20 text-center text-gray-600 uppercase font-black opacity-20">
                                    Sin Actores Registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-right">
                <p class="text-xs text-gray-600 font-mono uppercase">
                    Total de registros: {{ $actores->count() }}
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
