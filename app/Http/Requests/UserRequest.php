<?php

namespace App\Http\Requests;

use App\Http\Requests\Abstracts\BaseRequest;


class UserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $method = strtolower($this->method());
        $userId = $this->route()->user;

        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email',
                    'password' => 'required|string|min:8|confirmed',
                    'phone' => 'required|string|max:255|unique:users,phone',
                    'role_id' => 'required|exists:roles,id',
                    'note' => 'nullable|string|max:255',
                ];
                break;
            case 'patch':
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
                    'password' => 'confirmed|min:8|nullable',
                    'phone' => 'nullable|string|max:255|unique:users,phone,' . $userId,
                    'role_id' => 'required|exists:roles,id',
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
}
