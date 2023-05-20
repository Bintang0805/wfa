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
        'application_name' => ['required', 'unique:applications,application_name,'.$this->request->get("id")],
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
        'application_name.required' => "the Application Name is required",
        'application_name.unique' => "the Application Name must unique",
        'application_ver.required' => "the Applicaiton Ver is required",
        'connected_to_computer.required' => "the Connected To Computer is required",
        'department_id.required' => "the Department is required",
        'connected_to_server.required' => "the Connected To Server is required",
        'application_role_type.required' => "the Application Role Type is required",
        'privilages.required' => "the Privilages is required",
        'manufacturer.required' => "the Manufacturer is required",
        'gamp_category.required' => "the Gamp Category is required",
        'csv_status.required' => "the CSV Status is required",
        'csv_completed_on.required' => "the CSV Completed On is required",
        'periodic_review.required' => "the Periodic Review is required",
        'gxp_status.required' => "the GXP Status is required",
        'backup_mode.required' => "the Backup Mode is required",
        'data_type.required' => "the Data Type is required",
        'vendor_details.required' => "the Vendor Details is required",
        'status.required' => "the Status is required",
      ];
    }
}
