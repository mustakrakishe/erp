<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'bail',
                'required',
                'string',
                'max:255',
                'unique:products',
            ],
            'description' => [
                'string',
                'nullable',
                'max:255',
            ],
            'price' => [
                'required',
                'decimal:2',
                'max:999999.99',
            ],
        ];
    }

    protected function passedValidation()
    {
        $this->merge([
            'owner_id' => $this->user()->id,
        ]);
    }
}
