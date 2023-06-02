<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestFormRequest extends FormRequest
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
            "name" => ["required"],
            "fields" => ["required"],
        ];
    }

    public function messages()
    {
      return [
        "workflow_id.required" => "the Workflow is a required",
        "name.required" => "the Form Name is a required",
        "fields.required" => "the Form Fields is a required",
      ];
    }
}