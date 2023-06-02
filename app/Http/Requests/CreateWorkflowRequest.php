<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkflowRequest extends FormRequest
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
      "name" => ["required"],
      "description" => ["required"],
      // "initiation_role",
      // "leave_of_approvers",
      // "worker_roles",
      // "status",
      // "email_reminder",
      // "web_notification",
      // "associated_form",
    ];
  }

  public function messages()
  {
    return [
      "name.required" => "the Name is required",
      "description.required" => "the Description is required",
    ];
  }
}
