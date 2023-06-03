<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkflowApproverRequest extends FormRequest
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
      "workflow_id" => ["required"],
      "approver_roles" => ["required"],
    ];
  }

  public function messages()
  {
    return [
      "workflow_id.required" => "the Workflow is a required",
      "approver_roles.required" => "the Approver Roles is a required",
    ];
  }
}
