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
      "initiation_role" => ["required"],
      "worker_roles" => ["required"],
      // "email_reminder" => ["required"],
      // "web_notification" => ["required"],
    ];
  }

  public function messages()
  {
    return [
      "name.required" => "the Name is required",
      "initiation_role.required" => "the Initiation Role is required",
      "worker_roles.required" => "the Worker Roles is required",
      // "email_reminder.required" => "the Email Reminder is required",
      // "web_notification.required" => "the Web Notification is required",
    ];
  }
}
