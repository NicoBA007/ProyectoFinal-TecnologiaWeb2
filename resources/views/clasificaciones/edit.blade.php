<div id="modalEditar" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 p-8 rounded-3xl w-full max-w-md shadow-2xl">
        <h3 class="text-white font-black mb-4 uppercase text-lg">Editar Clasificación</h3>
        <form id="formEditar" onsubmit="actualizarData(event)" class="flex flex-col gap-4">
            <input type="hidden" id="edit_id">
            <input type="text" id="edit_codigo" placeholder="CÓDIGO" required class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500 focus:ring-blue-500">
            <input type="text" id="edit_descripcion" placeholder="Descripción" required class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500 focus:ring-blue-500">
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="cerrarModal()" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-xs font-bold uppercase tracking-widest">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-xs font-bold uppercase tracking-widest text-white">Actualizar</button>
            </div>
        </form>
    </div>
</div>