<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorUpdateSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diagnosis'   => ['required', Rule::in(['Melanoma', 'Bukan Melanoma'])],
            'doctorNote'  => ['required','string'],
        ];
    }

}
