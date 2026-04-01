<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreClasificacionAjaxRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'codigo' => 'required|string|max:10|unique:clasificacion,codigo',
            'descripcion' => 'required|string|max:100'
        ];
    }
}