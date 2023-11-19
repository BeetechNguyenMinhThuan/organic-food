<?php

namespace App\Http\Requests;

use App\Rules\MatchSecurityCode;
use App\Rules\UserEmailMatch;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
        return [
            'email' => ['required', new UserEmailMatch],
            'security_code' => ['required', new MatchSecurityCode()]
        ];
    }
}
