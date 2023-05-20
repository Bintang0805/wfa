<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInstrumentTypeRequest extends FormRequest
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
      'instrument_type' => ['required', 'unique:instrument_types,instrument_type,'.$this->request->get("id")],
    ];
  }

  public function messages()
  {
    return [
      'instrument_type.required' => 'the Instrument Type is a required',
      'instrument_type.unique' => 'the Instrument Type must unique',
    ];
  }
}
