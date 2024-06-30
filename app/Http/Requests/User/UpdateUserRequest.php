<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public User $superior;

    public function rules(): array
    {
        return [
            'login' => [
                'bail',
                'string',
                'max:255',
                Rule::unique('users')->ignore($this->route('user')),
            ],
            'password' => [
                'string',
                'between:8,255',
            ],
            'superior_id' => [
                'bail',
                'int',
                Rule::prohibitedIf($this->user()->is($this->route('user'))),
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->route('user')->id === $value) {
                        $fail('An user can not be assigned as his own superior.');
                    }
                },
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
                function (string $attribute, mixed $value, Closure $fail): void {
                    if (
                        $this->route('user')->subordinates()->doesntExist() &&
                        $this->route('user')->products()->doesntExist()
                    ) {
                        return;
                    }

                    if (RoleService::getSubordinateRole($this->superior->role) !== $this->route('user')->role) {
                        $fail('The user with this id must have a role 1 point higher priority than the user to update has when this user has own subordinates.');
                    }
                },
            ],
        ];
    }

    protected function passedValidation()
    {
        if (isset($this->superior)) {
            $this->merge([
                'role' => RoleService::getSubordinateRole($this->superior->role),
            ]);
        }
    }
}
