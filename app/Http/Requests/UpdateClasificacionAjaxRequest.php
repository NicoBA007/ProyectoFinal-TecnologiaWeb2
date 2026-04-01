<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClasificacionAjaxRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        // Capturamos el ID de la URL (Laravel suele usar el singular 'clasificacione' por defecto en español)
        $id = $this->route('clasificacione') ?? $this->route('clasificacion') ?? $this->segment(2);
        return [
            'codigo' => 'required|string|max:10|unique:clasificacion,codigo,' . $id . ',id_clasificacion',
            'descripcion' => 'required|string|max:100'
        ];
    }
}