<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        $rules = [
            'name' => 'bail|required|max:255',
            'weight' => 'bail|required|max:255',
            'price' => 'required',
            'stock' => 'required|min:0|max:10000|integer',
            'expired_at' => ['date', 'after:' . now()],
            'discount' => 'max:100',
            'avatar' => 'required|file|mimes:jpeg,jpg,png|max:3072',
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['regex:/^[a-zA-Z0-9 ]+$/', 'required', 'min:10', 'max:20', 'unique:products'],
        ];

        if ($this->isMethod('PUT')) {
            $rules['avatar'] = 'file|mimes:jpeg,jpg,png|max:3072';
            $rules['sku'] = ['regex:/^[a-zA-Z0-9 ]+$/', 'required', 'min:10', 'max:20', Rule::unique('products')->ignore(request('id'))];
        }

        return $rules;
    }
}
