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
                    'opportunity_status' => 'required|string|max:255|unique:opportunity_states,opportunity_status',
                    'note' => 'nullable|string|max:255',
                ];
                break;
            case 'patch':
                $rules = [
                    'opportunity_status' => 'required|string|max:255|unique:opportunity_states,opportunity_status,' . $opportunityId,
                    'note' => 'nullable|string|max:255',
                ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'opportunity_status.max' => 'Opportunity Status Name is too long.',
            'note.max' => 'Note is too long.',
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
