<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateItAssetTypeRequest extends FormRequest
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
      'it_asset_type' => ['required', 'unique:it_asset_types,it_asset_type,'.$this->request->get("id")],
    ];
  }

  public function messages()
  {
    return [
      'it_asset_type.required' => 'the It Asset Type is a required',
      'it_asset_type.unique' => 'the It Asset Type must unique',
    ];
  }
}
