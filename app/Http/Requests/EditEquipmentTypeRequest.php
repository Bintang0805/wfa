<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditEquipmentTypeRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'equipment_type' => ['required'],
    ];
  }

  public function messages()
  {
    return [
      'equipment_type.required' => 'the Equipment Type is a required',
    ];
  }
}
