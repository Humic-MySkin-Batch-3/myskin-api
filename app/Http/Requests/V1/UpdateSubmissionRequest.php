<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubmissionRequest extends FormRequest
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
        $method = $this->method();
        if ($method == 'PUT') {
            return [
                'doctorId' => ['required'],
                'status' => ['required', Rule::in(['pending', 'verified', 'rejected'])],
                'diagnosis' => ['required'],
                'doctorNote' => ['required'],
            ];
        } else {
            return [
                'doctorId' => ['required'],
                'status' => ['sometimes', 'required', Rule::in(['pending', 'verified', 'rejected'])],
                'diagnosis' => ['sometimes', 'required'],
                'doctorNote' => ['sometimes', 'required'],
                'complaint' => ['sometimes', 'required'],

            ];
        }
    }

    /**
    protected function prepareForValidation()
    {
        $mapped = [];

        if ($this->has('doctorId')) {
            $mapped['doctor_id'] = $this->input('doctorId');
        }
        if ($this->has('doctorNote')) {
            $mapped['doctor_note'] = $this->input('doctorNote');
        }
        if ($this->has('isSubmitted')) {
            $mapped['is_submitted'] = $this->input('isSubmitted');
        }

        $this->merge($mapped);
    } */

}
