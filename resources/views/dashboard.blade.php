<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-gray-900 border border-gray-800 overflow-hidden shadow-lg sm:rounded-2xl mb-8">
                <div class="p-8 text-gray-300 text-lg flex items-center gap-4">
                    <span class="text-4xl">🎬</span>
                    <div>
                        <strong class="text-white">Panel de Administración</strong> <br>
                        <span class="text-sm text-gray-400">Listado oficial de usuarios registrados en el sistema.</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 shadow-2xl sm:rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-400">
                        <thead class="text-xs text-gray-300 uppercase bg-gray-800/80 border-b border-gray-700">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Usuario</th>
                                <th class="px-6 py-4">Correo</th>
                                <th class="px-6 py-4">Rol</th>
                                <th class="px-6 py-4 text-center">Fecha de Registro</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach ($usuarios as $usuario)
                                <tr class="hover:bg-red-900/10 transition-colors">
                                    <td class="px-6 py-4 font-mono text-red-500 font-bold">
                                        #{{ $usuario->id_usuario }}
                                    </td>

                                    <td class="px-6 py-4 text-white font-semibold uppercase tracking-tight">
                                        {{ $usuario->name }}
                                    </td>

                                    <td class="px-6 py-4 italic">
                                        {{ $usuario->email }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($usuario->rol == 'admin')
                                            <span
                                                class="px-3 py-1 bg-red-600/20 text-red-500 text-[10px] font-black uppercase rounded-full border border-red-600/50">
                                                {{ $usuario->rol }}
                                    </td>
                                @else
                                    <span
                                        class="px-3 py-1 bg-gray-800 text-gray-400 text-[10px] font-black uppercase rounded-full border border-gray-700">
                                        {{ $usuario->rol }}
                                    </span>
                            @endif
                            </td>

                            <td class="px-6 py-4 text-center text-xs font-mono text-gray-500">
                                {{ $usuario->fecha_registro }}
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
