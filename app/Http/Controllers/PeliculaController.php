<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Clasificacion;
use App\Models\Genero;
use App\Models\Pais;
use App\Models\Persona;
use Illuminate\Http\Request;

class PeliculaController extends Controller
{
    /**
     * Muestra el catálogo de películas (Panel Admin)
     */
    public function index()
    {
        // Traemos las películas con su clasificación para evitar múltiples consultas (Eager Loading)
        $peliculas = Pelicula::with('clasificacion')->orderBy('id_pelicula', 'desc')->get();
        return view('peliculas.index', compact('peliculas'));
    }

    /**
     * Muestra el formulario para crear una película
     */
    public function create()
    {
        // Necesitamos mandar los catálogos a la vista para llenar los <select> y checkboxes
        $clasificaciones = Clasificacion::where('activo', true)->get();
        $generos = Genero::where('activo', true)->orderBy('nombre')->get();
        $paises = Pais::where('activo', true)->orderBy('nombre')->get();

        return view('peliculas.create', compact('clasificaciones', 'generos', 'paises'));
    }

    /**
     * Guarda la película y sus relaciones (N:M) de géneros y países
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:150',
            'sinopsis' => 'required|string',
            'id_clasificacion' => 'required|exists:clasificacion,id_clasificacion',
            'duracion_min' => 'required|integer|min:1',
            'estado' => 'required|in:Proximamente,En Emision,Ya Emitida',
            'poster_url' => 'required|url',
            'trailer_url' => 'required|url',
            'fecha_estreno' => 'required|date',
            'activo' => 'required|boolean',
            'generos' => 'nullable|array', 
            'paises' => 'nullable|array'   
        ]);

        // 1. Creamos la película (ignorando temporalmente los arrays de generos y paises)
        $pelicula = Pelicula::create($request->except(['generos', 'paises']));

        // 2. Sincronizamos las tablas intermedias (Magia de Laravel)
        if ($request->has('generos')) {
            $pelicula->generos()->sync($request->generos);
        }

        if ($request->has('paises')) {
            $pelicula->paises()->sync($request->paises);
        }

        // 3. Redirigimos a la vista de "Detalles" (show) para que el admin pueda agregar el elenco
        return redirect()->route('peliculas.show', $pelicula->id_pelicula)
            ->with('success', 'Película guardada. Ahora puedes asignar al elenco y staff.');
    }

    /**
     * Muestra los detalles de una película específica, su elenco y críticas
     */
    public function show($id)
    {
        // Traemos la película con TODAS sus relaciones armadas
        $pelicula = Pelicula::with(['clasificacion', 'generos', 'paises', 'personas', 'criticas.usuario'])
            ->findOrFail($id);

        // Catálogo de personas para el <select> de "Agregar al elenco"
        $personas = Persona::where('activo', true)->orderBy('nombre_completo')->get();

        return view('peliculas.show', compact('pelicula', 'personas'));
    }

    /**
     * Muestra el formulario para editar la película base
     */
    public function edit($id)
    {
        $pelicula = Pelicula::with(['generos', 'paises'])->findOrFail($id);

        $clasificaciones = Clasificacion::where('activo', true)->get();
        $generos = Genero::where('activo', true)->orderBy('nombre')->get();
        $paises = Pais::where('activo', true)->orderBy('nombre')->get();

        return view('peliculas.edit', compact('pelicula', 'clasificaciones', 'generos', 'paises'));
    }

    /**
     * Actualiza la película y sus relaciones (N:M)
     */
    public function update(Request $request, $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:150',
            'sinopsis' => 'required|string',
            'id_clasificacion' => 'required|exists:clasificacion,id_clasificacion',
            'duracion_min' => 'required|integer|min:1',
            'estado' => 'required|in:Proximamente,En Emision,Ya Emitida',
            'poster_url' => 'required|url',
            'trailer_url' => 'required|url',
            'fecha_estreno' => 'required|date',
            'activo' => 'required|boolean',
            'generos' => 'nullable|array',
            'paises' => 'nullable|array'
        ]);

        $pelicula->update($request->except(['generos', 'paises']));

        // El método sync() actualiza automáticamente la tabla pivote borrando los que ya no están y agregando los nuevos
        $pelicula->generos()->sync($request->generos ?? []);
        $pelicula->paises()->sync($request->paises ?? []);

        return redirect()->route('peliculas.show', $pelicula->id_pelicula)
            ->with('success', 'Datos de la película actualizados.');
    }

    /**
     * Desactiva la película 
     */
    public function destroy($id)
    {
        $pelicula = Pelicula::findOrFail($id);
        $pelicula->activo = !$pelicula->activo;
        $pelicula->save();

        $mensaje = $pelicula->activo ? 'Película reactivada.' : 'Película archivada.';
        return redirect()->route('peliculas.index')->with('success', $mensaje);
    }
}