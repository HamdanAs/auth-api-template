<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseApiRequest;

class RegisterUserRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'  => 'required|string|min:3|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|confirmed|min:6'
        ];
    }
}
