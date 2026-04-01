<div class="bg-gray-900 p-8 rounded-3xl mb-8 border border-gray-800 shadow-2xl">
  <h3 class="text-gray-400 font-bold mb-4 uppercase tracking-widest text-xs">Registrar Película</h3>
  <form id="formCrear" onsubmit="guardarData(event)" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
    <input type="text" id="titulo" placeholder="Título" required
      class="md:col-span-2 bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600">
    <select id="id_clasificacion" required
      class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600">
      <option value="">Clasificación...</option>
      @foreach($clasificaciones as $c) <option value="{{ $c->id_clasificacion }}">{{ $c->codigo }}</option> @endforeach
    </select>
    <input type="number" id="duracion_min" placeholder="Minutos" required
      class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600">

    <input type="date" id="fecha_estreno" required
      class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600">
    <select id="estado" required class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600">
      <option value="Proximamente">Próximamente</option>
      <option value="En Emision">En Emisión</option>
      <option value="Ya Emitida">Ya Emitida</option>
    </select>
    <input type="url" id="poster_url" placeholder="URL Póster" required
      class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600">
    <input type="url" id="trailer_url" placeholder="URL Tráiler"
      class="bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600">

    <textarea id="sinopsis" placeholder="Sinopsis..." required
      class="md:col-span-4 bg-black border-gray-800 rounded-lg text-sm text-white focus:border-red-600"></textarea>
    <div class="md:col-span-2 bg-black border border-gray-800 p-4 rounded-lg">
      <label class="text-[10px] text-gray-500 uppercase tracking-widest font-bold block mb-2">Géneros</label>
      <div class="max-h-32 overflow-y-auto grid grid-cols-2 gap-2">
        @foreach($generos as $g)
          <label class="flex items-center space-x-2 text-sm text-gray-300 cursor-pointer hover:text-white">
            <input type="checkbox" name="generos[]" value="{{ $g->id_genero }}"
              class="text-purple-600 bg-gray-900 border-gray-700 rounded focus:ring-purple-600">
            <span>{{ $g->nombre }}</span>
          </label>
        @endforeach
      </div>
    </div>

    <div class="md:col-span-2 bg-black border border-gray-800 p-4 rounded-lg">
      <label class="text-[10px] text-gray-500 uppercase tracking-widest font-bold block mb-2">Países de Origen</label>
      <div class="max-h-32 overflow-y-auto grid grid-cols-2 gap-2">
        @foreach($paises as $p)
          <label class="flex items-center space-x-2 text-sm text-gray-300 cursor-pointer hover:text-white">
            <input type="checkbox" name="paises[]" value="{{ $p->id_pais_origen }}"
              class="text-purple-600 bg-gray-900 border-gray-700 rounded focus:ring-purple-600">
            <span>{{ $p->nombre }}</span>
          </label>
        @endforeach
      </div>
    </div>
    <button type="submit"
      class="md:col-span-4 bg-purple-600 hover:bg-purple-700 text-white font-black py-2 rounded-lg transition-all uppercase tracking-widest text-sm">Guardar
      Película</button>
  </form>
</div>