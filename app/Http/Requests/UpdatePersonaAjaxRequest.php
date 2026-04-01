<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonaAjaxRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'nombre_completo' => 'required|string|max:150',
            'foto_url' => 'required|url'
        ];
    }
}