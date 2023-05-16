<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateApplicationRequest extends FormRequest
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
        'application_name' => ['required'],
        'application_ver' => ['required'],
        'connected_to_computer' => ['required'],
        'department_id' => ['required'],
        'connected_to_server' => ['required'],
        'application_role_type' => ['required'],
        'privilages' => ['required'],
        'manufacturer' => ['required'],
        'gamp_category' => ['required'],
        'csv_status' => ['required'],
        'csv_completed_on' => ['required'],
        'periodic_review' => ['required'],
        'gxp_status' => ['required'],
        'backup_mode' => ['required'],
        'data_type' => ['required'],
        'vendor_details' => ['required'],
        'status' => ['required'],
      ];
    }

    public function messages()
    {
      return [
        'application_name' => "the Application Name is required",
        'application_ver' => "the Applicaiton Ver is required",
        'connected_to_computer' => "the Connected To Computer is required",
        'department_id' => "the Department is required",
        'connected_to_server' => "the Connected To Server is required",
        'application_role_type' => "the Application Role Type is required",
        'privilages' => "the Privilages is required",
        'manufacturer' => "the Manufacturer is required",
        'gamp_category' => "the Gamp Category is required",
        'csv_status' => "the CSV Status is required",
        'csv_completed_on' => "the CSV Completed On is required",
        'periodic_review' => "the Periodic Review is required",
        'gxp_status' => "the GXP Status is required",
        'backup_mode' => "the Backup Mode is required",
        'data_type' => "the Data Type is required",
        'vendor_details' => "the Vendor Details is required",
        'status' => "the Status is required",
      ];
    }
}
