<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEquipmentRequest extends FormRequest
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
      'department_id' => ['required'],
      'equipment_type_id' => ['required'],
      'equipment_name' => ['required'],
      'equipment_make' => ['required'],
      'equipment_model' => ['required'],
      'data_storage' => ['required'],
      'indirect_impact' => ['required'],
      'qualification_status' => ['required'],
      'csv_status' => ['required'],
      'equipment_number' => ['required'],
      'status' => ['required'],
    ];
  }

  public function messages()
  {
    return [
      'department_id.required' => 'the Department is required',
      'equipment_type_id.required' => 'the Equipment Type is required',
      'equipment_name.required' => 'the Equipment Name is required',
      'equipment_make.required' => 'the Equipment Make is required',
      'equipment_model.required' => 'the Equipment Model is required',
      'data_storage.required' => 'the Data Storage is required',
      'indirect_impact.required' => 'the Indirect Impact is required',
      'qualification_status.required' => 'the Qualification Status is required',
      'csv_status.required' => 'the CSV Status is required',
      'equipment_number.required' => 'the Equipment Number is required',
      'status.required' => 'the Status is required',
    ];
  }
}
