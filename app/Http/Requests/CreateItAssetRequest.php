<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateItAssetRequest extends FormRequest
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
        'it_asset_type_id' => ['required'],
        'make' => ['required'],
        'model' => ['required'],
        'oem_sl_no' => ['required'],
        'host_name' => ['required', 'unique:it_assets,host_name'],
        'ip_address' => ['required', 'unique:it_assets,ip_address'],
        'asset_type' => ['required'],
        'os_ver' => ['required'],
        'asset_status' => ['required'],
        'owner_name' => ['required'],
      ];
    }

    public function messages()
    {
      return [
        "department_id.required" => "the Department is a required",
        "it_asset_type_id.required" => "the It Asset Type is a required",
        "make.required" => "the It Asset Make is a required",
        "model.required" => "the It Asset Model is a required",
        "oem_sl_no.required" => "the It Asset OEM SL No is a required",
        "host_name.required" => "the It Asset Host Name is a required",
        "host_name.unique" => "the It Asset Host Name must unique",
        "ip_address.required" => "the It Asset IP Address is a required",
        "ip_address.unique" => "the It Asset IP Address must unique",
        "asset_type.required" => "the Asset Type is a required",
        "os_ver.required" => "the OS Ver is a required",
        "asset_status.required" => "the Asset Status is a required",
        "owner_name.required" => "the Owner Name is a required",
      ];
    }
}
