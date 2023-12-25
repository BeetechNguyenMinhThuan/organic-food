<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'bail|required|max:255|unique:sliders',
            'image' => 'file|mimes:jpeg,jpg,png|max:3072',
        ];

        if ($this->isMethod('PUT')) {
            $rules['name'] = ['bail', 'required', 'max:255', Rule::unique('sliders')->ignore(request('id'))];
        }

        return $rules;
    }
}
