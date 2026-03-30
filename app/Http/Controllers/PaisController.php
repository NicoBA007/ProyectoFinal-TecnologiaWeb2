<?php

namespace App\Http\Controllers;

use App\Models\Pais; // Usando el nombre exacto de tu modelo
use Illuminate\Http\Request;

class PaisController extends Controller
{
    public function index()
    {
        $paises = Pais::orderBy('nombre', 'asc')->get();
        return view('paises.index', compact('paises'));
    }

    public function create()
    {
        return view('paises.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:pais_origen,nombre',
            'activo' => 'required|boolean'
        ]);

        Pais::create($request->all());

        return redirect()->route('paises.index')->with('success', 'País registrado exitosamente.');
    }

    public function edit($id)
    {
        $pais = Pais::findOrFail($id);
        return view('paises.edit', compact('pais'));
    }

    public function update(Request $request, $id)
    {
        $pais = Pais::findOrFail($id);

        $request->validate([
            // Asegúrate de que el modelo Pais tenga configurado $primaryKey = 'id_pais_origen';
            'nombre' => 'required|string|max:100|unique:pais_origen,nombre,' . $pais->id_pais_origen . ',id_pais_origen',
            'activo' => 'required|boolean'
        ]);

        $pais->update($request->all());

        return redirect()->route('paises.index')->with('success', 'País actualizado correctamente.');
    }

    public function destroy($id)
    {
        $pais = Pais::findOrFail($id);
        $pais->activo = !$pais->activo;
        $pais->save();

        $mensaje = $pais->activo ? 'País activado.' : 'País desactivado.';
        return redirect()->route('paises.index')->with('success', $mensaje);
    }
}