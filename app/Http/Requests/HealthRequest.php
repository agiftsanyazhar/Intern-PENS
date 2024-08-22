<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HealthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = strtolower($this->method());
        $healthId = $this->route()->health;

        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [
                    'status_health' => 'required|string|max:255',
                    'level_health' => 'required|string|max:255',
                ];
                break;
            case 'patch':
                $rules = [
                    'status_health' => 'required|string|max:255',
                    'level_health' => 'required|string|max:255',
                ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'status_health.max' => 'Company Name is too long.',
            'level_health.max' => 'Company Address is too long.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $data = [
            'status' => true,
            'message' => $validator->errors()->first(),
            'all_message' =>  $validator->errors()
        ];

        if ($this->ajax()) {
            throw new HttpResponseException(response()->json($data, 422));
        } else {
            throw new HttpResponseException(redirect()->back()->withInput()->with('errors', $validator->errors()));
        }
    }
}
