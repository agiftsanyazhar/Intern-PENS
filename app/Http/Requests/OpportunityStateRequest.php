<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\BaseRequest;

class OpportunityStateRequest extends BaseRequest
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
                    'customer_id' => 'required|exists:customers,id',
                    'opportunity_value' => 'required|numeric',
                    'title' => 'required|string|max:255',
                    'description' => 'required|string',
                ];
                break;
            case 'patch':
                $rules = [
                    'customer_id' => 'required|exists:customers,id',
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
}
