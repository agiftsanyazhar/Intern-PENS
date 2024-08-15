<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $method = strtolower($this->method());
        $userId = $this->route()->user;

        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email|unique:customers,email',
                    'password' => 'required|string|min:8|confirmed',
                    'phone' => 'required|string|max:255|unique:users,phone|unique:customers,phone',
                    'role' => 'required|exists:roles,id',
                    'note' => 'nullable|string|max:255',
                ];
                break;
            case 'patch':
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:customers,email|unique:users,email,' . $userId,
                    'password' => 'confirmed|min:8|nullable',
                    'phone' => 'required|string|max:255|unique:customers,phone|unique:users,phone,' . $userId,
                    'role' => 'required|exists:roles,id',
                    'note' => 'nullable|string|max:255',
                ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.max' => 'Name is too long.',
            'email.max' => 'Email is too long.',
            'phone.max' => 'Phone is too long.',
            'email.unique' => 'The email has already been taken.',
            'phone.unique' => 'The phone has already been taken.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }

    /**
     * @param Validator $validator
     */
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
