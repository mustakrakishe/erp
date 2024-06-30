<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login'    => 'required|string|max:255',
            'password' => 'required|string|between:8,255',
        ];
    }
}
