<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLocationRequest extends FormRequest
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
      'company_id' => ['required'],
      'location_name' => ['required', 'unique:locations,location_name,'.$this->request->get("id")],
    ];
  }

  public function messages()
  {
    return [
      'company_id.required' => 'the Company is a required',
      'location_name.required' => 'the Location Name is a required',
      'location_name.unique' => 'the Location Name must unique',
    ];
  }
}
