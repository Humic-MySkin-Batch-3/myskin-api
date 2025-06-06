<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => ['required','string'],
            'email'    => ['required','email','unique:accounts,email'],
            'phone'    => ['required','string','unique:accounts,phone'],
            'dob'      => ['required','date'],
            'password' => ['required','min:6','confirmed'],
            //'role'     => ['required', Rule::in(['patient','doctor'])],
        ];
    }
}
