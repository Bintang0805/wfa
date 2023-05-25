<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCompanyRequest extends FormRequest
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
      'name' => 'required|max:255',
      'short_name' => 'required|max:10',
      'email' => 'required|email',
      'domain' => ['required', 'regex:/^[a-zA-Z0-9]+([\-\.]{1}[a-zA-Z0-9]+)*\.[a-zA-Z]{2,}$/'],
      'company_url' => ['nullable', 'url'],
      'company_logo' => ['nullable', 'image', 'max:2048'],
      'phone_number' => 'nullable|max:10',
      'address' => 'required',
      'city' => 'nullable',
      'state' => 'nullable',
      'zip_code' => 'required|digits:6',
      'country' => 'required',
      'gstin' => 'nullable',
      'pan' => 'nullable',
    ];
  }

  public function messages()
  {
    return [
      'name.required' => 'The company name is required.',
      'name.max' => 'The company name may not be greater than 255 characters.',
      'short_name.required' => 'The short name is required.',
      'short_name.max' => 'The short name may not be greater than 10 characters.',
      'email.required' => 'The email address is required.',
      'email.email' => 'The email address must be a valid email address.',
      'domain.required' => 'The company domain is required.',
      'domain.not_starts_with' => 'The :attribute must not start with "http".',
      'domain.regex' => 'The :attribute must be a valid domain name like "example.com".',
      'company_logo.image' => 'The company logo must be an image',
      'company_logo.max' => 'The company logo may not be greater than :max kilobytes.',
      'phone_number.max' => 'The phone number may not be greater than 10 digits.',
      'address.required' => 'The company address is required.',
      'city.required' => 'The city is required.',
      'state.required' => 'The state is required.',
      'zip_code.required' => 'The ZIP code is required.',
      'zip_code.max' => 'The ZIP code may not be greater than :max characters.',
      'country.required' => 'The country is required.',
      'gstin.regex' => 'Please enter a valid GSTIN number.',
      'pan.regex' => 'Please enter a valid PAN number.',
    ];
  }
}
