<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\BaseRequest;

class OpportunityStateDetailRequest extends BaseRequest
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
                    'opportunity_state_id' => 'required|integer|exists:opportunity_states,id',
                    'opportunity_status_id' => 'required|integer',
                    'description' => 'required|string',
                ];
                break;
            case 'patch':
                $rules = [
                    'opportunity_state_id' => 'required|integer|exists:opportunity_states,id',
                    'opportunity_status_id' => 'required|integer',
                    'description' => 'required|string',
                ];
                break;
        }

        return $rules;
    }
}
