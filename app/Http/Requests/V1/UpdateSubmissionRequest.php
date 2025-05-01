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
            ];
        }
    }

    protected function prepareForValidation()
    {
        $data = $this->all();
        if (isset($data['doctorId'])) {
            $data['doctor_id'] = $data['doctorId'];
        }
        if (isset($data['doctorNote'])) {
            $data['doctor_note'] = $data['doctorNote'];
        }
        $this->replace($data);
    }


}
