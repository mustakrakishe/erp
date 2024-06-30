<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'bail',
                'string',
                'max:255',
                Rule::unique('products')->ignore($this->route('product')),
            ],
            'description' => [
                'string',
                'nullable',
                'max:255',
            ],
            'price' => [
                'decimal:0,2',
                'between:0,999999.99',
            ],
        ];
    }
}
