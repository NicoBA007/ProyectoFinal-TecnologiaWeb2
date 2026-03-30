<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use Illuminate\Http\Request;

class ClasificacionController extends Controller
{
    public function index()
    {
        $clasificaciones = Clasificacion::orderBy('codigo', 'asc')->get();
        return view('clasificaciones.index', compact('clasificaciones'));
    }

    public function create()
    {
        return view('clasificaciones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:10|unique:clasificacion,codigo',
            'descripcion' => 'required|string|max:100',
            'activo' => 'required|boolean'
        ]);

        Clasificacion::create($request->all());

        return redirect()->route('clasificaciones.index')->with('success', 'Clasificación registrada exitosamente.');
    }

    public function edit($id)
    {
        $clasificacion = Clasificacion::findOrFail($id);
        return view('clasificaciones.edit', compact('clasificacion'));
    }

    public function update(Request $request, $id)
    {
        $clasificacion = Clasificacion::findOrFail($id);

        $request->validate([
            'codigo' => 'required|string|max:10|unique:clasificacion,codigo,' . $clasificacion->id_clasificacion . ',id_clasificacion',
            'descripcion' => 'required|string|max:100',
            'activo' => 'required|boolean'
        ]);

        $clasificacion->update($request->all());

        return redirect()->route('clasificaciones.index')->with('success', 'Clasificación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $clasificacion = Clasificacion::findOrFail($id);
        $clasificacion->activo = !$clasificacion->activo;
        $clasificacion->save();

        $mensaje = $clasificacion->activo ? 'Clasificación activada.' : 'Clasificación desactivada.';
        return redirect()->route('clasificaciones.index')->with('success', $mensaje);
    }
}