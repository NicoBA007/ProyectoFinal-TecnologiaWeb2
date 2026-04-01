<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneroAjaxRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        $generoId = $this->route('genero');
        return ['nombre' => 'required|string|max:80|unique:genero,nombre,' . $generoId . ',id_genero'];
    }
}