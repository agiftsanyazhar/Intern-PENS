<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OpportunityStateRequest extends FormRequest
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
        $opportunityId = $this->route()->opportunity;

        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [
                    'customer_id' => 'required|exists:customers,id',
                    'opportunity_status_id' => 'required|integer',
                    'opportunity_value' => 'required|numeric',
                    'title' => 'required|string|max:255',
                    'description' => 'required|string',
                ];
                break;
            case 'patch':
                $rules = [
                    'customer_id' => 'required|exists:customers,id',
                    'opportunity_status_id' => 'required|integer',
                    'opportunity_value' => 'required|numeric',
                    'title' => 'required|string|max:255',
                    'description' => 'required|string',
                ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'title.max' => 'Opportunity Status Name is too long.',
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
