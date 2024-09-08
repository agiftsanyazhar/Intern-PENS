<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\BaseRequest;

class HealthRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = strtolower($this->method());

        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [
                    'status_health' => 'required|string|max:255',
                    'day_parameter_value' => 'required|integer',
                ];
                break;
            case 'patch':
                $rules = [
                    'status_health' => 'required|string|max:255',
                    'day_parameter_value' => 'required|integer',
                ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'status_health.max' => 'Status Health is too long.',
        ];
    }
}
