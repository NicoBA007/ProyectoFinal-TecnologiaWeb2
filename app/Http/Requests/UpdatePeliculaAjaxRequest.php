<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeliculaAjaxRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $id = $this->route('pelicula') ?? $this->segment(2);
        return [
            'titulo' => 'required|string|max:150|unique:pelicula,titulo,' . $id . ',id_pelicula',
            'sinopsis' => 'required|string',
            'id_clasificacion' => 'required|integer|exists:clasificacion,id_clasificacion',
            'duracion_min' => 'required|integer|min:1',
            'estado' => 'required|in:Proximamente,En Emision,Ya Emitida',
            'poster_url' => 'required|url',
            'trailer_url' => 'nullable|url',
            'fecha_estreno' => 'required|date',
            'generos' => 'required|array|min:1',
            'generos.*' => 'integer|exists:genero,id_genero',
            'paises' => 'required|array|min:1',
            'paises.*' => 'integer|exists:pais_origen,id_pais_origen'
        ];
    }
}
