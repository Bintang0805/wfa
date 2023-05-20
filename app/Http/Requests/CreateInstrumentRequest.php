<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInstrumentRequest extends FormRequest
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
      'instrument_type_id' => ['required'],
      'instrument_name' => ['required', 'unique:instruments,instrument_name,'.$this->request->get("id")],
      'instrument_make' => ['required'],
      'instrument_model' => ['required'],
      'data_storage' => ['required'],
      'indirect_impact' => ['required'],
      'qualification_status' => ['required'],
      'csv_status' => ['required'],
      'computer_connected' => ['required'],
      'instrument_asset_code' => ['required'],
      'status' => ['required'],
    ];
  }

  public function messages()
  {
    return [
      'department_id.required' => 'the Department is required',
      'instrument_type_id.required' => 'the Instrument Type is required',
      'instrument_name.required' => 'the Instrument Name is required',
      'instrument_name.unique' => 'the Instrument Name must unique',
      'instrument_make.required' => 'the Instrument Make is required',
      'instrument_model.required' => 'the Instrument Model is required',
      'data_storage.required' => 'the Data Storage is required',
      'indirect_impact.required' => 'the Indirect Impact is required',
      'qualification_status.required' => 'the Qualification Status is required',
      'csv_status.required' => 'the CSV Status is required',
      'computer_connected.required' => 'the Computer Connected is required',
      'instrument_asset_code.required' => 'the Instrument Asset Code is required',
      'status.required' => 'the Status is required',
    ];
  }
}
