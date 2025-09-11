<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = array_merge($rules['name'], ['unique:categories,name,' . $this->route('category')]);
        } else {
            $rules['name'] = array_merge($rules['name'], ['unique:categories,name']);
        }

        return $rules;
    }
}
