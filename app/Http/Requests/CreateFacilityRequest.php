<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFacilityRequest extends FormRequest
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
      'location_id' => ['required'],
      'facility_name' => ['required'],
    ];
  }

  public function messages()
  {
    return [
      'location_id.required' => 'the Location is a required',
      'facility_name.required' => 'the Facility Name is a required',
    ];
  }
}
