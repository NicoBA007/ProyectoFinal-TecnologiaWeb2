<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaisAjaxRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }
  public function rules(): array
  {
    $id = $this->route('paise') ?? $this->route('pais') ?? $this->segment(2);
    return ['nombre' => 'required|string|max:100|unique:pais_origen,nombre,' . $id . ',id_pais_origen'];
  }
}