<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDepartmentRequest extends FormRequest
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
      'facility_id' => ['required'],
      'department' => ['required'],
    ];
  }

  public function messages()
  {
    return [
      'facility_id.required' => 'the Facility is a required',
      'department.required' => 'the Department is a required',
    ];
  }
}
