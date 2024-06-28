<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    public User $superior;

    protected function prepareForValidation()
    {
        if (!$this->has('superior_id')) {
            $this->merge([
                'superior_id' => $this->user()->id,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'login' => [
                'bail',
                'required',
                'string',
                'max:255',
                'unique:users',
            ],
            'password' => [
                'required',
                'string',
                'between:8,255',
            ],
            'superior_id' => [
                'bail',
                Rule::when(
                    $this->user()->id != $this->input('superior_id'),
                    'int'
                ),
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->user()->id === $value) {
                        $this->superior = $this->user();

                        return;
                    }

                    if (!$this->superior = User::find($value)) {
                        $fail('The user with this id not found.');
                    }
                },
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->user()->id === $value) {
                        return;
                    }

                    if (!UserService::containsInSubordinateTree($this->user(), $this->superior)) {
                        $fail('You must contain the user with this id in your subordinate tree.');
                    }
                },
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->superior->cannot('have', User::class)) {
                        $fail('The user with this id can not have subordinates.');
                    }
                },
            ],
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'role' => RoleService::getSubordinateRole($this->superior->role),
        ]);
    }
}
