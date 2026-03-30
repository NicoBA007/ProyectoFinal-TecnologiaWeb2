<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    public function index()
    {
        $generos = Genero::orderBy('nombre', 'asc')->get();
        return view('generos.index', compact('generos'));
    }

    public function create()
    {
        return view('generos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:80|unique:genero,nombre',
            'activo' => 'required|boolean'
        ]);

        Genero::create($request->all());

        return redirect()->route('generos.index')->with('success', 'Género registrado exitosamente.');
    }

    public function edit($id)
    {
        $genero = Genero::findOrFail($id);
        return view('generos.edit', compact('genero'));
    }

    public function update(Request $request, $id)
    {
        $genero = Genero::findOrFail($id);

        $request->validate([
            // Ignoramos el ID actual para la regla unique
            'nombre' => 'required|string|max:80|unique:genero,nombre,' . $genero->id_genero . ',id_genero',
            'activo' => 'required|boolean'
        ]);

        $genero->update($request->all());

        return redirect()->route('generos.index')->with('success', 'Género actualizado correctamente.');
    }

    public function destroy($id)
    {
        $genero = Genero::findOrFail($id);
        $genero->activo = !$genero->activo;
        $genero->save();

        $mensaje = $genero->activo ? 'Género activado.' : 'Género desactivado.';
        return redirect()->route('generos.index')->with('success', $mensaje);
    }
}