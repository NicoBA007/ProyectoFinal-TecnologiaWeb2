<div id="modalElenco"
  class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
  <div
    class="bg-gray-900 border border-gray-800 p-8 rounded-3xl w-full max-w-4xl shadow-2xl flex flex-col max-h-[90vh]">

    <div class="flex justify-between items-center mb-6 border-b border-gray-800 pb-4">
      <h3 class="text-white font-black uppercase text-lg">Elenco: <span id="elenco_titulo_pelicula"
          class="text-red-500"></span></h3>
      <button onclick="cerrarModalElenco()" class="text-gray-500 hover:text-white font-bold text-xl">&times;</button>
    </div>

    <div class="bg-black/50 p-4 rounded-xl border border-gray-800 mb-6">
      <form id="formAgregarElenco" onsubmit="guardarElenco(event)"
        class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <input type="hidden" id="elenco_id_pelicula">

        <div class="md:col-span-1">
          <label class="text-[10px] text-gray-500 uppercase tracking-widest font-bold block mb-1">Talento</label>
          <select id="elenco_id_persona" required
            class="w-full bg-gray-900 border-gray-700 rounded-lg text-sm text-white focus:border-red-600">
          </select>
        </div>

        <div class="md:col-span-1">
          <label class="text-[10px] text-gray-500 uppercase tracking-widest font-bold block mb-1">Rol</label>
          <select id="elenco_rol" required
            class="w-full bg-gray-900 border-gray-700 rounded-lg text-sm text-white focus:border-red-600">
            <option value="Actor">Actor / Actriz</option>
            <option value="Director">Director</option>
            <option value="Productor">Productor</option>
            <option value="Guionista">Guionista</option>
          </select>
        </div>

        <div class="md:col-span-1">
          <label class="text-[10px] text-gray-500 uppercase tracking-widest font-bold block mb-1">Personaje
            (Opcional)</label>
          <input type="text" id="elenco_personaje" placeholder="Ej: Paul Atreides"
            class="w-full bg-gray-900 border-gray-700 rounded-lg text-sm text-white focus:border-red-600">
        </div>

        <div class="md:col-span-1">
          <button type="submit"
            class="w-full bg-red-600 hover:bg-red-700 text-white font-black py-2 rounded-lg transition-all uppercase tracking-widest text-xs shadow-[0_0_15px_rgba(220,38,38,0.3)]">Añadir</button>
        </div>
      </form>
    </div>

    <div class="overflow-y-auto flex-1 border border-gray-800 rounded-xl">
      <table class="w-full text-left text-sm whitespace-nowrap">
        <thead class="sticky top-0 bg-gray-900">
          <tr class="text-gray-500 uppercase tracking-widest text-[10px] border-b border-gray-800">
            <th class="py-3 px-4">Talento</th>
            <th class="py-3 px-4">Rol en Película</th>
            <th class="py-3 px-4">Personaje</th>
            <th class="py-3 px-4 text-right">Acción</th>
          </tr>
        </thead>
        <tbody id="tablaElenco">
        </tbody>
      </table>
    </div>

  </div>
</div>