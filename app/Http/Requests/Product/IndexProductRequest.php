<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\PaginationableRequest;
use App\Models\Product;
use App\Models\User;
use App\Services\UserService;
use Closure;
use Illuminate\Validation\Rule;

class IndexProductRequest extends PaginationableRequest
{
    public User $owner;

    protected function prepareForValidation()
    {
        if (!$this->input('owner_id')) {
            $this->merge([
                'owner_id' => $this->user()->id,
            ]);
        }
    }

    public function rules(): array
    {
        return parent::rules() + [
            'owner_id' => [
                'bail',
                Rule::when(
                    $this->user()->id != $this->input('owner_id'),
                    'int'
                ),
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->user()->id == $value) {
                        $this->owner = $this->user();

                        return;
                    }

                    if (!$this->owner = User::find($value)) {
                        $fail('The user with this id not found.');
                    }
                },
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->user()->id == $value) {
                        return;
                    }

                    if (!UserService::containsInSubordinateTree($this->user(), $this->owner)) {
                        $fail('You must contain the user with this id in your subordinate tree.');
                    }
                },
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->owner->cannot('have', Product::class)) {
                        $fail('The user with this id can not have products.');
                    }
                },
            ],
        ];
    }
}
