<?php

namespace App\Http\Requests;

use App\Rules\PasswordMatch;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => ['nullable', 'min:1', 'string', Rule::requiredIf(function () {
                return !empty($this->new_password);
            }),
                new PasswordMatch],
            'password' => 'nullable|string|min:1|different:current_password',
            'confirm_password' => 'nullable|string|same:password',
        ];

        return $rules;
    }
    public function messages()
    {
        return [
//            'current_password.password_match' => 'Vui lòng nhập mật khẩu hiện tại.',
            // Thêm thông báo lỗi tùy chỉnh cho các rule khác nếu cần
        ];
    }
}
