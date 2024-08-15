<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerRequest extends FormRequest
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
        $customerId = $this->route()->customer;

        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [
                    'user_pic_id' => 'required|exists:users,id',
                    'opportunity_state_id' => 'required|exists:opportunity_states,id',
                    'customer_name' => 'required|string|max:255',
                    'company_name' => 'required|string|max:255',
                    'company_address' => 'required|string|max:255',
                    'company_email' => 'required|string|email|max:255|unique:customers,company_email|unique:users,email',
                    'company_phone' => 'required|string|max:255|unique:customers,company_phone|unique:users,phone',
                    'company_pic_name' => 'required|string|max:255',
                    'company_pic_address' => 'required|string|max:255',
                    'company_pic_email' => 'required|string|email|max:255|unique:customers,company_pic_email|unique:users,email',
                    'company_pic_phone' => 'required|string|max:255|unique:customers,company_pic_phone|unique:users,phone',
                    'description' => 'nullable|string',
                ];
                break;
            case 'patch':
                $rules = [
                    'user_pic_id' => 'required|exists:users,id',
                    'opportunity_state_id' => 'required|exists:opportunity_states,id',
                    'customer_name' => 'required|string|max:255',
                    'company_name' => 'required|string|max:255',
                    'company_address' => 'required|string|max:255',
                    'company_email' => 'required|string|email|max:255|unique:users,email|unique:customers,company_email,' . $customerId,
                    'company_phone' => 'required|string|max:255|unique:users,phone|unique:customers,company_phone,' . $customerId,
                    'company_pic_name' => 'required|string|max:255',
                    'company_pic_address' => 'required|string|max:255',
                    'company_pic_email' => 'required|string|email|max:255|unique:users,email|unique:customers,company_pic_email,' . $customerId,
                    'company_pic_phone' => 'required|string|max:255|unique:users,phone|unique:customers,company_pic_phone,' . $customerId,
                    'description' => 'nullable|string',
                ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'customer_name.max' => 'Customer Name is too long.',
            'company_name.max' => 'Company Name is too long.',
            'company_address.max' => 'Company Address is too long.',
            'company_email.max' => 'Company Email is too long.',
            'company_phone.max' => 'Company Phone is too long.',
            'company_pic_name.max' => 'Company PIC Name is too long.',
            'company_pic_address.max' => 'Company PIC Address is too long.',
            'company_pic_email.max' => 'Company PIC Email is too long.',
            'company_pic_phone.max' => 'Company PIC Phone is too long.',
            'company_email.unique' => 'The company email has already been taken.',
            'company_phone.unique' => 'The company phone has already been taken.',
            'company_pic_email.unique' => 'The company PIC email has already been taken.',
            'company_pic_phone.unique' => 'The company PIC phone has already been taken.',
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
