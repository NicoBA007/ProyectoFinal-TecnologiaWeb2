<div id="modalEditar"
  class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
  <div class="bg-gray-900 border border-gray-800 p-8 rounded-3xl w-full max-w-2xl shadow-2xl">
    <h3 class="text-white font-black mb-4 uppercase text-lg">Editar Película</h3>
    <form id="formEditar" onsubmit="actualizarData(event)" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <input type="hidden" id="edit_id">
      <input type="text" id="edit_titulo" required
        class="md:col-span-2 bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500">
      <select id="edit_id_clasificacion" required
        class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500">
        @foreach($clasificaciones as $c) <option value="{{ $c->id_clasificacion }}">{{ $c->codigo }}</option>
        @endforeach
      </select>
      <input type="number" id="edit_duracion_min" required
        class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500">
      <input type="date" id="edit_fecha_estreno" required
        class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500">
      <select id="edit_estado" required
        class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500">
        <option value="Proximamente">Próximamente</option>
        <option value="En Emision">En Emisión</option>
        <option value="Ya Emitida">Ya Emitida</option>
      </select>
      <input type="url" id="edit_poster_url" required
        class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500">
      <input type="url" id="edit_trailer_url"
        class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500">
      <textarea id="edit_sinopsis" required
        class="md:col-span-2 bg-black border-gray-800 rounded-lg text-sm text-white focus:border-blue-500"></textarea>

      <div class="md:col-span-2 flex justify-end gap-2 mt-2">
        <div class="md:col-span-1 bg-black border border-gray-800 p-4 rounded-lg">
          <label class="text-[10px] text-gray-500 uppercase tracking-widest font-bold block mb-2">Géneros</label>
          <div class="max-h-32 overflow-y-auto flex flex-col gap-2">
            @foreach($generos as $g)
              <label class="flex items-center space-x-2 text-sm text-gray-300 cursor-pointer hover:text-white">
                <input type="checkbox" name="edit_generos[]" value="{{ $g->id_genero }}"
                  class="text-blue-600 bg-gray-900 border-gray-700 rounded focus:ring-blue-600 chk-edit-genero">
                <span>{{ $g->nombre }}</span>
              </label>
            @endforeach
          </div>
        </div>

        <div class="md:col-span-1 bg-black border border-gray-800 p-4 rounded-lg">
          <label class="text-[10px] text-gray-500 uppercase tracking-widest font-bold block mb-2">Países de
            Origen</label>
          <div class="max-h-32 overflow-y-auto flex flex-col gap-2">
            @foreach($paises as $p)
              <label class="flex items-center space-x-2 text-sm text-gray-300 cursor-pointer hover:text-white">
                <input type="checkbox" name="edit_paises[]" value="{{ $p->id_pais_origen }}"
                  class="text-blue-600 bg-gray-900 border-gray-700 rounded focus:ring-blue-600 chk-edit-pais">
                <span>{{ $p->nombre }}</span>
              </label>
            @endforeach
          </div>
        </div>
        <button type="button" onclick="cerrarModal()"
          class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded-lg text-xs font-bold uppercase">Cancelar</button>
        <button type="submit"
          class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-xs font-bold uppercase text-white">Actualizar</button>
      </div>
    </form>
  </div>
</div>