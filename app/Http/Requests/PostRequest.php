<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['slug'] = ['nullable', 'string', 'max:255', 'unique:posts,slug,' . $this->route('post')];
        } else {
            $rules['slug'] = ['nullable', 'string', 'max:255', 'unique:posts,slug'];
        }

        return $rules;
    }
}
