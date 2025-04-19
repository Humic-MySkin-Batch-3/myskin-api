<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'integer'],
            'doctor_id'  => ['sometimes', 'integer'],
            'image'      => ['required', 'image', 'max:2048'],
            'complaint'  => ['sometimes', 'string'],
            'status'     => ['sometimes', Rule::in(['pending','verified','rejected'])],
            'diagnosis'  => ['sometimes','string'],
            'doctor_note'=> ['sometimes','string'],
            'submitted_at' => ['sometimes','date'],
            'verified_at'  => ['sometimes','date'],
        ];
    }
}
