<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StorePaisAjaxRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return ['nombre' => 'required|string|max:100|unique:pais_origen,nombre'];
    }
}